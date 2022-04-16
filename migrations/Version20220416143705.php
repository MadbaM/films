<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416143705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, death_date DATE DEFAULT NULL, birth_place VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, producer_id INT NOT NULL, title VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, duration INT NOT NULL, INDEX IDX_C61EED3089B658FE (producer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_genre (movies_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_F8B211F953F590A4 (movies_id), INDEX IDX_F8B211F94296D31F (genre_id), PRIMARY KEY(movies_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_actor (movies_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_3F9774F853F590A4 (movies_id), INDEX IDX_3F9774F810DAF24A (actor_id), PRIMARY KEY(movies_id, actor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_director (movies_id INT NOT NULL, director_id INT NOT NULL, INDEX IDX_F6E47CC853F590A4 (movies_id), INDEX IDX_F6E47CC8899FB366 (director_id), PRIMARY KEY(movies_id, director_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED3089B658FE FOREIGN KEY (producer_id) REFERENCES producer (id)');
        $this->addSql('ALTER TABLE movies_genre ADD CONSTRAINT FK_F8B211F953F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_genre ADD CONSTRAINT FK_F8B211F94296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_actor ADD CONSTRAINT FK_3F9774F853F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_actor ADD CONSTRAINT FK_3F9774F810DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_director ADD CONSTRAINT FK_F6E47CC853F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_director ADD CONSTRAINT FK_F6E47CC8899FB366 FOREIGN KEY (director_id) REFERENCES director (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_actor DROP FOREIGN KEY FK_3F9774F810DAF24A');
        $this->addSql('ALTER TABLE movies_director DROP FOREIGN KEY FK_F6E47CC8899FB366');
        $this->addSql('ALTER TABLE movies_genre DROP FOREIGN KEY FK_F8B211F94296D31F');
        $this->addSql('ALTER TABLE movies_genre DROP FOREIGN KEY FK_F8B211F953F590A4');
        $this->addSql('ALTER TABLE movies_actor DROP FOREIGN KEY FK_3F9774F853F590A4');
        $this->addSql('ALTER TABLE movies_director DROP FOREIGN KEY FK_F6E47CC853F590A4');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED3089B658FE');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE movies_genre');
        $this->addSql('DROP TABLE movies_actor');
        $this->addSql('DROP TABLE movies_director');
        $this->addSql('DROP TABLE producer');
    }
}
