<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518015344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE favoritos');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCFD8720997 FOREIGN KEY (tarjeta_id) REFERENCES tarjeta (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31C7BFCFD8720997 ON cuenta (tarjeta_id)');
        $this->addSql('ALTER TABLE novedad ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE perfil_libro ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarjeta CHANGE numero numero INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE favoritos (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favoritos ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCFD8720997');
        $this->addSql('DROP INDEX UNIQ_31C7BFCFD8720997 ON cuenta');
        $this->addSql('ALTER TABLE novedad DROP updated_at');
        $this->addSql('ALTER TABLE perfil_libro DROP FOREIGN KEY FK_4C08AD7FC0238522');
        $this->addSql('ALTER TABLE tarjeta CHANGE numero numero BIGINT DEFAULT NULL');
    }
}
