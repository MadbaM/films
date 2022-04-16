<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

use App\Entity\Movies;
use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Genre;
use App\Entity\Producer;

use Doctrine\Persistence\ManagerRegistry;

#[AsCommand(
    name: 'add-movies',
    description: 'Import movies from CSV file',
)]
class AddMoviesCommand extends Command
{
    private $entityManager;
    private $managerRegistry;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('csv_route', InputArgument::REQUIRED, 'Route of the CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $csvRoute = $input->getArgument('csv_route');

        $decoder = new Serializer([new ObjectNormalizer()],[new CsvEncoder()]);

        $moviesCsv = $decoder->decode(file_get_contents($csvRoute), 'csv');

        $em = $this->entityManager;

        foreach($moviesCsv as $movieCsv){
            try{
                $movie = new Movies();

                //Fecha de publicación formateada
                $date = new \DateTime($movieCsv['date_published']);
                //Insertamos los datos base de la pelicula
                $movie->setTitle($movieCsv['title'])
                      ->setPublicationDate($date)
                      ->setDuration($movieCsv['duration']);
                
                //Agregamos la productora -- En caso de no existir previamente en base de datos, la creamos
                if($existingProducer = $em->getRepository(Producer::class)->findOneBy(['name' => $movieCsv['production_company']])){
                    $movie->setProducer($existingProducer);
                }else{
                    $producer = new Producer();
                    $producer->setName($movieCsv['production_company']);
                    $em->persist($producer);
                    $movie->setProducer($producer);
                }
                //Agregamos genero(s) -- En caso de no existir previamente en base de datos, lo creamos
                $genresCsv = explode(",", $movieCsv['genre']);
                foreach($genresCsv as $genreCsv){
                    if($existingGenre = $em->getRepository(Genre::class)->findOneBy(['name' => $genreCsv])){
                        $movie->addGenre($existingGenre);
                    }else{
                        $genre = new Genre();
                        $genre->setName($genreCsv);
                        $em->persist($genre);
                        $movie->addGenre($genre);
                    }
                }
                
                //Agregamos actor(es) -- En caso de no existir previamente en base de datos, lo creamos
                $actorsCsv = explode(",", $movieCsv['actors']);
                foreach($actorsCsv as $actorCsv){
                    if($existingActor = $em->getRepository(Actor::class)->findOneBy(['name' => $actorCsv])){
                        $movie->addActor($existingActor);
                    }else{
                        $actor = new Actor();
                        $actor->setName($actorCsv);
                        $em->persist($actor);
                        $movie->addActor($actor);
                    }
                }
                
                //Agregamos director(es) -- En caso de no existir previamente en base de datos, lo creamos
                $directorsCsv = explode(",", $movieCsv['director']);
                foreach($directorsCsv as $directorCsv){
                    if($existingDirector = $em->getRepository(Director::class)->findOneBy(['name' => $directorCsv])){
                        $movie->addDirector($existingDirector);
                    }else{
                        $director = new Director();
                        $director->setName($directorCsv);
                        $em->persist($director);
                        $movie->addDirector($director);
                    }
                }
                
                $em->persist($movie);
                $em->flush();
            }catch(\Exception $e){
                $output->writeln('La pelicula con el siguiente id no se insertará en la base de datos: '.$movieCsv['imdb_title_id'].' debido a: '.$e->getMessage());
                $this->managerRegistry->resetManager();
            }
        }
        
        $io->success('End!');

        return Command::SUCCESS;
    }

}