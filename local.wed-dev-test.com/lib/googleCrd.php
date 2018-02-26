<?php

class googleCrd
{
    /*ввиду того, что я разворачивал приложение локально при помощи опенсервера,
    эти учетные данные будут работать относительно пути 'http://local.wed-dev-test.com/'
    первый юрл находится в файле login.php, часть логики в файле base.php методе run();
    но все учетные данные - в одном месте, их легко изменить
    */

    private $client_id = '537416408921-glkmqv711fmabflsqm4jstl2nqsefvnp.apps.googleusercontent.com'; // Client ID
    private $client_secret = 'NpER0HLAs3ffSsLpB3nm4PR3'; // Client secret
    private $redirect_uri = 'http://local.wed-dev-test.com/';
    private $code = '';
    private $params = array();
    /**
     * googleCrd constructor.
     */
    public function __construct()
    {
        $this->params = array(
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
        );
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        $this->params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $code
        );
    }

    public function getUserInfo()
    {
        $url = 'https://accounts.google.com/o/oauth2/token';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($this->getParams())));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $tokenInfo = json_decode($result, true);

        if (isset($tokenInfo['access_token'])) {
            $params['access_token'] = $tokenInfo['access_token'];

            $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
            if (isset($userInfo['id'])) {
                $userInfo = $userInfo;
                $result = true;
            } else {
                $result = false;
            }
        }
        return ($result) ? $userInfo : '';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    } // Redirect URIs

}