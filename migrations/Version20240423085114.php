<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423085114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_actividad (id INT AUTO_INCREMENT NOT NULL, fecha_hora_ini DATETIME NOT NULL, fecha_hora_fin DATETIME NOT NULL, titulo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_actividad_alumno (detalle_actividad_id INT NOT NULL, alumno_id INT NOT NULL, INDEX IDX_D4948D5AA954C5A1 (detalle_actividad_id), INDEX IDX_D4948D5AFC28E5EE (alumno_id), PRIMARY KEY(detalle_actividad_id, alumno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ponente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, cargo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_actividad_alumno ADD CONSTRAINT FK_D4948D5AA954C5A1 FOREIGN KEY (detalle_actividad_id) REFERENCES detalle_actividad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detalle_actividad_alumno ADD CONSTRAINT FK_D4948D5AFC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_actividad_alumno DROP FOREIGN KEY FK_D4948D5AA954C5A1');
        $this->addSql('ALTER TABLE detalle_actividad_alumno DROP FOREIGN KEY FK_D4948D5AFC28E5EE');
        $this->addSql('DROP TABLE detalle_actividad');
        $this->addSql('DROP TABLE detalle_actividad_alumno');
        $this->addSql('DROP TABLE ponente');
    }
}
