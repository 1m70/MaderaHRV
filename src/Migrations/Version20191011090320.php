<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011090320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE coverage (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(50) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE finition (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, finition INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE floor (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gamme (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE isolation (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, finition_id INT DEFAULT NULL, isolation_id INT DEFAULT NULL, coverage_id INT DEFAULT NULL, floor_id INT DEFAULT NULL, structure_id INT DEFAULT NULL, plan_id INT DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C242628C54C8C93 (type_id), INDEX IDX_C242628CB56F5AF (finition_id), INDEX IDX_C2426284153FF48 (isolation_id), INDEX IDX_C2426289F5AA71B (coverage_id), INDEX IDX_C242628854679E2 (floor_id), INDEX IDX_C2426282534008B (structure_id), INDEX IDX_C242628E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, percent INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, quotation_id INT DEFAULT NULL, project_id INT DEFAULT NULL, gamme_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, blueprint LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_DD5A5B7DB4EA4E60 (quotation_id), UNIQUE INDEX UNIQ_DD5A5B7D166D1F9C (project_id), INDEX IDX_DD5A5B7DD2FD85F1 (gamme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, user_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, plan_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_2FB3D0EE9395C3F3 (customer_id), INDEX IDX_2FB3D0EEA76ED395 (user_id), UNIQUE INDEX UNIQ_2FB3D0EE4C3A3BB (payment_id), UNIQUE INDEX UNIQ_2FB3D0EEE899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, date_end DATETIME DEFAULT NULL, prix_ht DOUBLE PRECISION DEFAULT NULL, prix_ttc DOUBLE PRECISION DEFAULT NULL, state TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adress VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(50) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628CB56F5AF FOREIGN KEY (finition_id) REFERENCES finition (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426284153FF48 FOREIGN KEY (isolation_id) REFERENCES isolation (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426289F5AA71B FOREIGN KEY (coverage_id) REFERENCES coverage (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628854679E2 FOREIGN KEY (floor_id) REFERENCES floor (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426282534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DD2FD85F1 FOREIGN KEY (gamme_id) REFERENCES gamme (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEE899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426289F5AA71B');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE9395C3F3');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628CB56F5AF');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628854679E2');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DD2FD85F1');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426284153FF48');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE4C3A3BB');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628E899029B');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEE899029B');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D166D1F9C');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DB4EA4E60');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426282534008B');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C54C8C93');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('DROP TABLE coverage');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE finition');
        $this->addSql('DROP TABLE floor');
        $this->addSql('DROP TABLE gamme');
        $this->addSql('DROP TABLE isolation');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
