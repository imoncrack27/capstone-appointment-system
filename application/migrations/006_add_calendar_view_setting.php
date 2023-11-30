<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_calendar_view_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_calendar_view_setting extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        if ( ! $this->db->field_exists('calendar_view', 'user_settings'))
        {
            $fields = [
                'calendar_view' => [
                    'type' => 'VARCHAR',
                    'constraint' => '32',
                    'default' => 'default'
                ]
            ];

            $this->dbforge->add_column('user_settings', $fields);

            $this->db->update('user_settings', ['calendar_view' => 'default']);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ($this->db->field_exists('calendar_view', 'user_settings'))
        {
            $this->dbforge->drop_column('user_settings', 'calendar_view');
        }
    }
}
