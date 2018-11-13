<?php namespace CrowdLogin\application;

// use global $wp_roles

class CrowdLoginConfig
{
    public static $config = [];
    private $names = [
        'crowd_url',
        'crowd_app_name',
        'crowd_app_password',
        'crowd_security_mode',
        'crowd_login_mode'
    ];

    public function __construct()
    {
        foreach ($this->names as $k => $name) {
            $this->config[$name] = get_option($name);
        }
    }

    /**
     * Set CrowdLogin configuration.
     *
     * @since 0.2.0
     */
    public function set($name, $value)
    {
        $this->config[$name] = $value;
        update_option($name, $value);
    }

    /**
     * Get CrowdLogin configuration.
     *
     * @since 0.2.0
     */
    public function get($name)
    {
        return $this->config[$name];
    }

    /**
     * Activate CrowdLogin configurations.
     *
     * @since 0.2.0
     */
    public function init()
    {
        if ($this->get('crowd_url')) {
            return;
        }
        $this->set('crowd_url', 'https://crowd.mydomain.local:8443/crowd');
        $this->set('crowd_app_name', 'crowdlogin');
        $this->set('crowd_app_password', 'crowdpassword');
        $this->set('crowd_security_mode', 'security_low');
        $this->set('crowd_login_mode', 'mode_create');
    }

    /**
     * Get all roles in Wordpress;
     *
     * @return array
     * @since 0.2.0
     */
    public function allRoles()
    {
        global $wp_roles;
        return array_keys($wp_roles->roles);
    }
}
