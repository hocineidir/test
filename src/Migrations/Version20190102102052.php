<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102102052 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, title, description, link, imagelink, price, date FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, link VARCHAR(255) NOT NULL COLLATE BINARY, imagelink VARCHAR(255) NOT NULL COLLATE BINARY, price VARCHAR(255) NOT NULL COLLATE BINARY, date DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO product (id, title, description, link, imagelink, price, date) SELECT id, title, description, link, imagelink, price, date FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, title, description, link, imagelink, price, date FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, link VARCHAR(255) NOT NULL, imagelink VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO product (id, title, description, link, imagelink, price, date) SELECT id, title, description, link, imagelink, price, date FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }
}
