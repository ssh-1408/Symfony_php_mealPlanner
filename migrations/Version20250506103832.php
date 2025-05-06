<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506103832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list DROP FOREIGN KEY FK_3DC1A459A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3DC1A459A76ED395 ON shopping_list
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list ADD amount VARCHAR(255) NOT NULL, DROP user_id, DROP ingredients_list, DROP created_at
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list ADD user_id INT NOT NULL, ADD ingredients_list LONGTEXT NOT NULL, ADD created_at DATETIME NOT NULL, DROP amount
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3DC1A459A76ED395 ON shopping_list (user_id)
        SQL);
    }
}
