<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215212445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle ADD models_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486D966BF49 FOREIGN KEY (models_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_1B80E486D966BF49 ON vehicle (models_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486D966BF49');
        $this->addSql('DROP INDEX IDX_1B80E486D966BF49 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP models_id');
    }
}
