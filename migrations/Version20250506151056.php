<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506151056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list CHANGE user_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3DC1A459A76ED395 ON shopping_list (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list_item DROP list
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list DROP FOREIGN KEY FK_3DC1A459A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3DC1A459A76ED395 ON shopping_list
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list CHANGE user_id user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list_item ADD list VARCHAR(255) NOT NULL
        SQL);
    }
}
