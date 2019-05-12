<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190509234617 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Event - allow to toggle Volunteer form';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events ADD volunteer_registration TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events DROP volunteer_registration');
    }
}
