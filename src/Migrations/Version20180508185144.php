<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180508185144 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Team - allow only unique Constructions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D77EAC75E237E06296CD8AE
          ON registration_constructions (name, team_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_2D77EAC75E237E06296CD8AE ON registration_constructions');
    }
}
