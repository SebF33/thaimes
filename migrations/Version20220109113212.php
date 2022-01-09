<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109113212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme ADD picture_two_author VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE theme ADD picture_two_author_link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE theme ADD text_four VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE theme DROP picture_two_author');
        $this->addSql('ALTER TABLE theme DROP picture_two_author_link');
        $this->addSql('ALTER TABLE theme DROP text_four');
    }
}
