<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180516200950 extends Migration
{
    public function getDescription(): string
    {
        return 'Add Files component (to store info about images and other uploaded files)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE storage_files (
            id INT AUTO_INCREMENT NOT NULL,
            description LONGTEXT NOT NULL,
            original_filename VARCHAR(255) NOT NULL,
            filename VARCHAR(50) NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE storage_files');
    }
}
