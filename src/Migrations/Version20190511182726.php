<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190511182726 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Hackathon Team - add "chosen" field to flag selected Teams';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_teams_hackathon ADD chosen TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_teams_hackathon DROP chosen');
    }
}
