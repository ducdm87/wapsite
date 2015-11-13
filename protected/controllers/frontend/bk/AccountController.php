<?php

class AccountController extends FrontEndController {

    public $tablename = "{{users}}";
    public $table_group = "{{users_group}}";
    public $primary = "id";

    public function actionGoogle() {
        require_once ROOT_PATH . '/protected/openid/google/src/apiClient.php';
        require_once ROOT_PATH . '/protected/openid/google/src/contrib/apiOauth2Service.php';
        $client = new apiClient();
        $client->setApplicationName(Yii::app()->name);
        $oauth2 = new apiOauth2Service($client);
        if (isset($_GET['code'])) {
            $client->authenticate();
            Yii::app()->session['token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset(Yii::app()->session['token'])) {
            $client->setAccessToken(Yii::app()->session['token']);
        }

        if ($client->getAccessToken()) {
            $user = $oauth2->userinfo->get();
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $params = array(
                'email' => strtolower($email),
                //'avatar' => filter_var($user['picture'], FILTER_VALIDATE_URL),
                'taken_key' => $user['id'], //google id
                'first_name' => $user['given_name'],
                'last_name' => $user['family_name'],
                //'gender' => $user['gender'] == 'male' ? 'Nam' : 'Nữ',
                'suppliers' => 'google'
            );
            //kiem tra neu chua co user nao mang email nay thi tao moi user
            $this->createUser($params);
            // The access token may have been updated lazily.
//            Yii::app()->session['token'] = $client->getAccessToken();
//            cm_openid_close();
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
        }        
    }

    public function actionYahoo() {
        Yii::app()->session['repath'] = Request::getVar('repath','');
        require_once ROOT_PATH . '/protected/openid/yahoo/openid.php';
        $callback_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $openid = new LightOpenID($callback_url);
        if (!$openid->mode) {
            $openid->identity = 'https://me.yahoo.com';
            $openid->required = array('contact/email');
            $openid->optional = array('namePerson/first', 'namePerson/last', 'namePerson', 'namePerson/friendly', 'person/gender');
            header('Location: ' . $openid->authUrl());
        } elseif ($openid->mode == 'cancel') {
            echo 'Bạn đã bỏ qua không đăng nhập nữa';
        } else {
            if ($openid->validate()) {
                $identity = explode('/', $openid->identity);
                $yahooId = array_pop($identity);
                $attributes = $openid->getAttributes();
                $params = array(
                    'email' => strtolower($attributes['contact/email']),
                    //'avatar' => '',
                    'taken_key' => $yahooId, //google id
                    'first_name' => $attributes['namePerson'],
                    'last_name' => $attributes['namePerson/friendly'],
                    //'gender' => $attributes['person/gender'] == 'M' ? 'Nam' : 'Nữ',
                    'suppliers' => 'yahoo'
                );
                //kiem tra neu chua co user nao mang email nay thi tao moi user
                $this->createUser($params);
            } else {
                echo 'Có lỗi xẩy ra trong quá trình đăng nhập với Yahoo!, vui lòng thử lại sau';
            }
        }
    }

    public function actionFacebook() {
        $params = array(
            'app_id' => '1507512426140780',
            'secret_id' => 'ddb7793f8d2b131ca69327daf93db2ab',
            'site_url' => 'http://resumebuilder.com/account/facebook'
        );

        Yii::app()->session['repath'] = Request::getVar('repath','');
        $app_id = $params['app_id'];
        $app_secret = $params['secret_id'];
        $my_url = $params['site_url'];

        $code = Request::getVar('code','');

        if (empty($code)) {
            $state = Yii::app()->session['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
            $scope = '&scope=email';
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state=" . $state . $scope;
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
        }

        if (isset(Yii::app()->session['state']) AND Request::getVar('state','') == Yii::app()->session['state']) {
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&client_secret=" . $app_secret . "&code=" . $code;

            $response = $this->execCURL($token_url);
            if (!$response) {
                echo '<h1>Đăng nhập thất bại vui lòng thử lại.</h1>';
                die;
            }
            $params = null;
            parse_str($response, $params);

            $graph_url = "https://graph.facebook.com/me?access_token="
                    . $params['access_token'];

            $user = json_decode($this->execCURL($graph_url));
            $params = array(
                'email' => $user->email,
                //'avatar' => 'https://graph.facebook.com/' . $user->id . '/picture?type=square',
                'taken_key' => $user->id, //facebook id
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                //'gender' => $user->gender == 'male' ? 'Nam' : 'Nữ',
                'suppliers' => 'facebook'
            );
            if ($params['email'] == '' | $params['taken_key'] == '') {
                echo '<h1>Đăng nhập thất bại vui lòng thử lại.</h1>';
                die;
            }
            //kiem tra neu chua co user nao mang email nay thi tao moi user
            $this->createUser($params);
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }

    public function actionTwitterRedirect() {
        require_once getcwd() . '/protected/openid/twitter/twitteroauth.php';
        require_once getcwd() . '/protected/openid/twitter/config.php';

        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

        /* Save temporary credentials to session. */
        Yii::app()->session['oauth_token'] = $token = $request_token['oauth_token'];
        Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
            case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url = $connection->getAuthorizeURL($token);
                header('Location: ' . $url);
                break;
            default:
                /* Show notification if something went wrong. */
                echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    public function actionTwitterCallback() {
        require_once getcwd() . '/protected/openid/twitter/twitteroauth.php';
        require_once getcwd() . '/protected/openid/twitter/config.php';
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
            Yii::app()->session['oauth_status'] = 'oldtoken';
            session_destroy();
            header('Location:/index.php');
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        Yii::app()->session['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
//unset(Yii::app()->session['oauth_token']);
//unset(Yii::app()->session['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            Yii::app()->session['status'] = 'verified';
            header('Location:/account/twitter');
        } else {
            /* Save HTTP status for error dialog on connnect page. */
            session_destroy();
            header('Location:/index.php');
        }
    }

    public function actionTwitter() {
        require_once getcwd() . '/protected/openid/twitter/twitteroauth.php';
        require_once getcwd() . '/protected/openid/twitter/config.php';
        /* If access tokens are not available redirect to connect page. */
        if (empty(Yii::app()->session['access_token']) || empty(Yii::app()->session['access_token']['oauth_token']) || empty(Yii::app()->session['access_token']['oauth_token_secret'])) {
            session_destroy();
            if (CONSUMER_KEY === '' || CONSUMER_SECRET === '') {
                echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
                exit;
            }
            $this->redirect(array('account/twitterredirect'));
        }

        /* Get user access tokens out of the session. */
        $access_token = Yii::app()->session['access_token'];

        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        /* If method is set change API call made. Test is called by default. */
        $content = $connection->get('account/verify_credentials');

        $params = array(
            'email' => $content->screen_name,
            'avatar' => $content->profile_image_url,
            'taken_key' => $content->id, //facebook id
            'first_name' => '',
            'last_name' => $content->name,
            'gender' => 'Nam',
            'suppliers' => 'twitter'
        );
//        echo '<pre>' . print_r($content, true) . '</pre>';
//        die;
        $this->createUser($params);
    }

    private function createUser($params = array()) {
        if (empty($params)) {
            return;
        }
        $tablename = "{{users}}";
        $tbl_openid = "{{users_openid}}";
        global $mainframe;
        $db = Yii::app()->dbuser;

        $query = "SELECT * FROM  " . $tablename . " WHERE email=:email";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':email', $params['email']);
        if (!$result = $query_command->queryRow()) {
            $name = preg_replace("/\@.*$/ism", '', $params['email']);
            $query = "INSERT INTO " . $tablename .
                    " SET first_name=:first_name, email =:email "
                    . ",verify = 1, status = 1, register_time = " . mktime();
            $query_command = $db->createCommand($query);
            $query_command->bindParam(':first_name', $name);
            $query_command->bindParam(':email', $params['email']);
            $return = $query_command->execute();
            $userID = $db->lastInsertID;

            $query = "SELECT * FROM  " . $tablename . " WHERE id= $userID";
            $query_command = $db->createCommand($query);

            $result = $query_command->queryRow();
        }
        $query = "SELECT * FROM  " . $tbl_openid . " WHERE userlogin=:email AND suppliers=:suppliers AND taken_key=:taken_key";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':email', $params['email']);
        $query_command->bindParam(':suppliers', $params["suppliers"]);
        $query_command->bindParam(':taken_key', $params["taken_key"]);
        if (!$result_open = $query_command->queryRow()) {
            $query = "INSERT INTO " . $tbl_openid .
                    " SET suppliers=:suppliers, userlogin=:email, userid=:userid "
                    . ",taken_key =:taken_key, timeaccess = " . mktime();
            $query_command = $db->createCommand($query);
            $query_command->bindParam(':suppliers', ($params['suppliers']));
            $query_command->bindParam(':email', $params['email']);
            $query_command->bindParam(':userid', $result['id']);
            $query_command->bindParam(':taken_key', $params['taken_key']);
        } else {
            $query = "UPDATE " . $tbl_openid . " SET timeaccess = " . mktime() ." WHERE id = " . $result_open['id'];
            $query_command = $db->createCommand($query);
        }
        $query_command->execute();
        
        
        $session_id = session_id();        
        $result['suppliers'] = $params["suppliers"];
        $timeout = isset(Yii::app()->params->timeout)?Yii::app()->params->timeout:15;
        $duration = time() + $timeout*60; // 365 days        
        $cookie = new CHttpCookie(session_name(), session_id(), array("expire" => $duration));
        Yii::app()->getRequest()->getCookies()->add($cookie->name, $cookie);
        Yii::app()->session['userfront'] = $result;
        Yii::app()->user->login(new UserIdentity('', ''),$duration);
        $mainframe->set("user", $result);       
        $this->afterLogin($session_id, session_id());
        echo '<script type="text/javascript">window.close();</script>';
    }

    private function createUser1($params = array()) {
        if (empty($params)) {
            return;
        }
        //lam rieng cho truong hop nguoi dung login voi twitter
        if ($params['suppliers'] == 'twitter') {
            $condition = new CDbCriteria();
            $condition->condition = 'suppliers = :suppliers AND taken_key = :taken_key AND userlogin = :userlogin';
            $condition->params = array(
                ':suppliers' => $params['suppliers'],
                ':taken_key' => $params['taken_key'],
                ':userlogin' => $params['email']
            );
            $condition->limit = 1;
            $openId = UserOpenID::model()->find($condition);

            if (empty($openId)) {
                /*
                 * neu lan dau dang nhap
                 * tao moi openid voi twitter
                 */
                Yii::app()->session['openid'] = $params;
                $url = $this->createUrl('account/register', array('info' => base64_encode($params['email'])));
                echo '<script type="text/javascript">opener.window.location = "' . $url . '";window.close();</script>';
            } else {
                $user = User::model()->findByPk($openId->userid);
                Yii::app()->session['user'] = $user->attributes;
                echo '<script type="text/javascript">window.close();</script>';
            }
            exit();
        }
        /*
         * kiem tra da co OpenId trong he thong hay chua
         * - Neu chua co: tao moi openid va account tuong ung
         * - Neu co roi thi lay thong tin nguoi dung voi openid tuong ung dua vao session ...         
         */
        $uid = 0;

        $condition = new CDbCriteria();
        $condition->condition = 'email = :email';
        $condition->params = array(':email' => $params['email']);
        $userInfo = User::model()->find($condition);

        if (!empty($userInfo)) {
            $uid = $userInfo->id;
            $condition = new CDbCriteria();
            $condition->condition = 'suppliers = :suppliers AND taken_key = :taken_key AND userlogin = :userlogin';
            $condition->params = array(
                ':suppliers' => $params['suppliers'],
                ':taken_key' => $params['taken_key'],
                ':userlogin' => $params['email']
            );
            $condition->limit = 1;
            $openId = UserOpenID::model()->find($condition);

            if (empty($openId)) {
                //tao openid add cho account tuong ung
                Yii::app()->session['user'] = $new_user->attributes;
                $new_openId = new UserOpenID();
                $new_openId->suppliers = $params['suppliers'];
                $new_openId->userid = $uid;
                $new_openId->userlogin = $params['email'];
                $new_openId->taken_key = $params['taken_key'];
                $new_openId->timeaccess = time();
                $new_openId->user_ip = ip_address();
                $new_openId->save();
            } else {
                $openId->timeaccess = time();
                $openId->save();
            }
            //dua thong tin nguoi dung vao session
            Yii::app()->session['user'] = $userInfo->attributes;
        } else {
            $condition = new CDbCriteria();
            $condition->condition = 'suppliers = :suppliers AND taken_key = :taken_key AND userlogin = :userlogin';
            $condition->params = array(
                ':suppliers' => $params['suppliers'],
                ':taken_key' => $params['taken_key'],
                ':userlogin' => $params['email']
            );
            $condition->limit = 1;
            $openId = UserOpenID::model()->find($condition);

            if (empty($openId)) {
                //tao moi account voi thong tin openid lay duoc
                $new_user = new User();
                $new_user->email = $params['email'];
                $new_user->register_time = time();
                $new_user->first_name = $params['first_name'];
                $new_user->last_name = $params['last_name'];
                if ($new_user->save()) {
                    $uid = $new_user->id;
                    //dua thong tin nguoi dung vao session
                    Yii::app()->session['user'] = $new_user->attributes;
                    $new_openId = new UserOpenID();
                    $new_openId->suppliers = $params['suppliers'];
                    $new_openId->userid = $uid;
                    $new_openId->userlogin = $params['email'];
                    $new_openId->taken_key = $params['taken_key'];
                    $new_openId->timeaccess = time();
                    $new_openId->user_ip = ip_address();
                    $new_openId->save();
                }
            }
        }
        echo '<script type="text/javascript">window.close();</script>';
    }

    private function execCURL($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1');
        return curl_exec($ch);
    }

}
