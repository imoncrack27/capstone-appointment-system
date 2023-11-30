<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Class Migration_Add_working_plan_exceptions_to_user_settings
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_working_plan_exceptions_to_user_settings extends CI_Migration {
    /**
     * Upgrade method.
     */
    public function up()
    {
        if ( ! $this->db->field_exists('working_plan_exceptions', 'user_settings'))
        {
            $fields = [
                'working_plan_exceptions' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                    'after' => 'working_plan'
                ]
            ];

            $this->dbforge->add_column('user_settings', $fields);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ( ! $this->db->field_exists('working_plan_exceptions', 'user_settings'))
        {
            $this->dbforge->drop_column('user_settings', 'working_plan_exceptions');
        }
    }
}
