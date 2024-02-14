<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213214902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, services_id INT NOT NULL, products_id INT NOT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16DB4F89AEF5A6C1 (services_id), INDEX IDX_16DB4F896C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F896C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product DROP image_name, DROP updated_at');
        $this->addSql('ALTER TABLE service DROP image_name, DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89AEF5A6C1');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F896C8A81A9');
        $this->addSql('DROP TABLE picture');
        $this->addSql('ALTER TABLE service ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
