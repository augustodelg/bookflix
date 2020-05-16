<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504221032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perfil ADD cuenta_id INT NOT NULL');
        $this->addSql('ALTER TABLE perfil ADD CONSTRAINT FK_966576479AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('CREATE INDEX IDX_966576479AEFF118 ON perfil (cuenta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perfil DROP FOREIGN KEY FK_966576479AEFF118');
        $this->addSql('DROP INDEX IDX_966576479AEFF118 ON perfil');
        $this->addSql('ALTER TABLE perfil DROP cuenta_id');
    }
}
