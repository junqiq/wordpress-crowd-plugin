<?php namespace CrowdLogin\service;

use CrowdLogin\repository\UserRepository as UserRepository;

use \WP_Error as WP_Error;
use \WP_User  as WP_User;

class UserService
{
    private $emsg = '';
    private $user_repo;

    public function __construct()
    {
        global $gcl_config;

        $this->e = new WP_Error();
        $this->user_repo = new UserRepository();

        if ($gcl_config->get('security_mode') === 'security_high') {
            remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
        }
    }

    /**
     * Authentication User Service
     *
     * @return WP_User or WP_Error
     * @since 0.2.0
     */
    public function authentication($user, string $username, string $password)
    {
        global $gcl_config;

        if (is_a($user, 'WP_User')) {
            return $user;
        }

        if (!$this->validateParams($username, $password)) {
            return $this->e;
        }

        $user = $this->user_repo->getWithAuth($username, $password);
        if ($user === false) {
            do_action('wp_login_failed', $username);
            return new WP_Error('invalid_username', $this->user_repo->emsg);
        } else {
            return $user;
        }
    }

    /**
     * Validation
     *   - presence of username
     *   - presence of password
     *
     * @return boolean
     * @since 0.2.0
     */
    private function validateParams(string $username, string $password)
    {
        if (empty($username) || empty($password)) {
            if (empty($username)) {
                $this->e->add('empty_username', __('<strong>ERROR</strong>: The username field is empty.'));
            }
            if (empty($password)) {
                $this->e->add('empty_password', __('<strong>ERROR</strong>: The password field is empty.'));
            }
            return false;
        }
        return true;
    }
}
