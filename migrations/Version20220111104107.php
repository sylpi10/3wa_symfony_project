<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111104107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4EB140083124B5B6 ON final_user');
        $this->addSql('DROP INDEX UNIQ_4EB1400883A00E68 ON final_user');
        $this->addSql('DROP INDEX UNIQ_4BD76D443124B5B6 ON organisateur');
        $this->addSql('DROP INDEX UNIQ_4BD76D4483A00E68 ON organisateur');
        $this->addSql('DROP INDEX UNIQ_7EDBEE103124B5B6 ON producteur');
        $this->addSql('DROP INDEX UNIQ_7EDBEE1083A00E68 ON producteur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EB140083124B5B6 ON final_user (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EB1400883A00E68 ON final_user (firstname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BD76D443124B5B6 ON organisateur (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BD76D4483A00E68 ON organisateur (firstname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7EDBEE103124B5B6 ON producteur (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7EDBEE1083A00E68 ON producteur (firstname)');
    }
}
