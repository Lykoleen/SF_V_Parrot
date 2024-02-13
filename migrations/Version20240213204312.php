<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213204312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD types_id INT NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD8EB23357 ON product (types_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8EB23357');
        $this->addSql('DROP INDEX IDX_D34A04AD8EB23357 ON product');
        $this->addSql('ALTER TABLE product DROP types_id, CHANGE price price INT NOT NULL');
    }
}
