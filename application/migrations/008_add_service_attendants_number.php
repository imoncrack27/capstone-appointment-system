<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_service_attendants_number
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_service_attendants_number extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        if ( ! $this->db->field_exists('attendants_number', 'services'))
        {
            $fields = [
                'attendants_number' => [
                    'type' => 'INT',
                    'constraint' => '11',
                    'default' => '1',
                    'after' => 'availabilities_type'
                ]
            ];

            $this->dbforge->add_column('services', $fields);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ($this->db->field_exists('attendants_number', 'services'))
        {
            $this->dbforge->drop_column('services', 'attendants_number');
        }
    }
}
