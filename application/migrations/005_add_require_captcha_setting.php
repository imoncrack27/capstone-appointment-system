<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Class Migration_Add_require_captcha_setting
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_require_captcha_setting extends CI_Migration {
    /**
     * Upgrade method.
     *
     * @throws Exception
     */
    public function up()
    {
        $this->db->insert('settings', [
            'name' => 'require_captcha',
            'value' => '0'
        ]);
    }

    /**
     * Downgrade method.
     *
     * @throws Exception
     */
    public function down()
    {
        $this->db->delete('settings', ['name' => 'require_captcha']);
    }
}
