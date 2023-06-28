<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230628191320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor ADD poster VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD poster VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE episode ADD poster VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE season ADD poster VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor DROP poster, DROP updated_at');
        $this->addSql('ALTER TABLE category DROP poster, DROP updated_at');
        $this->addSql('ALTER TABLE episode DROP poster, DROP updated_at');
        $this->addSql('ALTER TABLE season DROP poster, DROP updated_at');
    }
}
