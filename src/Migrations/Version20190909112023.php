<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909112023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE document_student');
        $this->addSql('ALTER TABLE document ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76CB944F1A ON document (student_id)');
        $this->addSql('ALTER TABLE presence_lunch RENAME INDEX idx_57227287a40a2c8 TO IDX_A0C33A5BA40A2C8');
        $this->addSql('ALTER TABLE presence_lunch RENAME INDEX idx_57227287cb944f1a TO IDX_A0C33A5BCB944F1A');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE document_student (document_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_134C09EFC33F7837 (document_id), INDEX IDX_134C09EFCB944F1A (student_id), PRIMARY KEY(document_id, student_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE document_student ADD CONSTRAINT FK_134C09EFC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_student ADD CONSTRAINT FK_134C09EFCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76CB944F1A');
        $this->addSql('DROP INDEX IDX_D8698A76CB944F1A ON document');
        $this->addSql('ALTER TABLE document DROP student_id');
        $this->addSql('ALTER TABLE presence_lunch RENAME INDEX idx_a0c33a5ba40a2c8 TO IDX_57227287A40A2C8');
        $this->addSql('ALTER TABLE presence_lunch RENAME INDEX idx_a0c33a5bcb944f1a TO IDX_57227287CB944F1A');
    }
}
