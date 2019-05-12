<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190328210316 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify User - add marketing flag (not equal to Newsletter list)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD marketing TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP marketing');
    }
}
