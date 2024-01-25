<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125233353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model ADD brand_id INT NOT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8EB23357');
        $this->addSql('DROP INDEX IDX_D34A04AD8EB23357 ON product');
        $this->addSql('ALTER TABLE product DROP types_id');
        $this->addSql('ALTER TABLE type ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE572912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8CDE572912469DE2 ON type (category_id)');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486D966BF49');
        $this->addSql('DROP INDEX IDX_1B80E486D966BF49 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP models_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('DROP INDEX IDX_D79572D944F5D008 ON model');
        $this->addSql('ALTER TABLE model DROP brand_id');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE572912469DE2');
        $this->addSql('DROP INDEX IDX_8CDE572912469DE2 ON type');
        $this->addSql('ALTER TABLE type DROP category_id');
        $this->addSql('ALTER TABLE product ADD types_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8EB23357 FOREIGN KEY (types_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD8EB23357 ON product (types_id)');
        $this->addSql('ALTER TABLE vehicle ADD models_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486D966BF49 FOREIGN KEY (models_id) REFERENCES model (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1B80E486D966BF49 ON vehicle (models_id)');
    }
}
