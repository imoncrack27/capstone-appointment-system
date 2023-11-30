<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_api_token_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_api_token_setting extends CI_Migration {
    /**
     * Upgrade method.
     *
     * @throws Exception
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'api_token',
            'value' => ''
        ]);
    }

    /**
     * Downgrade method.
     *
     * @throws Exception
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'api_token']);
    }
}
