<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201112012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description_user ADD author_id INT DEFAULT NULL, CHANGE birth_date birthdate DATE NOT NULL');
        $this->addSql('ALTER TABLE description_user ADD CONSTRAINT FK_7B9B495DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7B9B495DF675F31B ON description_user (author_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494443C628');
        $this->addSql('DROP INDEX IDX_8D93D6494443C628 ON user');
        $this->addSql('ALTER TABLE user DROP description_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description_user DROP FOREIGN KEY FK_7B9B495DF675F31B');
        $this->addSql('DROP INDEX IDX_7B9B495DF675F31B ON description_user');
        $this->addSql('ALTER TABLE description_user DROP author_id, CHANGE birthdate birth_date DATE NOT NULL');
        $this->addSql('ALTER TABLE user ADD description_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494443C628 FOREIGN KEY (description_user_id) REFERENCES description_user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494443C628 ON user (description_user_id)');
    }
}
