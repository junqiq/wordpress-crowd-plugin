<?php namespace CrowdLogin\application;

require_once(CROWD_LOGIN__PLUGIN_DIR . 'service/UserService.php');

// use CrowdLogin\service\UserService as UserService;
use CrowdLogin\service\UserService;
use CrowdLogin\model\CwUser;

// use global $gcl_config

class CrowdLoginAdminApplication
{
    private $test_result = '';

    /**
     * Constructor of the CrowdLoginAdminApplication.
     *
     * @since 0.2.0
     */
    public function init()
    {
        global $gcl_config;

        // add pages
        $this->loadTextDomain();

        // add actions
        add_action('admin_menu', array($this, 'adminMenu'));

        // add filters
        add_filter('authenticate', array(new UserService(), 'authentication'), 1, 3);
    }

    /**
     * Settings of Admin Menu.
     *
     * @since 0.2.0
     */
    public function adminMenu()
    {
        add_options_page(
            __('Crowd Login', 'crowd-login'),
            __('Crowd Login', 'crowd-login'),
            10,
            'crowd-login',
            array($this, 'renderAction')
        );
    }

    /**
     * Load plugin textdomain.
     *
     * @since 0.2.0
     */
    public function loadTextDomain()
    {
        load_plugin_textdomain('crowd-login', false, 'crowd-login/languages');
    }

    /**
     * Render the admin page.
     *
     * @since 0.2.0
     */
    public function renderAction()
    {
        switch ($_POST['stage']) {
            case 'process':
                $this->updateConfig();
                break;
            case 'test':
                $this->authenticateTest();
                break;
        }
        $this->renderAdmin();
    }

    /**
     * Update configurations.
     *
     * @since 0.2.0
     */
    private function updateConfig()
    {
        global $gcl_config;
        //If admin options updated (uses hidden field)
        $gcl_config->set('crowd_url', $_POST['crowd_url']);
        $gcl_config->set('crowd_app_name', $_POST['crowd_app_name']);
        $gcl_config->set('crowd_app_password', $_POST['crowd_app_password']);
        $gcl_config->set('crowd_security_mode', $_POST['crowd_security_mode']);
        $gcl_config->set('crowd_login_mode', $_POST['crowd_login_mode']);
    }

    /**
     * Render the admin page.
     *
     * @since 0.2.0
     */
    private function renderAdmin()
    {
        global $gcl_config;

        $cw_url           = $gcl_config->get('crowd_url');
        $cw_app_name      = $gcl_config->get('crowd_app_name');
        $cw_app_password  = $gcl_config->get('crowd_app_password');
        $cw_security_mode = $gcl_config->get('crowd_security_mode');
        $cw_login_mode    = $gcl_config->get('crowd_login_mode');

        $cw_logmode_create_check = $gcl_config->get('crowd_login_mode') != 'mode_manual' ? 'checked' : '';
        $cw_logmode_manual_check = $gcl_config->get('crowd_login_mode') == 'mode_manual' ? 'checked' : '';
        $cw_secmode_low_check    = $gcl_config->get('crowd_security_mode') != 'security_high' ? 'checked' : '';
        $cw_secmode_high_check   = $gcl_config->get('crowd_security_mode') == 'security_high' ? 'checked' : '';

        $test_comment = $this->$test_result;

        include(CROWD_LOGIN__PLUGIN_DIR . 'view/CrowdLoginAdminView.php');
    }


    /**
     * Activate CrowdVars.
     *
     * @since 0.2.0
     */
    private function authenticateTest()
    {
        $cuser = new CwUser();
        $tuser = $cuser->authentication($_POST['test_username'], $_POST['test_password']);
        if ($tuser == false) {
            $this->$test_result = __('Failure. Your settings do not seem to work yet or the credentials are either wrong or have insufficient group membership.', 'crowd-login');
        } else {
            $translations = get_translations_for_domain('default');
            $translated_role = $translations->translate(ucwords($tuser->role), 'User role');
            $this->$test_result = sprintf(__('Congratulations! The test succeeded. The Role of this account is "%s" .', 'crowd-login'), $translated_role);
        }
    }
}
