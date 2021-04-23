<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828024138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ouvrage (id INT AUTO_INCREMENT NOT NULL, code_pays_id INT NOT NULL, isbn VARCHAR(255) NOT NULL, nb_page INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_52A8CBD89E4306D8 (code_pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT FK_52A8CBD89E4306D8 FOREIGN KEY (code_pays_id) REFERENCES pays (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ouvrage');
    }
}
