<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729171709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE email_statuses (id SMALLINT NOT NULL, codename VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_40960158FB685056 ON email_statuses (codename)');
        $this->addSql('CREATE TABLE emails (id VARCHAR(26) NOT NULL, email_status_id SMALLINT NOT NULL, address VARCHAR(320) NOT NULL, theme VARCHAR(500) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C81E85264FC9F96 ON emails (email_status_id)');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E85264FC9F96 FOREIGN KEY (email_status_id) REFERENCES email_statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE emails DROP CONSTRAINT FK_4C81E85264FC9F96');
        $this->addSql('DROP TABLE email_statuses');
        $this->addSql('DROP TABLE emails');
    }
}
