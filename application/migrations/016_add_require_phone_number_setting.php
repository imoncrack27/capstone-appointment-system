<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_require_phone_number_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_require_phone_number_setting extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'require_phone_number',
            'value' => '1'
        ]);
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'require_phone_number']);
    }
}
