<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912194715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_status_message DROP FOREIGN KEY FK_E0FA13B214E068B');
        $this->addSql('ALTER TABLE message_status_user DROP FOREIGN KEY FK_D5EA252414E068B');
        $this->addSql('DROP TABLE message_status');
        $this->addSql('DROP TABLE message_status_message');
        $this->addSql('DROP TABLE message_status_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_status (id INT AUTO_INCREMENT NOT NULL, delete_status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message_status_message (message_status_id INT NOT NULL, message_id INT NOT NULL, INDEX IDX_E0FA13B214E068B (message_status_id), INDEX IDX_E0FA13B2537A1329 (message_id), PRIMARY KEY(message_status_id, message_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message_status_user (message_status_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D5EA252414E068B (message_status_id), INDEX IDX_D5EA2524A76ED395 (user_id), PRIMARY KEY(message_status_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE message_status_message ADD CONSTRAINT FK_E0FA13B214E068B FOREIGN KEY (message_status_id) REFERENCES message_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_status_message ADD CONSTRAINT FK_E0FA13B2537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_status_user ADD CONSTRAINT FK_D5EA252414E068B FOREIGN KEY (message_status_id) REFERENCES message_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_status_user ADD CONSTRAINT FK_D5EA2524A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
