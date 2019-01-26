<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190121162544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD secteur_id INT DEFAULT NULL, DROP secteur');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6389F7E4405 ON contact (secteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6389F7E4405');
        $this->addSql('DROP INDEX IDX_4C62E6389F7E4405 ON contact');
        $this->addSql('ALTER TABLE contact ADD secteur INT NOT NULL, DROP secteur_id');
    }
}
