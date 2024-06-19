<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618165358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grupo DROP FOREIGN KEY FK_8C0E9BD3A954C5A1');
        $this->addSql('DROP INDEX IDX_8C0E9BD3A954C5A1 ON grupo');
        $this->addSql('ALTER TABLE grupo DROP detalle_actividad_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grupo ADD detalle_actividad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo ADD CONSTRAINT FK_8C0E9BD3A954C5A1 FOREIGN KEY (detalle_actividad_id) REFERENCES detalle_actividad (id)');
        $this->addSql('CREATE INDEX IDX_8C0E9BD3A954C5A1 ON grupo (detalle_actividad_id)');
    }
}
