<?php
/*
Plugin Name: Crowd Login
Plugin URI:
Description:  Authenticates Wordpress usernames against Atlassian Crowd.
Version: 0.2.0
Author: Jun Matsushita
Old-Author: Andrew Teixeira
Old-Plugin URI: https://github.com/broadinstitute/wordpress-crowd-plugin
*/
define('CROWD_LOGIN_VERSION', '0.2');
define('CROWD_LOGIN__WP_VERSION', '>= 4.9.4');
define('CROWD_LOGIN__PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(CROWD_LOGIN__PLUGIN_DIR . 'httpful.phar');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'application/CrowdLoginAdminApplication.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'application/CrowdLoginConfig.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'models/CrowdApi.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'models/CwUser.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'models/WpUser.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'repository/UserRepository.php');
require_once(CROWD_LOGIN__PLUGIN_DIR . 'service/UserService.php');

global $gcl_config;
$gcl_config = new CrowdLogin\application\CrowdLoginConfig();
register_activation_hook(__FILE__, array($gcl_config, 'init'));

add_action('init', array(new CrowdLogin\application\CrowdLoginAdminApplication(), "init"));
