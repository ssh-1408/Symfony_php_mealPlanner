<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515072057 extends AbstractMigration
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
            CREATE TABLE meal_plan (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_id INT NOT NULL, meal_date DATE NOT NULL, mealtime VARCHAR(255) NOT NULL, INDEX IDX_C7848889A76ED395 (user_id), INDEX IDX_C784888959D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, ingredients LONGTEXT NOT NULL, preparation_time INT NOT NULL, calories INT NOT NULL, is_vegetarian TINYINT(1) NOT NULL, is_vegan TINYINT(1) NOT NULL, allergens LONGTEXT NOT NULL, nutrients LONGTEXT NOT NULL, external_link VARCHAR(255) DEFAULT NULL, approved_by_admin TINYINT(1) NOT NULL, average_rating DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_DA88B137B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe_rating (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, user_id INT NOT NULL, stars INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5597380359D8A214 (recipe_id), INDEX IDX_55973803A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_blocked TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bmi ADD CONSTRAINT FK_502F0A4AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meal_plan ADD CONSTRAINT FK_C7848889A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meal_plan ADD CONSTRAINT FK_C784888959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_rating ADD CONSTRAINT FK_5597380359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_rating ADD CONSTRAINT FK_55973803A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bmi DROP FOREIGN KEY FK_502F0A4AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meal_plan DROP FOREIGN KEY FK_C7848889A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meal_plan DROP FOREIGN KEY FK_C784888959D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_rating DROP FOREIGN KEY FK_5597380359D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_rating DROP FOREIGN KEY FK_55973803A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bmi
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE meal_plan
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe_rating
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
