<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624163047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adelanto CHANGE contenido contenido MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE cuenta ADD perfil_actual_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCF5A4FAE7D FOREIGN KEY (perfil_actual_id) REFERENCES perfil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31C7BFCF5A4FAE7D ON cuenta (perfil_actual_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adelanto CHANGE contenido contenido MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCF5A4FAE7D');
        $this->addSql('DROP INDEX UNIQ_31C7BFCF5A4FAE7D ON cuenta');
        $this->addSql('ALTER TABLE cuenta DROP perfil_actual_id');
    }
}
