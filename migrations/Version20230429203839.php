<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429203839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workflowpaiement DROP FOREIGN KEY FK_C7D80DD3C755704D');
        $this->addSql('DROP TABLE workflowpaiement');
        $this->addSql('ALTER TABLE facture_client ADD paiement VARCHAR(255) DEFAULT NULL, ADD livraison VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture_fournisseur ADD paiement VARCHAR(255) DEFAULT NULL, ADD livraison VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD tva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649ED5CA9E6 ON user (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workflowpaiement (id INT AUTO_INCREMENT NOT NULL, facture_fournisseur_id INT NOT NULL, date_emission DATETIME NOT NULL, status INT DEFAULT NULL, INDEX IDX_C7D80DD3C755704D (facture_fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE workflowpaiement ADD CONSTRAINT FK_C7D80DD3C755704D FOREIGN KEY (facture_fournisseur_id) REFERENCES facture_fournisseur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE facture_client DROP paiement, DROP livraison');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('DROP INDEX UNIQ_8D93D649ED5CA9E6 ON user');
        $this->addSql('ALTER TABLE user CHANGE service_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE facture_fournisseur DROP paiement, DROP livraison');
        $this->addSql('ALTER TABLE produit DROP tva');
    }
}
