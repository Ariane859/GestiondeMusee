<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825151458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visiter DROP FOREIGN KEY visiter_ibfk_2');
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY bibliotheque_ibfk_1');
        $this->addSql('ALTER TABLE visiter DROP FOREIGN KEY visiter_ibfk_1');
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY bibliotheque_ibfk_2');
        $this->addSql('ALTER TABLE referencer DROP FOREIGN KEY referencer_ibfk_2');
        $this->addSql('ALTER TABLE referencer DROP FOREIGN KEY referencer_ibfk_1');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP TABLE moment');
        $this->addSql('DROP TABLE musee');
        $this->addSql('DROP TABLE ouvrage');
        $this->addSql('DROP TABLE referencer');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE visiter');
        $this->addSql('ALTER TABLE pays ADD id INT AUTO_INCREMENT NOT NULL, ADD code_pays VARCHAR(255) NOT NULL, DROP codePays, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (numMus INT NOT NULL, ISBN VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, dateAchat DATE NOT NULL, INDEX ISBN (ISBN), INDEX numMus (numMus, ISBN), INDEX IDX_4690D34D98443C4E (numMus), PRIMARY KEY(numMus, ISBN)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE moment (jour DATE NOT NULL COMMENT \'jour\', PRIMARY KEY(jour)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE musee (numMus INT NOT NULL, nomMus VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, nblivres INT NOT NULL, codePays VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX codePays (codePays), PRIMARY KEY(numMus)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ouvrage (ISBN VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, nbPage INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, codePays VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX codePays (codePays), PRIMARY KEY(ISBN)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE referencer (nomSite VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, numeroPage INT NOT NULL, ISBN VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX nomSite (nomSite, ISBN), INDEX ISBN (ISBN), INDEX IDX_E8191D0A36D09F73 (nomSite), PRIMARY KEY(nomSite, numeroPage, ISBN)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE site (nomSite VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, anneedecouv INT DEFAULT NULL, codePays VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX codePays (codePays), PRIMARY KEY(nomSite)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE visiter (jour DATE NOT NULL COMMENT \'identifiant unique\', numMus INT NOT NULL COMMENT \'identifiant unique\', nbvisiteurs INT NOT NULL COMMENT \'nombre de visiteurs\', INDEX jour (jour), INDEX numMus (numMus), PRIMARY KEY(numMus, jour)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT bibliotheque_ibfk_1 FOREIGN KEY (numMus) REFERENCES musee (numMus) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT bibliotheque_ibfk_2 FOREIGN KEY (ISBN) REFERENCES ouvrage (ISBN) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musee ADD CONSTRAINT musee_ibfk_1 FOREIGN KEY (codePays) REFERENCES pays (codePays) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT ouvrage_ibfk_1 FOREIGN KEY (codePays) REFERENCES pays (codePays) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referencer ADD CONSTRAINT referencer_ibfk_1 FOREIGN KEY (nomSite) REFERENCES site (nomSite) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referencer ADD CONSTRAINT referencer_ibfk_2 FOREIGN KEY (ISBN) REFERENCES ouvrage (ISBN) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT site_ibfk_1 FOREIGN KEY (codePays) REFERENCES pays (codePays) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visiter ADD CONSTRAINT visiter_ibfk_1 FOREIGN KEY (numMus) REFERENCES musee (numMus) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visiter ADD CONSTRAINT visiter_ibfk_2 FOREIGN KEY (jour) REFERENCES moment (jour) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pays MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE pays DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE pays ADD codePays VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, DROP id, DROP code_pays');
        $this->addSql('ALTER TABLE pays ADD PRIMARY KEY (codePays)');
    }
}
