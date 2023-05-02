<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428095924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_produit_fournisseur ADD produit_id INT NOT NULL, ADD facture_fournisseur_id INT NOT NULL, ADD quantity DOUBLE PRECISION NOT NULL, ADD remise DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ligne_produit_fournisseur ADD CONSTRAINT FK_9388CCF5F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_produit_fournisseur ADD CONSTRAINT FK_9388CCF5C755704D FOREIGN KEY (facture_fournisseur_id) REFERENCES facture_fournisseur (id)');
        $this->addSql('CREATE INDEX IDX_9388CCF5F347EFB ON ligne_produit_fournisseur (produit_id)');
        $this->addSql('CREATE INDEX IDX_9388CCF5C755704D ON ligne_produit_fournisseur (facture_fournisseur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_produit_fournisseur DROP FOREIGN KEY FK_9388CCF5F347EFB');
        $this->addSql('ALTER TABLE ligne_produit_fournisseur DROP FOREIGN KEY FK_9388CCF5C755704D');
        $this->addSql('DROP INDEX IDX_9388CCF5F347EFB ON ligne_produit_fournisseur');
        $this->addSql('DROP INDEX IDX_9388CCF5C755704D ON ligne_produit_fournisseur');
        $this->addSql('ALTER TABLE ligne_produit_fournisseur DROP produit_id, DROP facture_fournisseur_id, DROP quantity, DROP remise');
    }
}
