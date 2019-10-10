<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191010133807 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(50) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE finition CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE module CHANGE type_id type_id INT DEFAULT NULL, CHANGE finition_id finition_id INT DEFAULT NULL, CHANGE isolation_id isolation_id INT DEFAULT NULL, CHANGE coverage_id coverage_id INT DEFAULT NULL, CHANGE floor_id floor_id INT DEFAULT NULL, CHANGE structure_id structure_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL, CHANGE length length DOUBLE PRECISION DEFAULT NULL, CHANGE width width DOUBLE PRECISION DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE plan CHANGE quotation_id quotation_id INT DEFAULT NULL, CHANGE project_id project_id INT DEFAULT NULL, CHANGE blueprint blueprint LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE project CHANGE payment_id payment_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation CHANGE date_end date_end DATETIME DEFAULT NULL, CHANGE prix_ht prix_ht DOUBLE PRECISION DEFAULT NULL, CHANGE prix_ttc prix_ttc DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(50) DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer CHANGE adress adress VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE city city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE country country VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postal_code postal_code VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE finition CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE module CHANGE type_id type_id INT DEFAULT NULL, CHANGE finition_id finition_id INT DEFAULT NULL, CHANGE isolation_id isolation_id INT DEFAULT NULL, CHANGE coverage_id coverage_id INT DEFAULT NULL, CHANGE floor_id floor_id INT DEFAULT NULL, CHANGE structure_id structure_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL, CHANGE length length DOUBLE PRECISION DEFAULT \'NULL\', CHANGE width width DOUBLE PRECISION DEFAULT \'NULL\', CHANGE price price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plan CHANGE quotation_id quotation_id INT DEFAULT NULL, CHANGE project_id project_id INT DEFAULT NULL, CHANGE blueprint blueprint LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE project CHANGE user_id user_id INT DEFAULT NULL, CHANGE payment_id payment_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation CHANGE date_end date_end DATETIME DEFAULT \'NULL\', CHANGE prix_ht prix_ht DOUBLE PRECISION DEFAULT \'NULL\', CHANGE prix_ttc prix_ttc DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE adress adress VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE city city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE country country VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postal_code postal_code VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE firstname firstname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
