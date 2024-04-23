<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423074134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recurso (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recurso_espacio (recurso_id INT NOT NULL, espacio_id INT NOT NULL, INDEX IDX_C7980686E52B6C4E (recurso_id), INDEX IDX_C79806867CFC1D2C (espacio_id), PRIMARY KEY(recurso_id, espacio_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recurso_espacio ADD CONSTRAINT FK_C7980686E52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recurso_espacio ADD CONSTRAINT FK_C79806867CFC1D2C FOREIGN KEY (espacio_id) REFERENCES espacio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espacio ADD espacio_edificio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE espacio ADD CONSTRAINT FK_90BF6AA4A83B4A79 FOREIGN KEY (espacio_edificio_id) REFERENCES edificio (id)');
        $this->addSql('CREATE INDEX IDX_90BF6AA4A83B4A79 ON espacio (espacio_edificio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recurso_espacio DROP FOREIGN KEY FK_C7980686E52B6C4E');
        $this->addSql('ALTER TABLE recurso_espacio DROP FOREIGN KEY FK_C79806867CFC1D2C');
        $this->addSql('DROP TABLE recurso');
        $this->addSql('DROP TABLE recurso_espacio');
        $this->addSql('ALTER TABLE espacio DROP FOREIGN KEY FK_90BF6AA4A83B4A79');
        $this->addSql('DROP INDEX IDX_90BF6AA4A83B4A79 ON espacio');
        $this->addSql('ALTER TABLE espacio DROP espacio_edificio_id');
    }
}
