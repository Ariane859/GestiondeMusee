<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907161348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, num_mus_id INT NOT NULL, isbn_id INT NOT NULL, date_achat DATE NOT NULL, INDEX IDX_4690D34D6D319670 (num_mus_id), INDEX IDX_4690D34DAFFF1118 (isbn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34D6D319670 FOREIGN KEY (num_mus_id) REFERENCES musee (id)');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34DAFFF1118 FOREIGN KEY (isbn_id) REFERENCES ouvrage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bibliotheque');
    }
}
