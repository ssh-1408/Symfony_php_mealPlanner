<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430124803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Removed to avoid "Duplicate column" error:
        // $this->addSql(<<<'SQL'
        //     ALTER TABLE meal_plan ADD mealtime VARCHAR(255) NOT NULL, CHANGE meal_date meal_date DATE NOT NULL
        // SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD is_approved TINYINT(1) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE meal_plan DROP mealtime, CHANGE meal_date meal_date DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP is_approved
        SQL);
    }
}
