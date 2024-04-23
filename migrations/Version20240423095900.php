<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423095900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_actividad ADD detalle_actividad_espacios_id INT DEFAULT NULL, ADD detalle_actividad_evento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detalle_actividad ADD CONSTRAINT FK_AC9E0C4683DED650 FOREIGN KEY (detalle_actividad_espacios_id) REFERENCES espacio (id)');
        $this->addSql('ALTER TABLE detalle_actividad ADD CONSTRAINT FK_AC9E0C465A8C275 FOREIGN KEY (detalle_actividad_evento_id) REFERENCES actividad (id)');
        $this->addSql('CREATE INDEX IDX_AC9E0C4683DED650 ON detalle_actividad (detalle_actividad_espacios_id)');
        $this->addSql('CREATE INDEX IDX_AC9E0C465A8C275 ON detalle_actividad (detalle_actividad_evento_id)');
        $this->addSql('ALTER TABLE ponente ADD ponente_detalle_actividad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ponente ADD CONSTRAINT FK_969EB3C85ACD97A8 FOREIGN KEY (ponente_detalle_actividad_id) REFERENCES detalle_actividad (id)');
        $this->addSql('CREATE INDEX IDX_969EB3C85ACD97A8 ON ponente (ponente_detalle_actividad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_actividad DROP FOREIGN KEY FK_AC9E0C4683DED650');
        $this->addSql('ALTER TABLE detalle_actividad DROP FOREIGN KEY FK_AC9E0C465A8C275');
        $this->addSql('DROP INDEX IDX_AC9E0C4683DED650 ON detalle_actividad');
        $this->addSql('DROP INDEX IDX_AC9E0C465A8C275 ON detalle_actividad');
        $this->addSql('ALTER TABLE detalle_actividad DROP detalle_actividad_espacios_id, DROP detalle_actividad_evento_id');
        $this->addSql('ALTER TABLE ponente DROP FOREIGN KEY FK_969EB3C85ACD97A8');
        $this->addSql('DROP INDEX IDX_969EB3C85ACD97A8 ON ponente');
        $this->addSql('ALTER TABLE ponente DROP ponente_detalle_actividad_id');
    }
}
