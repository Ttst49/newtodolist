<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530103855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP CONSTRAINT fk_5a0eb6a07a86d49f');
        $this->addSql('DROP SEQUENCE todo_category_id_seq CASCADE');
        $this->addSql('DROP TABLE todo_category');
        $this->addSql('DROP INDEX idx_5a0eb6a07a86d49f');
        $this->addSql('ALTER TABLE todo DROP todo_category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE todo_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE todo_category (id INT NOT NULL, name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE todo ADD todo_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT fk_5a0eb6a07a86d49f FOREIGN KEY (todo_category_id) REFERENCES todo_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a0eb6a07a86d49f ON todo (todo_category_id)');
    }
}
