<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190414211531 extends Migration
{
    public function getDescription(): string
    {
        return 'Add Volunteer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE volunteers (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            name VARCHAR(120) NOT NULL,
            birth_year SMALLINT NOT NULL,
            phone_number VARCHAR(9) NOT NULL,
            email VARCHAR(80) NOT NULL,
            arrangement_days JSON NOT NULL,
            help_in JSON NOT NULL,
            been_volunteer TINYINT(1) NOT NULL,
            been_volunteer_duties LONGTEXT DEFAULT NULL,
            shirt_type SMALLINT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_A5E848971F7E88B (event_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE volunteers
            ADD CONSTRAINT FK_A5E848971F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE volunteers');
    }
}
