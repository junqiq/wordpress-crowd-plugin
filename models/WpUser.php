<?php namespace CrowdLogin\model;

use \WP_Error as WP_Error;
use \WP_User  as WP_User;

class WpUser
{
    private $e = '';

    /**
     * Get WP_USER with user_login;
     *
     * @return WP_User or false
     * @since 0.2.0
     */
    public function get(string $username)
    {
        $u = get_userdatabylogin($username);
        if ($u && strtolower($u->user_login) === strtolower($username)) {
            return $u;
        } else {
            return false;
        }
    }

    /**
     * Create WP_User from CwUser
     *
     * @return WP_User or false
     * @since 0.2.0
     */
    public function createByCwUser(CwUser $cuser)
    {
        $userdata = array(
            'user_pass'     => microtime(),
            'user_login'    => $cuser->username,
            'user_nicename' => sanitize_title($cuser->display_name),
            'user_email'    => $cuser->email,
            'display_name'  => $cuser->display_name,
            'first_name'    => $cuser->first_name,
            'last_name'     => $cuser->last_name,
            'role'          => $cuser->role
        );

        $ret = wp_insert_user($userdata);
        if (is_a($ret, 'WP_Error')) {
            $this->e = $ret;
            return false;
        } else {
            return new WP_User($ret);
        }
    }

    /**
     * Update WP_User from CwUser
     *
     * @return WP_User or false
     * @since 0.2.0
     */
    public function updateByCwUser(WP_User $wuser, CwUser $cuser)
    {
        $userdata = array(
            'ID'            => $wuser->ID,
            'user_pass'     => microtime(),
            'user_login'    => $cuser->username,
            'user_nicename' => sanitize_title($cuser->display_name),
            'user_email'    => $cuser->email,
            'display_name'  => $cuser->display_name,
            'first_name'    => $cuser->first_name,
            'last_name'     => $cuser->last_name,
            'role'          => $cuser->role
        );

        $ret = wp_update_user($userdata);
        if (is_a($ret, 'WP_Error')) {
            $this->e = $ret;
            return false;
        } else {
            return new WP_User($ret);
        }
    }
}
