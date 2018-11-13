<?php namespace CrowdLogin\repository;

use CrowdLogin\model\WpUser as WpUser;
use CrowdLogin\model\CwUser as CwUser;

class UserRepository
{
    public $emsg = ''; //error message

    /**
     * Authenticate
     *
     * @return WP_User or false or WP_Error
     * @since 0.2.0
     */
    public function getWithAuth(string $username, string $password)
    {
        global $gcl_config;
        $cw_user = new CwUser();
        $wp_user = new WpUser();

        $cuser = $cw_user->authentication($username, $password);
        if ($cuser === false) {
            $this->emsg = $cw_user->emsg;
            return false;
        } else {
            $wuser = $wp_user->get($username);
            if (!$wuser) {
                if ($gcl_config->get('crowd_login_mode') === 'mode_create') {
                    return $wp_user->createByCwUser($cuser);
                } else {
                    $this->emsg = __('<strong>Crowd Login Error</strong>: Crowd Login mode does not permit account creation.', 'crowd-login');
                    return false;
                }
            } else {
                if ($wuser->roles[0] !== $cuser->role) {
                    return $wp_user->updateByCwUser($wuser, $cuser);
                } else {
                    return $wuser;
                }
            }
        }
    }
}
