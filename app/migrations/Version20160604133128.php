<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160604133128 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, payout_at DATETIME DEFAULT NULL, INDEX IDX_8A5B2EE7712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
	}


	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7712520F3');
		$this->addSql('DROP TABLE award');
		$this->addSql('DROP TABLE wallet');
	}
}
