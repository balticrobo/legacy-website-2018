<?php

declare(strict_types = 1);

namespace <namespace>;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version<version> extends Migration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
<up>
    }

    public function down(Schema $schema): void
    {
<down>
    }
}
