<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423081754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alumno (id INT AUTO_INCREMENT NOT NULL, alumno_grupo_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, fecha_nac DATE NOT NULL, INDEX IDX_1435D52DED1CA297 (alumno_grupo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nivel_educativo (id INT AUTO_INCREMENT NOT NULL, grupo_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_33209C919C833003 (grupo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52DED1CA297 FOREIGN KEY (alumno_grupo_id) REFERENCES grupo (id)');
        $this->addSql('ALTER TABLE nivel_educativo ADD CONSTRAINT FK_33209C919C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP FOREIGN KEY FK_1435D52DED1CA297');
        $this->addSql('ALTER TABLE nivel_educativo DROP FOREIGN KEY FK_33209C919C833003');
        $this->addSql('DROP TABLE alumno');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE nivel_educativo');
    }
}
