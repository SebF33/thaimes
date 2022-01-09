<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109110948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme ADD title_two VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE theme ADD text_three VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE theme ADD picture_two VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE theme DROP title_two');
        $this->addSql('ALTER TABLE theme DROP text_three');
        $this->addSql('ALTER TABLE theme DROP picture_two');
    }
}
