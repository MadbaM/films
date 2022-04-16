<?php

namespace App\Controller\Admin;

use App\Entity\Movies;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class MoviesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movies::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // Configuramos los campos a visualizar y el formato en el cual queremos que se muestren
        return [
            TextField::new('title')
                ->setLabel('Título'),
            DateField::new('publicationDate')
                ->setFormat('yyyy')
                ->setLabel('Fecha de publicación'),
            AssociationField::new('genre')
                ->setRequired(true)
                ->setLabel('Género(s)')
                ->formatValue(function($value, $entity){return $this->getRealNames($entity, 'genre');}),
            IntegerField::new('duration')
                ->setLabel('Duración (min.)'),
            AssociationField::new('producer')
                ->setRequired(true)
                ->setLabel('Productora'),
            AssociationField::new('actor')
                ->setRequired(true)
                ->setLabel('Actor(es)')
                ->formatValue(function($value, $entity){return $this->getRealNames($entity, 'actor');}),
            AssociationField::new('director')
                ->setRequired(true)
                ->setLabel('Director(es)')
                ->formatValue(function($value, $entity){return $this->getRealNames($entity, 'director');}),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        // Eliminamos las acciones que no deseamos del crud
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        // Seteamos los campos en los que queremos que sea efectiva la busqueda y los nombres de las paginas mostradas
        return $crud->setSearchFields(['title', 'genre.name', 'producer.name', 'actor.name', 'director.name'])
        ->setPageTitle(Crud::PAGE_INDEX, 'Películas');
    }

    //Función para mostrar el nombre del campo asociado
    public function getRealNames($entity, $name): string
    {
        $method = 'get'.$name;
        $str = $entity->$method()[0];
        for ($i = 1; $i < $entity->$method()->count(); $i++) {
            $str = $str . ", " . $entity->$method()[$i];
        }
        return $str;
    }
    
}
