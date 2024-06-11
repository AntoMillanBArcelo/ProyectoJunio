<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610203400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ponente ADD evento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ponente ADD CONSTRAINT FK_969EB3C887A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('CREATE INDEX IDX_969EB3C887A5F842 ON ponente (evento_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ponente DROP FOREIGN KEY FK_969EB3C887A5F842');
        $this->addSql('DROP INDEX IDX_969EB3C887A5F842 ON ponente');
        $this->addSql('ALTER TABLE ponente DROP evento_id');
    }
}
