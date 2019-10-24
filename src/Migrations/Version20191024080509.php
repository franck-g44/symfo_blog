<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024080509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, written_by_id INT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(80) NOT NULL, published_at DATETIME DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_23A0E66AB69C8EF (written_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66AB69C8EF FOREIGN KEY (written_by_id) REFERENCES author (id)');
        $this->addSql('DROP TABLE blog_article');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog_article (id INT AUTO_INCREMENT NOT NULL, written_by_id INT NOT NULL, title VARCHAR(80) NOT NULL COLLATE utf8mb4_unicode_ci, published_at DATETIME DEFAULT NULL, content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_EECCB3E5AB69C8EF (written_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE blog_article ADD CONSTRAINT FK_EECCB3E5AB69C8EF FOREIGN KEY (written_by_id) REFERENCES author (id)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE user');
    }
}
