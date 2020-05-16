<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504222337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cuenta ADD tarjeta_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCFD8720997 FOREIGN KEY (tarjeta_id) REFERENCES tarjeta (id)');
        $this->addSql('CREATE INDEX IDX_31C7BFCFD8720997 ON cuenta (tarjeta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCFD8720997');
        $this->addSql('DROP INDEX IDX_31C7BFCFD8720997 ON cuenta');
        $this->addSql('ALTER TABLE cuenta DROP tarjeta_id');
    }
}
