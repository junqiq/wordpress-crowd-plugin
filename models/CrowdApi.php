<?php namespace CrowdLogin\model;

class CrowdApi
{
    const MIME = 'application/json';
    const USER_AGENT = 'Httpful/0.2.19 (cURL/7.22.0 PHP/5.3.10-1ubuntu3.25 (Linux))';

    public $emsg = ''; //error message

    private $url = '';
    private $name = '';
    private $pass = '';

    /**
     * Set the Crowd Settings
     *
     * @since 0.2.0
     */
    public function __construct()
    {
        global $gcl_config;

        $this->url  = $gcl_config->get('crowd_url') . '/rest/usermanagement/1/';
        $this->name = $gcl_config->get('crowd_app_name');
        $this->pass = $gcl_config->get('crowd_app_password');
    }

    /**
     * Authenticate user and password
     *
     * @return array or false
     * @since 0.2.0
     */
    public function authentication(string $username, string $password)
    {
        $endpoint = $this->url . 'authentication?username=' . $username;
        try {

            $response = \Httpful\Request::post($endpoint)->mime(self::MIME)
                                                         ->addHeader('X-Atlassian-Token', 'no-check')
                                                         ->addHeader('User-Agent', self::USER_AGENT)
                                                         ->authenticateWith($this->name, $this->pass)
                                                         ->body('{"value":"' . $password . '"}')
                                                         ->send();

            if ($response->code === 200) {
                return json_decode($response->raw_body, true);
            } else {
                $this->emsg = $response->reason . ":" . $response->message;
                return false;
            }
        } catch (\Exception $ex) {
            $this->emsg = $ex->getMessage();
            return false;
        } catch (\Error $er) {
            $this->emsg = $er->getMessage();
            return false;
        }
    }

    /**
     * get user informations
     *
     * @return array or false
     * @since 0.2.0
     */
    public function user(string $username)
    {
        $endpoint = $this->url . 'user?username=' . $username;
        $response = \Httpful\Request::get($endpoint)->mime(self::MIME)
                                                    ->addHeader('X-Atlassian-Token', 'no-check')
                                                    ->addHeader('User-Agent', self::USER_AGENT)
                                                    ->authenticateWith($this->name, $this->pass)
                                                    ->send();
        if ($response->code == 200) {
            return json_decode($response->raw_body, true);
        } else {
            return false;
        }
    }

    /**
     * get groups the user joins
     *
     * @return array or false
     * @since 0.2.0
     */
    public function userGroup(string $username)
    {
        $endpoint = $this->url . 'user/group/direct?username=' . $username;
        $response = \Httpful\Request::get($endpoint)->mime(self::MIME)
                                                    ->addHeader('X-Atlassian-Token', 'no-check')
                                                    ->addHeader('User-Agent', self::USER_AGENT)
                                                    ->authenticateWith($this->name, $this->pass)
                                                    ->send();
        if ($response->code == 200) {
            return json_decode($response->raw_body, true);
        } else {
            return false;
        }
    }
}
