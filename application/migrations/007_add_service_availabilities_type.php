<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_service_availabilities_type
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_service_availabilities_type extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        if ( ! $this->db->field_exists('availabilities_type', 'services'))
        {
            $fields = [
                'availabilities_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => '32',
                    'default' => 'flexible',
                    'after' => 'description'
                ]
            ];

            $this->dbforge->add_column('services', $fields);

            $this->db->update('services', ['availabilities_type' => 'flexible']);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ($this->db->field_exists('availabilities_type', 'services'))
        {
            $this->dbforge->drop_column('services', 'availabilities_type');
        }
    }
}
