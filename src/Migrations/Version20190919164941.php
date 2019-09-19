<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919164941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE student_lunch_type');
        $this->addSql('ALTER TABLE student ADD lunch_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF332C3B40B5 FOREIGN KEY (lunch_type_id) REFERENCES lunch_type (id)');
        $this->addSql('CREATE INDEX IDX_B723AF332C3B40B5 ON student (lunch_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE student_lunch_type (student_id INT NOT NULL, lunch_type_id INT NOT NULL, INDEX IDX_F3FB5E1A2C3B40B5 (lunch_type_id), INDEX IDX_F3FB5E1ACB944F1A (student_id), PRIMARY KEY(student_id, lunch_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_lunch_type ADD CONSTRAINT FK_F3FB5E1A2C3B40B5 FOREIGN KEY (lunch_type_id) REFERENCES lunch_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_lunch_type ADD CONSTRAINT FK_F3FB5E1ACB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF332C3B40B5');
        $this->addSql('DROP INDEX IDX_B723AF332C3B40B5 ON student');
        $this->addSql('ALTER TABLE student DROP lunch_type_id');
    }
}
