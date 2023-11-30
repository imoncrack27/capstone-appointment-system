<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_time_format_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_time_format_setting extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'time_format',
            'value' => 'regular'
        ]);
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'time_format']);
    }
}
