<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191007165935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE1CEE4D62');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, postal_code VARCHAR(50) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE saler');
        $this->addSql('ALTER TABLE finition CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE module CHANGE type_id type_id INT DEFAULT NULL, CHANGE finition_id finition_id INT DEFAULT NULL, CHANGE isolation_id isolation_id INT DEFAULT NULL, CHANGE coverage_id coverage_id INT DEFAULT NULL, CHANGE floor_id floor_id INT DEFAULT NULL, CHANGE structure_id structure_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL, CHANGE length length DOUBLE PRECISION DEFAULT NULL, CHANGE width width DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE plan CHANGE quotation_id quotation_id INT DEFAULT NULL, CHANGE project_id project_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_2FB3D0EE1CEE4D62 ON project');
        $this->addSql('ALTER TABLE project ADD user_id INT DEFAULT NULL, DROP saler_id, CHANGE payment_id payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEA76ED395 ON project (user_id)');
        $this->addSql('ALTER TABLE quotation CHANGE date_end date_end DATETIME DEFAULT NULL, CHANGE prix_ht prix_ht DOUBLE PRECISION DEFAULT NULL, CHANGE prix_ttc prix_ttc DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('CREATE TABLE saler (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, city VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, country VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, postal_code VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, lastname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE finition CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE module CHANGE type_id type_id INT DEFAULT NULL, CHANGE finition_id finition_id INT DEFAULT NULL, CHANGE isolation_id isolation_id INT DEFAULT NULL, CHANGE coverage_id coverage_id INT DEFAULT NULL, CHANGE floor_id floor_id INT DEFAULT NULL, CHANGE structure_id structure_id INT DEFAULT NULL, CHANGE plan_id plan_id INT DEFAULT NULL, CHANGE length length DOUBLE PRECISION DEFAULT \'NULL\', CHANGE width width DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE plan CHANGE quotation_id quotation_id INT DEFAULT NULL, CHANGE project_id project_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_2FB3D0EEA76ED395 ON project');
        $this->addSql('ALTER TABLE project ADD saler_id INT DEFAULT NULL, DROP user_id, CHANGE payment_id payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE1CEE4D62 FOREIGN KEY (saler_id) REFERENCES saler (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE1CEE4D62 ON project (saler_id)');
        $this->addSql('ALTER TABLE quotation CHANGE date_end date_end DATETIME DEFAULT \'NULL\', CHANGE prix_ht prix_ht DOUBLE PRECISION DEFAULT \'NULL\', CHANGE prix_ttc prix_ttc DOUBLE PRECISION DEFAULT \'NULL\'');
    }
}
