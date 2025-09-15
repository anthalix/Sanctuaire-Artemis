<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903095808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, frontuser_id INT DEFAULT NULL, INDEX IDX_2C9211FE537A1329 (message_id), INDEX IDX_2C9211FEBCA172FF (frontuser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FE537A1329 FOREIGN KEY (message_id) REFERENCES message (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEBCA172FF FOREIGN KEY (frontuser_id) REFERENCES front_user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE front_user CHANGE tel tel VARCHAR(20) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FE537A1329
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FEBCA172FF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contact_message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE front_user CHANGE tel tel VARCHAR(15) DEFAULT NULL
        SQL);
    }
}
