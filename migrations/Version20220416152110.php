<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416152110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        //Generamos algunos datos de prueba para comprobar el correcto funcionamiento de EasyAdmin 
        $this->addSql("INSERT INTO producer (name) VALUES ('Regency Television'),('Canal +')");
        $this->addSql("INSERT INTO genre (name) VALUES ('Drama'),('Aventuras')");
        $this->addSql("INSERT INTO actor (name, birth_date) VALUES ('Alexander Skarsgård', '1976-08-25'),('Denis Lavant', '1931-06-17')");
        $this->addSql("INSERT INTO director (name, birth_date) VALUES ('Robert Eggers', '1983-07-07'), ('Fanny Liatard', '1965-03-25')");
        $this->addSql("INSERT INTO movies (title, publication_date, duration, producer_id) VALUES ('The Northman', '2022-04-22', 136, 1),('Gagarine', '2020-01-17', 95, 2)");
        $this->addSql("INSERT INTO movies_actor (movies_id, actor_id) VALUES (1, 1), (2, 2)");
        $this->addSql("INSERT INTO movies_director (movies_id, director_id) VALUES (1, 1), (2, 2)");
        $this->addSql("INSERT INTO movies_genre (movies_id, genre_id) VALUES (1, 1), (2, 2)");


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
