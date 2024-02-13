<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212223858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD opening_morning TIME DEFAULT NULL, ADD closing_morning TIME DEFAULT NULL, ADD opening_afternoon TIME DEFAULT NULL, ADD closing_afternoon TIME DEFAULT NULL, DROP slot, DROP opening, DROP closing');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD slot VARCHAR(255) NOT NULL, ADD opening TIME DEFAULT NULL, ADD closing TIME DEFAULT NULL, DROP opening_morning, DROP closing_morning, DROP opening_afternoon, DROP closing_afternoon');
    }
}
