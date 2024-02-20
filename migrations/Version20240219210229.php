<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219210229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE garage_id garage_id INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT 1');
        $this->addSql('ALTER TABLE schedule CHANGE garage_id garage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial CHANGE garage_id garage_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimonial CHANGE garage_id garage_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE garage_id garage_id INT NOT NULL, CHANGE quantity quantity INT DEFAULT 1');
        $this->addSql('ALTER TABLE schedule CHANGE garage_id garage_id INT NOT NULL');
    }
}
