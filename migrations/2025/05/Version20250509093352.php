<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509093352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_C82E74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, duration VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E74A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E74A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE services
        SQL);
    }
}
