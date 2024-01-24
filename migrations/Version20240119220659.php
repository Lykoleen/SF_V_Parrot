<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119220659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garage_service (garage_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_67DD7642C4FFF555 (garage_id), INDEX IDX_67DD7642ED5CA9E6 (service_id), PRIMARY KEY(garage_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_user (garage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EEE5ABA2C4FFF555 (garage_id), INDEX IDX_EEE5ABA2A76ED395 (user_id), PRIMARY KEY(garage_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_user ADD CONSTRAINT FK_EEE5ABA2C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_user ADD CONSTRAINT FK_EEE5ABA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD services_id INT DEFAULT NULL, ADD vehicles_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8916F10C70 FOREIGN KEY (vehicles_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89AEF5A6C1 ON picture (services_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8916F10C70 ON picture (vehicles_id)');
        $this->addSql('ALTER TABLE product ADD garage_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADC4FFF555 ON product (garage_id)');
        $this->addSql('ALTER TABLE schedule ADD garage_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_5A3811FBC4FFF555 ON schedule (garage_id)');
        $this->addSql('ALTER TABLE testimonial ADD garage_id INT NOT NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_E6BDCDF7C4FFF555 ON testimonial (garage_id)');
        $this->addSql('ALTER TABLE user ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
        $this->addSql('ALTER TABLE vehicle ADD gearboxes_id INT DEFAULT NULL, ADD brands_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4865FF50284 FOREIGN KEY (gearboxes_id) REFERENCES gearbox (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486E9EEC0C7 FOREIGN KEY (brands_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_1B80E4865FF50284 ON vehicle (gearboxes_id)');
        $this->addSql('CREATE INDEX IDX_1B80E486E9EEC0C7 ON vehicle (brands_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642C4FFF555');
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642ED5CA9E6');
        $this->addSql('ALTER TABLE garage_user DROP FOREIGN KEY FK_EEE5ABA2C4FFF555');
        $this->addSql('ALTER TABLE garage_user DROP FOREIGN KEY FK_EEE5ABA2A76ED395');
        $this->addSql('DROP TABLE garage_service');
        $this->addSql('DROP TABLE garage_user');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC4FFF555');
        $this->addSql('DROP INDEX IDX_D34A04ADC4FFF555 ON product');
        $this->addSql('ALTER TABLE product DROP garage_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user DROP role_id');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7C4FFF555');
        $this->addSql('DROP INDEX IDX_E6BDCDF7C4FFF555 ON testimonial');
        $this->addSql('ALTER TABLE testimonial DROP garage_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89AEF5A6C1');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8916F10C70');
        $this->addSql('DROP INDEX IDX_16DB4F89AEF5A6C1 ON picture');
        $this->addSql('DROP INDEX IDX_16DB4F8916F10C70 ON picture');
        $this->addSql('ALTER TABLE picture DROP services_id, DROP vehicles_id');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC4FFF555');
        $this->addSql('DROP INDEX IDX_5A3811FBC4FFF555 ON schedule');
        $this->addSql('ALTER TABLE schedule DROP garage_id');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4865FF50284');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486E9EEC0C7');
        $this->addSql('DROP INDEX IDX_1B80E4865FF50284 ON vehicle');
        $this->addSql('DROP INDEX IDX_1B80E486E9EEC0C7 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP gearboxes_id, DROP brands_id');
    }
}
