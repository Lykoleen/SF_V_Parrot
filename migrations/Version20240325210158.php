<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325210158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_service (garage_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_67DD7642C4FFF555 (garage_id), INDEX IDX_67DD7642ED5CA9E6 (service_id), PRIMARY KEY(garage_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_user (garage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EEE5ABA2C4FFF555 (garage_id), INDEX IDX_EEE5ABA2A76ED395 (user_id), PRIMARY KEY(garage_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gearbox (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, services_id INT DEFAULT NULL, products_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16DB4F89AEF5A6C1 (services_id), INDEX IDX_16DB4F896C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, categories_id INT NOT NULL, types_id INT NOT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT DEFAULT NULL, availability TINYINT(1) DEFAULT NULL, product_type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D34A04AD2B36786B (title), INDEX IDX_D34A04ADC4FFF555 (garage_id), INDEX IDX_D34A04ADA21214B7 (categories_id), INDEX IDX_D34A04AD8EB23357 (types_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, day VARCHAR(255) NOT NULL, opening_morning TIME DEFAULT NULL, closing_morning TIME DEFAULT NULL, opening_afternoon TIME DEFAULT NULL, closing_afternoon TIME DEFAULT NULL, close TINYINT(1) DEFAULT NULL, closed_at_lunchtime TINYINT(1) DEFAULT NULL, INDEX IDX_5A3811FBC4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, message TEXT NOT NULL, score INT NOT NULL, is_actif TINYINT(1) DEFAULT NULL, INDEX IDX_E6BDCDF7C4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8CDE572912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT NOT NULL, gearboxes_id INT DEFAULT NULL, brands_id INT DEFAULT NULL, energies_id INT NOT NULL, models_id INT NOT NULL, years INT NOT NULL, mileage INT NOT NULL, description TEXT NOT NULL, INDEX IDX_1B80E4865FF50284 (gearboxes_id), INDEX IDX_1B80E486E9EEC0C7 (brands_id), INDEX IDX_1B80E486AD192AC7 (energies_id), INDEX IDX_1B80E486D966BF49 (models_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_user ADD CONSTRAINT FK_EEE5ABA2C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_user ADD CONSTRAINT FK_EEE5ABA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F896C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE572912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4865FF50284 FOREIGN KEY (gearboxes_id) REFERENCES gearbox (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486E9EEC0C7 FOREIGN KEY (brands_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486AD192AC7 FOREIGN KEY (energies_id) REFERENCES energy (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486D966BF49 FOREIGN KEY (models_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486BF396750 FOREIGN KEY (id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE restaurant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, am_opening_time JSON NOT NULL, pm_opening_time JSON NOT NULL, max_guest INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642C4FFF555');
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642ED5CA9E6');
        $this->addSql('ALTER TABLE garage_user DROP FOREIGN KEY FK_EEE5ABA2C4FFF555');
        $this->addSql('ALTER TABLE garage_user DROP FOREIGN KEY FK_EEE5ABA2A76ED395');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89AEF5A6C1');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F896C8A81A9');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC4FFF555');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA21214B7');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8EB23357');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC4FFF555');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7C4FFF555');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE572912469DE2');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4865FF50284');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486E9EEC0C7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486AD192AC7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486D966BF49');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486BF396750');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE energy');
        $this->addSql('DROP TABLE garage');
        $this->addSql('DROP TABLE garage_service');
        $this->addSql('DROP TABLE garage_user');
        $this->addSql('DROP TABLE gearbox');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicle');
    }
}
