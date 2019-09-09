<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909123734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE presence_lunch (id INT AUTO_INCREMENT NOT NULL, calendar_id INT DEFAULT NULL, student_id INT DEFAULT NULL, is_present TINYINT(1) NOT NULL, is_ordered TINYINT(1) NOT NULL, is_canceled TINYINT(1) NOT NULL, has_eated TINYINT(1) NOT NULL, INDEX IDX_A0C33A5BA40A2C8 (calendar_id), INDEX IDX_A0C33A5BCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE presence_lunch ADD CONSTRAINT FK_A0C33A5BA40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE presence_lunch ADD CONSTRAINT FK_A0C33A5BCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('DROP TABLE has_status');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE has_status (id INT AUTO_INCREMENT NOT NULL, calendar_id INT DEFAULT NULL, student_id INT DEFAULT NULL, is_present TINYINT(1) NOT NULL, is_ordered TINYINT(1) NOT NULL, is_canceled TINYINT(1) NOT NULL, has_eated TINYINT(1) NOT NULL, INDEX IDX_57227287A40A2C8 (calendar_id), INDEX IDX_57227287CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE has_status ADD CONSTRAINT FK_57227287A40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE has_status ADD CONSTRAINT FK_57227287CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('DROP TABLE presence_lunch');
    }
}
