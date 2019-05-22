<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20181209133436 extends Migration
{
    public function getDescription(): string
    {
        return 'Add Newsletter list (emails)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE newsletter_emails (
            id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
            email VARCHAR(80) NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            UNIQUE INDEX UNIQ_F6DBB31BE7927C74 (email),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE newsletter_emails');
    }
}
