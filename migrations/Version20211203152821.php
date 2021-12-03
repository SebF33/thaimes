<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211203152821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE theme_tag (theme_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(theme_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_1BD8CBE759027487 ON theme_tag (theme_id)');
        $this->addSql('CREATE INDEX IDX_1BD8CBE7BAD26311 ON theme_tag (tag_id)');
        $this->addSql('ALTER TABLE theme_tag ADD CONSTRAINT FK_1BD8CBE759027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_tag ADD CONSTRAINT FK_1BD8CBE7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT fk_389b78359027487');
        $this->addSql('DROP INDEX idx_389b78359027487');
        $this->addSql('ALTER TABLE tag DROP theme_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE theme_tag');
        $this->addSql('ALTER TABLE tag ADD theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT fk_389b78359027487 FOREIGN KEY (theme_id) REFERENCES theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_389b78359027487 ON tag (theme_id)');
    }
}
