<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102103348 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, title, description, link, imagelink, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, link VARCHAR(255) NOT NULL COLLATE BINARY, imagelink VARCHAR(255) NOT NULL COLLATE BINARY, price VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO product (id, title, description, link, imagelink, price) SELECT id, title, description, link, imagelink, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE product ADD COLUMN date DATETIME DEFAULT NULL');
    }
}
