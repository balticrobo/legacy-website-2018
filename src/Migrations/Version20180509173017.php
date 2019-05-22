<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180509173017 extends Migration
{
    public function getDescription(): string
    {
        return 'Add Event information (special element showed in Competitor Zone)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE registration_information (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            type SMALLINT NOT NULL,
            message LONGTEXT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_6BF6BB2671F7E88B (event_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_information
          ADD CONSTRAINT FK_6BF6BB2671F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE registration_information');
    }
}
