<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423102451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grupo_user (grupo_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E90A3F339C833003 (grupo_id), INDEX IDX_E90A3F33A76ED395 (user_id), PRIMARY KEY(grupo_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, rol VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grupo_user ADD CONSTRAINT FK_E90A3F339C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grupo_user ADD CONSTRAINT FK_E90A3F33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detalle_actividad ADD url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grupo_user DROP FOREIGN KEY FK_E90A3F339C833003');
        $this->addSql('ALTER TABLE grupo_user DROP FOREIGN KEY FK_E90A3F33A76ED395');
        $this->addSql('DROP TABLE grupo_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE detalle_actividad DROP url');
    }
}
