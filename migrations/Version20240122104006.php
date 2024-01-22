<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122104006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage CHANGE mail email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD categories_id INT NOT NULL, ADD types_id INT NOT NULL, DROP category, DROP type, CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA21214B7 ON product (categories_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD8EB23357 ON product (types_id)');
        $this->addSql('ALTER TABLE user ADD confirm_password VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE vehicle ADD energies_id INT NOT NULL, ADD models_id INT NOT NULL, CHANGE model title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486AD192AC7 FOREIGN KEY (energies_id) REFERENCES energy (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486D966BF49 FOREIGN KEY (models_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_1B80E486AD192AC7 ON vehicle (energies_id)');
        $this->addSql('CREATE INDEX IDX_1B80E486D966BF49 ON vehicle (models_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA21214B7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486AD192AC7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486D966BF49');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8EB23357');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE energy');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_1B80E486AD192AC7 ON vehicle');
        $this->addSql('DROP INDEX IDX_1B80E486D966BF49 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP energies_id, DROP models_id, CHANGE title model VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE garage CHANGE email mail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP confirm_password, CHANGE roles roles JSON NOT NULL');
        $this->addSql('DROP INDEX IDX_D34A04ADA21214B7 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD8EB23357 ON product');
        $this->addSql('ALTER TABLE product ADD category VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, DROP categories_id, DROP types_id, CHANGE price price DOUBLE PRECISION NOT NULL');
    }
}
