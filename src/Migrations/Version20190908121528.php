<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190908121528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE presence_lunch DROP INDEX UNIQ_57227287CB944F1A, ADD INDEX IDX_57227287CB944F1A (student_id)');
        $this->addSql('ALTER TABLE presence_lunch DROP INDEX UNIQ_57227287A40A2C8, ADD INDEX IDX_57227287A40A2C8 (calendar_id)');
        $this->addSql('ALTER TABLE presence_lunch DROP FOREIGN KEY FK_572272876278D5A8');
        $this->addSql('DROP INDEX UNIQ_572272876278D5A8 ON presence_lunch');
        $this->addSql('ALTER TABLE presence_lunch DROP classroom_id');
        $this->addSql('ALTER TABLE student ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_B723AF336278D5A8 ON student (classroom_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE presence_lunch DROP INDEX IDX_57227287A40A2C8, ADD UNIQUE INDEX UNIQ_57227287A40A2C8 (calendar_id)');
        $this->addSql('ALTER TABLE presence_lunch DROP INDEX IDX_57227287CB944F1A, ADD UNIQUE INDEX UNIQ_57227287CB944F1A (student_id)');
        $this->addSql('ALTER TABLE presence_lunch ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_lunch ADD CONSTRAINT FK_572272876278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_572272876278D5A8 ON presence_lunch (classroom_id)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF336278D5A8');
        $this->addSql('DROP INDEX IDX_B723AF336278D5A8 ON student');
        $this->addSql('ALTER TABLE student DROP classroom_id');
    }
}
