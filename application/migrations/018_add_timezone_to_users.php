<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_timezone_to_users
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_timezone_to_users extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        if ( ! $this->db->field_exists('timezone', 'users'))
        {
            $fields = [
                'timezone' => [
                    'type' => 'VARCHAR',
                    'constraint' => '256',
                    'default' => 'UTC',
                    'after' => 'notes'
                ]
            ];

            $this->dbforge->add_column('users', $fields);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        $this->dbforge->drop_column('users', 'timezone');
    }
}
