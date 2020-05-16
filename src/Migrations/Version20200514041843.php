<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514041843 extends AbstractMigration
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
        $this->addSql('ALTER TABLE cuenta DROP INDEX IDX_31C7BFCFD8720997, ADD UNIQUE INDEX UNIQ_31C7BFCFD8720997 (tarjeta_id)');
        $this->addSql('ALTER TABLE perfil_libro ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarjeta ADD cuentas_id INT DEFAULT NULL, ADD dni INT NOT NULL');
        $this->addSql('ALTER TABLE tarjeta ADD CONSTRAINT FK_AE90B786F487CA82 FOREIGN KEY (cuentas_id) REFERENCES cuenta (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AE90B786F487CA82 ON tarjeta (cuentas_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE favoritos (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favoritos ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cuenta DROP INDEX UNIQ_31C7BFCFD8720997, ADD INDEX IDX_31C7BFCFD8720997 (tarjeta_id)');
        $this->addSql('ALTER TABLE perfil_libro DROP FOREIGN KEY FK_4C08AD7FC0238522');
        $this->addSql('ALTER TABLE tarjeta DROP FOREIGN KEY FK_AE90B786F487CA82');
        $this->addSql('DROP INDEX UNIQ_AE90B786F487CA82 ON tarjeta');
        $this->addSql('ALTER TABLE tarjeta DROP cuentas_id, DROP dni');
    }
}
