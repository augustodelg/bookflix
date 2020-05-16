<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510183141 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favoritos DROP FOREIGN KEY FK_4C08AD7F57291544');
        $this->addSql('DROP TABLE favoritos');
        $this->addSql('DROP TABLE perfil');
        $this->addSql('DROP TABLE perfil_libro');
        $this->addSql('DROP TABLE tarjeta');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE favoritos (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE perfil (id INT AUTO_INCREMENT NOT NULL, cuenta_id INT NOT NULL, nombre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_966576479AEFF118 (cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE perfil_libro (perfil_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C08AD7F57291544 (perfil_id), INDEX IDX_4C08AD7FC0238522 (libro_id), PRIMARY KEY(perfil_id, libro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tarjeta (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, fecha_venc DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favoritos ADD CONSTRAINT FK_4C08AD7F57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoritos ADD CONSTRAINT FK_4C08AD7FC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perfil ADD CONSTRAINT FK_966576479AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
