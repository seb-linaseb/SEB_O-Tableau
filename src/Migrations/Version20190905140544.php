<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190905140544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE has_status ADD classroom_id INT DEFAULT NULL, ADD calendar_id INT DEFAULT NULL, ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE has_status ADD CONSTRAINT FK_572272876278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE has_status ADD CONSTRAINT FK_57227287A40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE has_status ADD CONSTRAINT FK_57227287CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_572272876278D5A8 ON has_status (classroom_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57227287A40A2C8 ON has_status (calendar_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57227287CB944F1A ON has_status (student_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE has_status DROP FOREIGN KEY FK_572272876278D5A8');
        $this->addSql('ALTER TABLE has_status DROP FOREIGN KEY FK_57227287A40A2C8');
        $this->addSql('ALTER TABLE has_status DROP FOREIGN KEY FK_57227287CB944F1A');
        $this->addSql('DROP INDEX UNIQ_572272876278D5A8 ON has_status');
        $this->addSql('DROP INDEX UNIQ_57227287A40A2C8 ON has_status');
        $this->addSql('DROP INDEX UNIQ_57227287CB944F1A ON has_status');
        $this->addSql('ALTER TABLE has_status DROP classroom_id, DROP calendar_id, DROP student_id');
    }
}
