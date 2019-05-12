<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190306125104 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Event Competitions - allow to sort';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE competitions ADD sort_order SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE competitions DROP sort_order');
    }
}
