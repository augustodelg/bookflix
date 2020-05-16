<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200503131834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE libro ADD autor_id INT NOT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B14D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2B14D45BBE ON libro (autor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B14D45BBE');
        $this->addSql('DROP INDEX IDX_5799AD2B14D45BBE ON libro');
        $this->addSql('ALTER TABLE libro DROP autor_id');
    }
}
