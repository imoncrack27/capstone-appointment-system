<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_weekday_start_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_weekday_start_setting extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'first_weekday',
            'value' => 'sunday'
        ]);
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'first_weekday']);
    }
}
