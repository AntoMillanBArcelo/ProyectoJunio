<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617101125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_actividad_grupo (detalle_actividad_id INT NOT NULL, grupo_id INT NOT NULL, INDEX IDX_973A41ACA954C5A1 (detalle_actividad_id), INDEX IDX_973A41AC9C833003 (grupo_id), PRIMARY KEY(detalle_actividad_id, grupo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_actividad_grupo ADD CONSTRAINT FK_973A41ACA954C5A1 FOREIGN KEY (detalle_actividad_id) REFERENCES detalle_actividad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detalle_actividad_grupo ADD CONSTRAINT FK_973A41AC9C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_actividad_grupo DROP FOREIGN KEY FK_973A41ACA954C5A1');
        $this->addSql('ALTER TABLE detalle_actividad_grupo DROP FOREIGN KEY FK_973A41AC9C833003');
        $this->addSql('DROP TABLE detalle_actividad_grupo');
    }
}
