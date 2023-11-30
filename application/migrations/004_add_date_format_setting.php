<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_date_format_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_date_format_setting extends CI_Migration {
    /**
     * Upgrade method.
     *
     * @throws Exception
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'date_format',
            'value' => 'DMY'
        ]);
    }

    /**
     * Downgrade method.
     *
     * @throws Exception
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'date_format']);
    }
}
