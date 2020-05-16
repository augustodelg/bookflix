<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510191247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE novedad (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, foto VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfil (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfil_libro (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarjeta (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, vencimiento DATE NOT NULL, cvv INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE perfil_libro ADD CONSTRAINT FK_4C08AD7F57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perfil_libro ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE favoritos');
        $this->addSql('ALTER TABLE cuenta ADD tarjeta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCFD8720997 FOREIGN KEY (tarjeta_id) REFERENCES tarjeta (id)');
        $this->addSql('CREATE INDEX IDX_31C7BFCFD8720997 ON cuenta (tarjeta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perfil_libro DROP FOREIGN KEY FK_4C08AD7F57291544');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCFD8720997');
        $this->addSql('CREATE TABLE favoritos (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favoritos ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE novedad');
        $this->addSql('DROP TABLE perfil');
        $this->addSql('DROP TABLE perfil_libro');
        $this->addSql('DROP TABLE tarjeta');
        $this->addSql('DROP INDEX IDX_31C7BFCFD8720997 ON cuenta');
        $this->addSql('ALTER TABLE cuenta DROP tarjeta_id');
    }
}
