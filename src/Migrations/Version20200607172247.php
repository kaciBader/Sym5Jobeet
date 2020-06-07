<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200607172247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE category ADD COLUMN slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_9E1A77FF12469DE2');
        $this->addSql('DROP INDEX IDX_9E1A77FF9F12C49A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_affiliate AS SELECT id, category_id, affiliate_id FROM category_affiliate');
        $this->addSql('DROP TABLE category_affiliate');
        $this->addSql('CREATE TABLE category_affiliate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, affiliate_id INTEGER DEFAULT NULL, CONSTRAINT FK_9E1A77FF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9E1A77FF9F12C49A FOREIGN KEY (affiliate_id) REFERENCES affiliate (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_affiliate (id, category_id, affiliate_id) SELECT id, category_id, affiliate_id FROM __temp__category_affiliate');
        $this->addSql('DROP TABLE __temp__category_affiliate');
        $this->addSql('CREATE INDEX IDX_9E1A77FF12469DE2 ON category_affiliate (category_id)');
        $this->addSql('CREATE INDEX IDX_9E1A77FF9F12C49A ON category_affiliate (affiliate_id)');
        $this->addSql('DROP INDEX IDX_FBD8E0F812469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__job AS SELECT id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at FROM job');
        $this->addSql('DROP TABLE job');
        $this->addSql('CREATE TABLE job (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, type VARCHAR(255) DEFAULT NULL COLLATE BINARY, company VARCHAR(255) NOT NULL COLLATE BINARY, logo VARCHAR(255) DEFAULT NULL COLLATE BINARY, url VARCHAR(255) DEFAULT NULL COLLATE BINARY, position VARCHAR(255) NOT NULL COLLATE BINARY, location VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, how_to_apply CLOB NOT NULL COLLATE BINARY, token VARCHAR(255) DEFAULT NULL COLLATE BINARY, is_public BOOLEAN DEFAULT NULL, is_activated BOOLEAN DEFAULT NULL, email VARCHAR(255) NOT NULL COLLATE BINARY, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_FBD8E0F812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO job (id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at) SELECT id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at FROM __temp__job');
        $this->addSql('DROP TABLE __temp__job');
        $this->addSql('CREATE INDEX IDX_FBD8E0F812469DE2 ON job (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, name) SELECT id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('DROP INDEX IDX_9E1A77FF12469DE2');
        $this->addSql('DROP INDEX IDX_9E1A77FF9F12C49A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_affiliate AS SELECT id, category_id, affiliate_id FROM category_affiliate');
        $this->addSql('DROP TABLE category_affiliate');
        $this->addSql('CREATE TABLE category_affiliate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, affiliate_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO category_affiliate (id, category_id, affiliate_id) SELECT id, category_id, affiliate_id FROM __temp__category_affiliate');
        $this->addSql('DROP TABLE __temp__category_affiliate');
        $this->addSql('CREATE INDEX IDX_9E1A77FF12469DE2 ON category_affiliate (category_id)');
        $this->addSql('CREATE INDEX IDX_9E1A77FF9F12C49A ON category_affiliate (affiliate_id)');
        $this->addSql('DROP INDEX IDX_FBD8E0F812469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__job AS SELECT id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at FROM job');
        $this->addSql('DROP TABLE job');
        $this->addSql('CREATE TABLE job (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, company VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, position VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, description CLOB NOT NULL, how_to_apply CLOB NOT NULL, token VARCHAR(255) DEFAULT NULL, is_public BOOLEAN DEFAULT NULL, is_activated BOOLEAN DEFAULT NULL, email VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO job (id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at) SELECT id, category_id, type, company, logo, url, position, location, description, how_to_apply, token, is_public, is_activated, email, expires_at, created_at, updated_at FROM __temp__job');
        $this->addSql('DROP TABLE __temp__job');
        $this->addSql('CREATE INDEX IDX_FBD8E0F812469DE2 ON job (category_id)');
    }
}
