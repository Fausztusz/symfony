<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260208114757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, status ENUM(\'PLANNED\', \'ACTIVE\', \'COMPLETED\') DEFAULT \'PLANNED\' NOT NULL, team_id INT NOT NULL, INDEX IDX_2FB3D0EE296CD8AE (team_id), INDEX status_idx (status), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, status ENUM(\'TODO\', \'IN_PROGRESS\', \'DONE\') DEFAULT \'TODO\' NOT NULL, priority ENUM(\'LOW\', \'MEDIUM\', \'HIGH\') DEFAULT \'MEDIUM\' NOT NULL, due_date DATETIME DEFAULT NULL, assignee_id INT DEFAULT NULL, project_id INT NOT NULL, INDEX IDX_527EDB2559EC7D60 (assignee_id), INDEX IDX_527EDB25166D1F9C (project_id), INDEX status_idx (status), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_C4E0A61F5E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE team_user (team_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5C722232296CD8AE (team_id), INDEX IDX_5C722232A76ED395 (user_id), PRIMARY KEY (team_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, role ENUM(\'ADMIN\', \'MEMBER\') DEFAULT \'MEMBER\' NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2559EC7D60 FOREIGN KEY (assignee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT FK_5C722232296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT FK_5C722232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE296CD8AE');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2559EC7D60');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE team_user DROP FOREIGN KEY FK_5C722232296CD8AE');
        $this->addSql('ALTER TABLE team_user DROP FOREIGN KEY FK_5C722232A76ED395');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_user');
        $this->addSql('DROP TABLE user');
    }
}
