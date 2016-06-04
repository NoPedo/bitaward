<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160604154709 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE checkout (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, paid_at DATETIME DEFAULT NULL, amount NUMERIC(10, 6) NOT NULL, checkout_id VARCHAR(255) NOT NULL, embed_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE award ADD checkout_id INT NOT NULL');
		$this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7146D8724 FOREIGN KEY (checkout_id) REFERENCES checkout (id)');
		$this->addSql('CREATE INDEX IDX_8A5B2EE7146D8724 ON award (checkout_id)');
	}


	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7146D8724');
		$this->addSql('DROP TABLE checkout');
		$this->addSql('DROP INDEX IDX_8A5B2EE7146D8724 ON award');
		$this->addSql('ALTER TABLE award DROP checkout_id');
	}
}
