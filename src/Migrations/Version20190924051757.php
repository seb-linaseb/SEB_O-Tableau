<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190924051757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, student_id INT DEFAULT NULL, name VARCHAR(65) NOT NULL, document_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D8698A76A76ED395 (user_id), INDEX IDX_D8698A76CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, username VARCHAR(65) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, mobile_phone VARCHAR(20) DEFAULT NULL, job_phone VARCHAR(20) DEFAULT NULL, communication_agreement TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, image_agreement TINYINT(1) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, school_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_497D309DA76ED395 (user_id), INDEX IDX_497D309DC32A47EE (school_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_post_id INT DEFAULT NULL, content LONGTEXT NOT NULL, read_status TINYINT(1) NOT NULL, document_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6BD307F13841D26 (user_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_conversation (message_id INT NOT NULL, conversation_id INT NOT NULL, INDEX IDX_4E8F130F537A1329 (message_id), INDEX IDX_4E8F130F9AC0396 (conversation_id), PRIMARY KEY(message_id, conversation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_user (message_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_24064D90537A1329 (message_id), INDEX IDX_24064D90A76ED395 (user_id), PRIMARY KEY(message_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_status (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, user_id INT DEFAULT NULL, remove TINYINT(1) NOT NULL, INDEX IDX_4C27F813537A1329 (message_id), INDEX IDX_4C27F813A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lunch_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, is_worked TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alert (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_17FD46C1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, user_consult_id INT DEFAULT NULL, user_participate_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8A8E26E99F760A74 (user_consult_id), INDEX IDX_8A8E26E9346C5099 (user_participate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence_lunch (id INT AUTO_INCREMENT NOT NULL, calendar_id INT DEFAULT NULL, student_id INT DEFAULT NULL, is_present TINYINT(1) NOT NULL, is_ordered TINYINT(1) NOT NULL, is_canceled TINYINT(1) NOT NULL, has_eated TINYINT(1) NOT NULL, INDEX IDX_A0C33A5BA40A2C8 (calendar_id), INDEX IDX_A0C33A5BCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actuality (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, picture_url VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4093DDD8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actuality_classroom (actuality_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_486B3E38B84BD854 (actuality_id), INDEX IDX_486B3E386278D5A8 (classroom_id), PRIMARY KEY(actuality_id, classroom_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, classroom_id INT DEFAULT NULL, lunch_type_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthdate DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, image_rights TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, monday_lunch TINYINT(1) NOT NULL, tuesday_lunch TINYINT(1) NOT NULL, wednesday_lunch TINYINT(1) NOT NULL, thursday_lunch TINYINT(1) NOT NULL, friday_lunch TINYINT(1) NOT NULL, INDEX IDX_B723AF336278D5A8 (classroom_id), INDEX IDX_B723AF332C3B40B5 (lunch_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_user (student_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B2B0AD91CB944F1A (student_id), INDEX IDX_B2B0AD91A76ED395 (user_id), PRIMARY KEY(student_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_person (student_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_BAEA09F6CB944F1A (student_id), INDEX IDX_BAEA09F6217BBB47 (person_id), PRIMARY KEY(student_id, person_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F13841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_conversation ADD CONSTRAINT FK_4E8F130F537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_conversation ADD CONSTRAINT FK_4E8F130F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_status ADD CONSTRAINT FK_4C27F813537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_status ADD CONSTRAINT FK_4C27F813A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E99F760A74 FOREIGN KEY (user_consult_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9346C5099 FOREIGN KEY (user_participate_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE presence_lunch ADD CONSTRAINT FK_A0C33A5BA40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE presence_lunch ADD CONSTRAINT FK_A0C33A5BCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE actuality ADD CONSTRAINT FK_4093DDD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE actuality_classroom ADD CONSTRAINT FK_486B3E38B84BD854 FOREIGN KEY (actuality_id) REFERENCES actuality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actuality_classroom ADD CONSTRAINT FK_486B3E386278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF332C3B40B5 FOREIGN KEY (lunch_type_id) REFERENCES lunch_type (id)');
        $this->addSql('ALTER TABLE student_user ADD CONSTRAINT FK_B2B0AD91CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_user ADD CONSTRAINT FK_B2B0AD91A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_person ADD CONSTRAINT FK_BAEA09F6CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_person ADD CONSTRAINT FK_BAEA09F6217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DC32A47EE');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F13841D26');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90A76ED395');
        $this->addSql('ALTER TABLE message_status DROP FOREIGN KEY FK_4C27F813A76ED395');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1A76ED395');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E99F760A74');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9346C5099');
        $this->addSql('ALTER TABLE actuality DROP FOREIGN KEY FK_4093DDD8A76ED395');
        $this->addSql('ALTER TABLE student_user DROP FOREIGN KEY FK_B2B0AD91A76ED395');
        $this->addSql('ALTER TABLE student_person DROP FOREIGN KEY FK_BAEA09F6217BBB47');
        $this->addSql('ALTER TABLE actuality_classroom DROP FOREIGN KEY FK_486B3E386278D5A8');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF336278D5A8');
        $this->addSql('ALTER TABLE message_conversation DROP FOREIGN KEY FK_4E8F130F537A1329');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90537A1329');
        $this->addSql('ALTER TABLE message_status DROP FOREIGN KEY FK_4C27F813537A1329');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF332C3B40B5');
        $this->addSql('ALTER TABLE presence_lunch DROP FOREIGN KEY FK_A0C33A5BA40A2C8');
        $this->addSql('ALTER TABLE message_conversation DROP FOREIGN KEY FK_4E8F130F9AC0396');
        $this->addSql('ALTER TABLE actuality_classroom DROP FOREIGN KEY FK_486B3E38B84BD854');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76CB944F1A');
        $this->addSql('ALTER TABLE presence_lunch DROP FOREIGN KEY FK_A0C33A5BCB944F1A');
        $this->addSql('ALTER TABLE student_user DROP FOREIGN KEY FK_B2B0AD91CB944F1A');
        $this->addSql('ALTER TABLE student_person DROP FOREIGN KEY FK_BAEA09F6CB944F1A');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_conversation');
        $this->addSql('DROP TABLE message_user');
        $this->addSql('DROP TABLE message_status');
        $this->addSql('DROP TABLE lunch_type');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE presence_lunch');
        $this->addSql('DROP TABLE actuality');
        $this->addSql('DROP TABLE actuality_classroom');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_user');
        $this->addSql('DROP TABLE student_person');
    }
}
