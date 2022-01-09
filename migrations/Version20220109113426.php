<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109113426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme ALTER text_two TYPE TEXT');
        $this->addSql('ALTER TABLE theme ALTER text_two DROP DEFAULT');
        $this->addSql('ALTER TABLE theme ALTER text_three TYPE TEXT');
        $this->addSql('ALTER TABLE theme ALTER text_three DROP DEFAULT');
        $this->addSql('ALTER TABLE theme ALTER text_four TYPE TEXT');
        $this->addSql('ALTER TABLE theme ALTER text_four DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE theme ALTER text_two TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE theme ALTER text_two DROP DEFAULT');
        $this->addSql('ALTER TABLE theme ALTER text_three TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE theme ALTER text_three DROP DEFAULT');
        $this->addSql('ALTER TABLE theme ALTER text_four TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE theme ALTER text_four DROP DEFAULT');
    }
}
