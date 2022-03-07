<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307184727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_conversation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, theme_id INT NOT NULL, author VARCHAR(255) NOT NULL, text TEXT NOT NULL, email VARCHAR(255) NOT NULL, picture_filename VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, state VARCHAR(255) DEFAULT \'submitted\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C59027487 ON comment (theme_id)');
        $this->addSql('CREATE TABLE group_conversation (id INT NOT NULL, admin_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated TIMESTAMP(0) WITH TIME ZONE NOT NULL, private BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66C86CD0642B8210 ON group_conversation (admin_id)');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, conversation_id INT DEFAULT NULL, user_id INT NOT NULL, content TEXT NOT NULL, seen BOOLEAN NOT NULL, created TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7835E237E06 ON tag (name)');
        $this->addSql('CREATE TABLE theme (id INT NOT NULL, title VARCHAR(255) NOT NULL, year VARCHAR(4) NOT NULL, text TEXT NOT NULL, catch VARCHAR(255) NOT NULL, aside_text VARCHAR(255) DEFAULT NULL, display BOOLEAN NOT NULL, slug VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, picture_author VARCHAR(255) DEFAULT NULL, picture_author_link VARCHAR(255) DEFAULT NULL, text_two TEXT DEFAULT NULL, title_two VARCHAR(255) DEFAULT NULL, text_three TEXT DEFAULT NULL, picture_two VARCHAR(255) DEFAULT NULL, picture_two_author VARCHAR(255) DEFAULT NULL, picture_two_author_link VARCHAR(255) DEFAULT NULL, text_four TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9775E7082B36786B ON theme (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9775E708989D9B62 ON theme (slug)');
        $this->addSql('CREATE TABLE theme_tag (theme_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(theme_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_1BD8CBE759027487 ON theme_tag (theme_id)');
        $this->addSql('CREATE INDEX IDX_1BD8CBE7BAD26311 ON theme_tag (tag_id)');
        $this->addSql('CREATE TABLE theme_translations (id SERIAL NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_56E0EC05232D562B ON theme_translations (object_id)');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON theme_translations (locale, object_id, field)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, status BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_group_conversation (user_id INT NOT NULL, group_conversation_id INT NOT NULL, PRIMARY KEY(user_id, group_conversation_id))');
        $this->addSql('CREATE INDEX IDX_CA8C8A2BA76ED395 ON user_group_conversation (user_id)');
        $this->addSql('CREATE INDEX IDX_CA8C8A2BB73F9E4F ON user_group_conversation (group_conversation_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_conversation ADD CONSTRAINT FK_66C86CD0642B8210 FOREIGN KEY (admin_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES group_conversation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_tag ADD CONSTRAINT FK_1BD8CBE759027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_tag ADD CONSTRAINT FK_1BD8CBE7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_translations ADD CONSTRAINT FK_56E0EC05232D562B FOREIGN KEY (object_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_conversation ADD CONSTRAINT FK_CA8C8A2BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_conversation ADD CONSTRAINT FK_CA8C8A2BB73F9E4F FOREIGN KEY (group_conversation_id) REFERENCES group_conversation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE user_group_conversation DROP CONSTRAINT FK_CA8C8A2BB73F9E4F');
        $this->addSql('ALTER TABLE theme_tag DROP CONSTRAINT FK_1BD8CBE7BAD26311');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C59027487');
        $this->addSql('ALTER TABLE theme_tag DROP CONSTRAINT FK_1BD8CBE759027487');
        $this->addSql('ALTER TABLE theme_translations DROP CONSTRAINT FK_56E0EC05232D562B');
        $this->addSql('ALTER TABLE group_conversation DROP CONSTRAINT FK_66C86CD0642B8210');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE user_group_conversation DROP CONSTRAINT FK_CA8C8A2BA76ED395');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_conversation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE theme_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE group_conversation');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_tag');
        $this->addSql('DROP TABLE theme_translations');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_group_conversation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
