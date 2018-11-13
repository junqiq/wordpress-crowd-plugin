<?php namespace CrowdLogin\model;

use CrowdLogin\model\CrowdApi as CrowdApi;

class CwUser
{
    public $emsg = ''; //error message

    public $username;
    public $display_name;
    public $email;
    public $first_name;
    public $last_name;
    public $role;

    private $api;

    public function __construct()
    {
        $this->api = new CrowdApi();
    }

    /**
     * Authenticate with username and password
     *
     * @return CwUser or false;
     * @since 0.2.0
     */
    public function authentication($username, $password)
    {
        $user = $this->api->authentication($username, $password);
        if ($user) {
            $groups = $this->api->userGroup($username);
            $role = $this->toRoleFromGroup($groups["groups"]);
            if ($role === false) {
                $this->emsg = __('The user have no group for this crowd-app.', 'crowd-login');
                return false;
            } else {
                $this->username = $username;
                $this->display_name = $user["display-name"];
                $this->email = $user["email"];
                $this->first_name = $user["first-name"];
                $this->last_name = $user["last-name"];
                $this->role = $role;
                return $this;
            }
        } else {
            $this->emsg = $this->api->emsg;
            return false;
        }
    }

    /**
     * Ensure wp_role from the group-name of crowd-user
     *
     * @return CwUser or false;
     * @since 0.2.0
     */
    private function toRoleFromGroup($groups)
    {
        $roles = $this->rolesFromGroup($groups);
        return $this->ensureRole($roles);
    }

    /**
     * Select one wp_role from some roles
     *
     * @return string or false;
     * @since 0.2.0
     */
    private function ensureRole($roles)
    {
        $roles = array_filter($roles, function ($group) {
            global $gcl_config;

            if ($group === false) {
                return false;
            } else {
                return in_array($group, $gcl_config->allRoles());
            }
        });
        return current($roles);
    }

    /**
     * Select roles from the group-name of crowd-user
     *
     * @return array or false;
     * @since 0.2.0
     */
    private function rolesFromGroup($groups) {
        return array_map(function ($group) {
            global $gcl_config;
            $app_name = $gcl_config->get('crowd_app_name');
            if (strpos($group["name"], $app_name) === false) {
                return false;
            } else {
                return preg_replace("/^$app_name-/", "", $group["name"]);
            }
        }, $groups);
    }
}
