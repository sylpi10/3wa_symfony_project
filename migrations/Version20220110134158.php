<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110134158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkpoint (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checkpoint_producteur (checkpoint_id INT NOT NULL, producteur_id INT NOT NULL, INDEX IDX_3BDDCEA1F27C615F (checkpoint_id), INDEX IDX_3BDDCEA1AB9BB300 (producteur_id), PRIMARY KEY(checkpoint_id, producteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, producteur_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_D34A04ADAB9BB300 (producteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producteur (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checkpoint_producteur ADD CONSTRAINT FK_3BDDCEA1F27C615F FOREIGN KEY (checkpoint_id) REFERENCES checkpoint (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE checkpoint_producteur ADD CONSTRAINT FK_3BDDCEA1AB9BB300 FOREIGN KEY (producteur_id) REFERENCES producteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAB9BB300 FOREIGN KEY (producteur_id) REFERENCES producteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checkpoint_producteur DROP FOREIGN KEY FK_3BDDCEA1F27C615F');
        $this->addSql('ALTER TABLE checkpoint_producteur DROP FOREIGN KEY FK_3BDDCEA1AB9BB300');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADAB9BB300');
        $this->addSql('DROP TABLE checkpoint');
        $this->addSql('DROP TABLE checkpoint_producteur');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE producteur');
    }
}
