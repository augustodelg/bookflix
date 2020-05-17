<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517022445 extends AbstractMigration
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
        $this->addSql('ALTER TABLE cuenta DROP INDEX IDX_31C7BFCFD8720997, ADD UNIQUE INDEX UNIQ_31C7BFCFD8720997 (tarjeta_id)');
        $this->addSql('ALTER TABLE cuenta ADD nombre VARCHAR(255) NOT NULL, ADD apellido VARCHAR(255) NOT NULL, ADD premium TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE perfil CHANGE cuenta_id cuenta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarjeta ADD dni INT NOT NULL, ADD cvv INT NOT NULL, CHANGE fecha_venc vencimiento DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE novedad');
        $this->addSql('ALTER TABLE cuenta DROP INDEX UNIQ_31C7BFCFD8720997, ADD INDEX IDX_31C7BFCFD8720997 (tarjeta_id)');
        $this->addSql('ALTER TABLE cuenta DROP nombre, DROP apellido, DROP premium');
        $this->addSql('ALTER TABLE perfil CHANGE cuenta_id cuenta_id INT NOT NULL');
        $this->addSql('ALTER TABLE tarjeta DROP dni, DROP cvv, CHANGE vencimiento fecha_venc DATE NOT NULL');
    }
}
