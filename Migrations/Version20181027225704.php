<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181027225704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE event_store_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event_store (id integer NOT NULL DEFAULT nextval(\'event_store_id_seq\'::regclass), data JSONB NOT NULL, PRIMARY KEY(id))');
        $this->addSql("CREATE INDEX event_store_data_aggregate_id_idx ON event_store USING GIN ((data->'payload'->'aggregate_id'))");
        $this->addSql("CREATE INDEX event_store_data_type_idx ON event_store USING GIN ((data->'event_type'))");
        $this->addSql("CREATE INDEX event_store_data_idx ON event_store USING GIN (data)");
        $this->addSql("CREATE INDEX event_store_data_name_idx ON event_store USING GIN ((data -> 'name'))");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE event_store');
        $this->addSql('DROP SEQUENCE event_store_id_seq CASCADE');
    }
}
