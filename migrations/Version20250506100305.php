<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506100305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE bmi (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, mass NUMERIC(5, 2) NOT NULL, height NUMERIC(5, 2) NOT NULL, age INT NOT NULL, gender VARCHAR(255) NOT NULL, bmi_value NUMERIC(10, 2) NOT NULL, calculated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', activity_level VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_502F0A4AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bmi ADD CONSTRAINT FK_502F0A4AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bmi DROP FOREIGN KEY FK_502F0A4AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bmi
        SQL);
    }
}
