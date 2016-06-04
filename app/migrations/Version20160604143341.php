<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160604143341 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE event ADD wallet_id INT NOT NULL');
		$this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
		$this->addSql('CREATE INDEX IDX_3BAE0AA7712520F3 ON event (wallet_id)');
		$this->addSql('ALTER TABLE speaker ADD wallet_id INT DEFAULT NULL');
		$this->addSql('ALTER TABLE speaker ADD CONSTRAINT FK_7B85DB61712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
		$this->addSql('CREATE INDEX IDX_7B85DB61712520F3 ON speaker (wallet_id)');
		$this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7712520F3');
		$this->addSql('ALTER TABLE award ADD event_id INT NOT NULL, ADD speaker_id INT DEFAULT NULL, CHANGE wallet_id wallet_id INT NOT NULL');
		$this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
		$this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE771F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
		$this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
		$this->addSql('CREATE INDEX IDX_8A5B2EE771F7E88B ON award (event_id)');
		$this->addSql('CREATE INDEX IDX_8A5B2EE7D04A0F27 ON award (speaker_id)');
	}


	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE771F7E88B');
		$this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7D04A0F27');
		$this->addSql('DROP INDEX IDX_8A5B2EE771F7E88B ON award');
		$this->addSql('DROP INDEX IDX_8A5B2EE7D04A0F27 ON award');
		$this->addSql('ALTER TABLE award DROP event_id, DROP speaker_id, CHANGE wallet_id wallet_id INT DEFAULT NULL');
		$this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7712520F3');
		$this->addSql('DROP INDEX IDX_3BAE0AA7712520F3 ON event');
		$this->addSql('ALTER TABLE event DROP wallet_id');
		$this->addSql('ALTER TABLE speaker DROP FOREIGN KEY FK_7B85DB61712520F3');
		$this->addSql('DROP INDEX IDX_7B85DB61712520F3 ON speaker');
		$this->addSql('ALTER TABLE speaker DROP wallet_id');
	}
}
