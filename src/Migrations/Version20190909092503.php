<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909092503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conversation ADD user_consult_id INT DEFAULT NULL, ADD user_participate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E99F760A74 FOREIGN KEY (user_consult_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9346C5099 FOREIGN KEY (user_participate_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E99F760A74 ON conversation (user_consult_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9346C5099 ON conversation (user_participate_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E99F760A74');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9346C5099');
        $this->addSql('DROP INDEX IDX_8A8E26E99F760A74 ON conversation');
        $this->addSql('DROP INDEX IDX_8A8E26E9346C5099 ON conversation');
        $this->addSql('ALTER TABLE conversation DROP user_consult_id, DROP user_participate_id');
    }
}
