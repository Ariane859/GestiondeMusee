<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907170611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visiter ADD jour_id INT NOT NULL');
        $this->addSql('ALTER TABLE visiter ADD CONSTRAINT FK_300A0915220C6AD0 FOREIGN KEY (jour_id) REFERENCES moment (id)');
        $this->addSql('CREATE INDEX IDX_300A0915220C6AD0 ON visiter (jour_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visiter DROP FOREIGN KEY FK_300A0915220C6AD0');
        $this->addSql('DROP INDEX IDX_300A0915220C6AD0 ON visiter');
        $this->addSql('ALTER TABLE visiter DROP jour_id');
    }
}
