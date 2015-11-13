<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'client' . EXT;

class User extends Client {

    function __construct() {
        parent::__construct();
        $this->load->model(array('user_model', 'sessions_captcha_model'));
        $this->load->library(array('form_validation', 'message'));
        $this->lang->load('form_validation', 'vi');
        header("Cache-Control: max-age=0");
    }

    function loadst() {
        $array_user = array();
        $array_user['id'] = '';
        $array_user['username'] = 'Khách';
        $array_user['fullname'] = '';
        $array_user['taikhoan'] = 0;
        $array_user['strlogin'] = '';
        if (!isset($_SESSION["user"])) {
            $array_user['strlogin'] = '<a class="login-icon" href="' . site_url() . 'dang-nhap.html">Đăng ký | Đăng nhập</a>';
        } else {
            $array_user['id'] = $_SESSION['user']['id'];
            $array_user['username'] = $_SESSION['user']['username'];
            $array_user['fullname'] = $_SESSION['user']['fullname'];

            $taikhoan = 0;
            $loto_online = $this->db->select("taikhoan")
                            ->from("xs_loto_online")
                            ->where('quay', 1)
                            ->where("userid", $_SESSION['user']['id'])
                            ->order_by('ngay', 'DESC')
                            ->get()->row();

            if ($loto_online)
                $taikhoan = $loto_online->taikhoan;

            $array_user['taikhoan'] = '<span id="balanceplace" class="' . ($taikhoan < 0 ? 'neg' : 'pos') . '">' . number_format($taikhoan, 0, ',', '.') . '</span>';

            $array_user['strlogin'] = '<div class="menuopener"><span><span class="arrow">' . $_SESSION["user"]['username'] . '</span></span></div>
            <div class="menudd" style="width:120px">
                <a href="' . site_url() . 'cap-nhat-thong-tin-ca-nhan.html">Thông tin chung</a>
                <a href="' . site_url() . 'loto-online.html">Tài khoản Lotto</a>
                <a href="' . site_url() . 'dang-xuat.html">Đăng xuất</a>
            </div>';
        }

        echo json_encode($array_user);
        die;
    }

    function login() {
        if (isset($_SESSION["user"])) {
            redirect(base_url() . "cap-nhat-thong-tin-ca-nhan.html");
        }

        $re = FALSE;
        $submit = array();

        $register = $this->input->post("register");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($register == 0) {
                $u = $this->input->post("username");
                $p = $this->input->post("password");
                $re_pass = (int) $this->input->post("re_pass");
//                $url = $this->input->post("url");
                $_user = $this->user_model->login($u, $p, $re_pass);

                $this->form_validation->set_rules('username', 'user hoặc email', 'required|callback__check_username_email');
                $this->form_validation->set_rules('password', 'mật khẩu', 'required');

                if ($this->form_validation->run() == true) {
                    if ($_user) {
//                        redirect(base_url());
                        echo "<script>window.parent.location.href='" . $_SESSION['redirect_login'] . "';</script>";
                        exit();
                    } else {
                        $this->form_validation->_field_data['username']['error'] = 'Sai user/email hoặc mật khẩu.';
                    }
                }
            } else {
                $fullname = $this->input->post('fullname');
                $r_username = $this->input->post('r_username');
                $r_password = $this->input->post('r_password');
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');

                $submit['fullname'] = $fullname;
                $submit['r_username'] = $r_username;
                $submit['email'] = $email;
                $submit['mobile'] = $mobile;

                $this->form_validation->set_message('required', 'Vui lòng nhập %s');
                $this->form_validation->set_message('alpha_numeric', '%s chỉ ở dạng số, ký tự không dấu, không bao gồm dấu cách và các ký tự đặc biệt');
                $this->form_validation->set_rules('r_username', 'tên đăng nhập', 'required|xss_clean|min_length[6]|alpha_numeric|callback__check_username');
                $this->form_validation->set_rules('r_password', 'mật khẩu', 'required|xss_clean|min_length[6]|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'xác nhận mật khẩu', 'required|xss_clean|min_length[6]');
                $this->form_validation->set_rules('email', 'email', 'required|xss_clean|valid_email|callback__check_email');
                $this->form_validation->set_rules('captcha', 'mã bảo mật', 'required|xss_clean|callback__check_captcha');

                if ($this->form_validation->run() == TRUE) {
                    if (trim($fullname) == '')
                        $fullname = $r_username;

                    $data = array(
                        'username' => $r_username,
                        'password' => md5($r_password),
                        'fullname' => $fullname,
                        'gender' => 0,
                        'email' => $email,
                        'mobile' => $mobile,
                        'active' => 'yes',
                        'created_date' => date('Y-m-d H:i:s'),
                        'group_id' => 4,
                    );

                    $this->db->trans_begin();
                    if ($member_id = $this->user_model->insert($data)) {
                        $re = TRUE;
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                } else {
                    
                }
            }
        }

        if ($re) {
            $this->data['msg'] = '<span class="success">Bạn đã đăng ký thành công tài khoản trên xoso.com.</span><meta http-equiv="refresh" content="10;url=' . $_SESSION['redirect_login'] . '" />';
        }

        $this->data["suc"] = $re;
        $this->data['submit'] = $submit;
        $this->data['tmpl'] = 'user/login';
        $this->load->view('column1', $this->data);
    }

	
	//cho app
	function login2() {
        if (isset($_SESSION["user"])) {
            redirect(base_url() . "cap-nhat-thong-tin-ca-nhan.html");
        }

        $re = FALSE;
        $submit = array();

        $register = $this->input->post("register");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($register == 0) {
                $u = $this->input->post("username");
                $p = $this->input->post("password");
                $re_pass = (int) $this->input->post("re_pass");
                $url2 = $this->input->post("url");
                $_user = $this->user_model->login($u, $p, $re_pass);

                $this->form_validation->set_rules('username', 'user hoặc email', 'required|callback__check_username_email');
                $this->form_validation->set_rules('password', 'mật khẩu', 'required');

                if ($this->form_validation->run() == true) {
                    if ($_user) {
//                        redirect(base_url());
                        echo "<script>window.parent.location.href='" . $url2 . "';</script>";
                        exit();
                    } else {
                        $this->form_validation->_field_data['username']['error'] = 'Sai user/email hoặc mật khẩu.';
                    }
                }
            } else {
                $fullname = $this->input->post('fullname');
                $r_username = $this->input->post('r_username');
                $r_password = $this->input->post('r_password');
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');

                $submit['fullname'] = $fullname;
                $submit['r_username'] = $r_username;
                $submit['email'] = $email;
                $submit['mobile'] = $mobile;

                $this->form_validation->set_message('required', 'Vui lòng nhập %s');
                $this->form_validation->set_message('alpha_numeric', '%s chỉ ở dạng số, ký tự không dấu, không bao gồm dấu cách và các ký tự đặc biệt');
                $this->form_validation->set_rules('r_username', 'tên đăng nhập', 'required|xss_clean|min_length[6]|alpha_numeric|callback__check_username');
                $this->form_validation->set_rules('r_password', 'mật khẩu', 'required|xss_clean|min_length[6]|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'xác nhận mật khẩu', 'required|xss_clean|min_length[6]');
                $this->form_validation->set_rules('email', 'email', 'required|xss_clean|valid_email|callback__check_email');
                $this->form_validation->set_rules('captcha', 'mã bảo mật', 'required|xss_clean|callback__check_captcha');

                if ($this->form_validation->run() == TRUE) {
                    if (trim($fullname) == '')
                        $fullname = $r_username;

                    $data = array(
                        'username' => $r_username,
                        'password' => md5($r_password),
                        'fullname' => $fullname,
                        'gender' => 0,
                        'email' => $email,
                        'mobile' => $mobile,
                        'active' => 'yes',
                        'created_date' => date('Y-m-d H:i:s'),
                        'group_id' => 4,
                    );

                    $this->db->trans_begin();
                    if ($member_id = $this->user_model->insert($data)) {
                        $re = TRUE;
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                } else {
                    
                }
            }
        }

        if ($re) {
            $this->data['msg'] = '<span class="success">Bạn đã đăng ký thành công tài khoản trên xoso.com.</span><meta http-equiv="refresh" content="10;url=http://www.xoso.com/chat-full-screen-app.html" />';
        }

        $this->data["suc"] = $re;
        $this->data['submit'] = $submit;
        $this->data['tmpl'] = 'user/login2';
        $this->load->view('column11', $this->data);
    }
	//end login2
	
    function _check_username_email($username = NULL) {
        if (!$this->user_model->get_by(array('username' => $username)) && !$this->user_model->get_by(array('email' => $username))) {
            $this->form_validation->set_message('_check_username_email', 'User hoặc email không tồn tại.');
            return false;
        }

        return true;
    }

    function logout() {
        $this->user_model->logout();

//        if (isset($_GET['url'])) {
//            $url = $_GET['url'];
//            echo "<script>window.parent.location.href='$url';</script>";
//            exit();
//        } else {
//            redirect(base_url());

        echo "<script>window.parent.location.href='" . $_SESSION['redirect_login'] . "';</script>";
        exit();
//        }
    }

    function update_info() {
        if (!isset($_SESSION["user"])) {
            redirect(base_url() . "dang-nhap.html");
        }

        $this->load->library('form_validation');
        $this->load->helper(array('string', 'mail'));
        $re = FALSE;
        $submit = array();

        $submit = $this->db->select()->from("users")->where(array("id" => $_SESSION["user"]["id"]))->get()->row_array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $this->input->post('fullname');
            $r_password = $this->input->post('r_password');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');

            $submit['fullname'] = $fullname;
            $submit['email'] = $email;
            $submit['mobile'] = $mobile;

            $this->form_validation->set_message('required', 'Vui lòng nhập %s');

            if ($r_password != "") {
                $this->form_validation->set_rules('r_password', 'mật khẩu', 'required|xss_clean|min_length[6]|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'xác nhận mật khẩu', 'required|xss_clean|min_length[6]');
            }
            $this->form_validation->set_rules('email', 'email', 'required|xss_clean|valid_email|callback__check_email');
            $this->form_validation->set_rules('mobile', 'số điện thoại', 'xss_clean|callback__check_mobile');
//            $this->form_validation->set_rules('captcha', 'mã bảo mật', 'required|xss_clean|callback__check_captcha');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'mobile' => $mobile,
                );

                if ($r_password != "") {
                    $data["password"] = md5($r_password);
                }

                $this->db->trans_begin();
                if ($this->user_model->update($_SESSION["user"]["id"], $data)) {
                    $_SESSION["user"]["fullname"] = $fullname;
                    $_SESSION["user"]["email"] = $email;
                    $_SESSION["user"]["mobile"] = $mobile;

                    $re = TRUE;
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        }

        if ($re) {
            $this->data['msg'] = '<br /><span class="success">Bạn đã cập nhật thành công thông tin tài khoản trên xoso.com.</span><meta http-equiv="refresh" content="10;url=' . $_SESSION['redirect_login'] . '" />';
        }

        $this->data["suc"] = $re;
        $this->data['submit'] = $submit;
        $this->data['tmpl'] = 'user/update_info';
        $this->load->view('default', $this->data);
    }

	
    function update_info2() {
        if (!isset($_SESSION["user"])) {
            redirect(base_url() . "dang-nhap.html");
        }

        $this->load->library('form_validation');
        $this->load->helper(array('string', 'mail'));
        $re = FALSE;
        $submit = array();

        $submit = $this->db->select()->from("users")->where(array("id" => $_SESSION["user"]["id"]))->get()->row_array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $this->input->post('fullname');
            $r_password = $this->input->post('r_password');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');

            $submit['fullname'] = $fullname;
            $submit['email'] = $email;
            $submit['mobile'] = $mobile;

            $this->form_validation->set_message('required', 'Vui lòng nhập %s');

            if ($r_password != "") {
                $this->form_validation->set_rules('r_password', 'mật khẩu', 'required|xss_clean|min_length[6]|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'xác nhận mật khẩu', 'required|xss_clean|min_length[6]');
            }
            $this->form_validation->set_rules('email', 'email', 'required|xss_clean|valid_email|callback__check_email');
            $this->form_validation->set_rules('mobile', 'số điện thoại', 'xss_clean|callback__check_mobile');
//            $this->form_validation->set_rules('captcha', 'mã bảo mật', 'required|xss_clean|callback__check_captcha');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'mobile' => $mobile,
                );

                if ($r_password != "") {
                    $data["password"] = md5($r_password);
                }

                $this->db->trans_begin();
                if ($this->user_model->update($_SESSION["user"]["id"], $data)) {
                    $_SESSION["user"]["fullname"] = $fullname;
                    $_SESSION["user"]["email"] = $email;
                    $_SESSION["user"]["mobile"] = $mobile;

                    $re = TRUE;
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        }

        if ($re) {
            $this->data['msg'] = '<br /><span class="success">Bạn đã cập nhật thành công thông tin tài khoản trên xoso.com.</span><meta http-equiv="refresh" content="10;url=' . $_SESSION['redirect_login'] . '" />';
        }

        $this->data["suc"] = $re;
        $this->data['submit'] = $submit;
        $this->data['tmpl'] = 'user/update_info2';
        $this->load->view('user/update_info2', $this->data);
    }

	
    function change_password() {
        die;
        $this->load->library(array('form_validation'));
        $suc = false;
        if (!isset($_SESSION['user'])) {
            redirect(base_url());
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $old_pass = $this->input->post("old_pass");
            $new_pass = $this->input->post("new_pass");
            $this->form_validation->set_rules('old_pass', 'Mật khẩu hiện tại', 'required|callback__check_current_pass');
            $this->form_validation->set_rules('new_pass', 'Mật khẩu mới', 'required|min_length[6]|matches[re_pass]');
            $this->form_validation->set_rules('re_pass', 'Xác nhận mật khẩu', 'required');

            if ($this->form_validation->run() == true) {
                if ($this->user_model->update($_SESSION["user"]["id"], array("password" => md5($new_pass)))) {
                    $this->data['msg'] = '<br /><p class="success">Mật khẩu của bạn đã được thay đổi thành công!</p><meta http-equiv="refresh" content="15;url=' . base_url() . '">';
                    $suc = true;
                }
            }
        }

        $this->data["suc"] = $suc;
        $this->data["tmpl"] = "user/change_pass";
        $this->load->view("client/default", $this->data);
    }

    function _check_current_pass($pass = NULL) {
        if (!$this->user_model->get_by(array("username" => $_SESSION['user']['username'], "password" => md5($pass)))) {
            $this->form_validation->set_message('_check_current_pass', 'Mật khẩu không chính xác.');
            return false;
        }
        return true;
    }

    function _check_username($email = NULL) {
        if ($this->user_model->get_by(array('username' => $email))) {
            $this->form_validation->set_message('_check_username', '%s ' . $email . ' đã tồn tại.');
            return false;
        }
        return true;
    }

    function _check_mobile($mobile = NULL) {
        if ($mobile != '') {
            if (isset($_SESSION["user"])) {
                $this->db->where('mobile <>', $_SESSION["user"]["mobile"]);
            }
            if ($this->user_model->get_by(array('mobile' => $mobile))) {
                $this->form_validation->set_message('_check_mobile', '%s ' . $mobile . ' đã tồn tại.');
                return false;
            }
        }
        return true;
    }

    function _check_email($email = NULL) {
        if (isset($_SESSION["user"])) {
            $this->db->where('email <>', $_SESSION["user"]["email"]);
        }
        if ($this->user_model->get_by(array('email' => $email))) {
            $this->form_validation->set_message('_check_email', '%s ' . $email . ' đã tồn tại.');
            return false;
        }
        return true;
    }

    function _check_non_existed_email($email = NULL) {
        if (!$this->user_model->get_by(array('email' => $email))) {
            $this->form_validation->set_message('_check_non_existed_email', '%s ' . $email . ' không tồn tại.');
            return false;
        }
        return true;
    }

    function _check_captcha($captcha) {
        $session_id = session_id();

        $sessions_captcha = $this->sessions_captcha_model->get_by(array('sessid' => $session_id));

//        if ($_SESSION['captcha'] != strtoupper($captcha)) {
        if (!isset($sessions_captcha->value)) {
            $this->form_validation->set_message('_check_captcha', 'Sai %s.');
            return false;
        }
        if (isset($sessions_captcha->value) && ($sessions_captcha->value != strtoupper($captcha))) {
            $this->form_validation->set_message('_check_captcha', 'Sai %s.');
            return false;
        }
        return true;
    }

    function openid($param) {
        header("Cache-Control: max-age=0");
//        error_reporting(-1);

        if ($param == 'google') {
            require_once(FCPATH . 'public/google/src/apiClient.php');
            require_once(FCPATH . 'public/google/src/contrib/apiOauth2Service.php');
            $client = new apiClient();
            $client->setApplicationName('Xoso.com');
            $client->setAccessType('online');
            $oauth2 = new apiOauth2Service($client);

            if (isset($_GET['code'])) {
                $client->authenticate();
                $_SESSION['token'] = $client->getAccessToken();
                $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
                header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
            }

            if (isset($_SESSION['token'])) {
                $client->setAccessToken($_SESSION['token']);
            }

            if ($client->getAccessToken()) {
                $user = $oauth2->userinfo->get();
                $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
                if (empty($email)) {
                    die('Đăng nhập thất bại vui lòng thử lại');
                }

                $params = array(
                    'email' => strtolower($email),
                    'taken_key' => $user['id'], //google id
                    'fullname' => $user['name'],
                    'gender' => $user['gender'] == 'male' ? 'Nam' : 'Nữ',
                    'openid' => 1//google
                );
                //kiem tra neu chua co user nao mang email nay thi tao moi user
                $this->openid_create_user($params);
                // The access token may have been updated lazily.
                $_SESSION['token'] = $client->getAccessToken();
                $this->openid_close();
            } else {
                $authUrl = $client->createAuthUrl();
            }
            header('Location: ' . $authUrl);
        } elseif ($param == 'facebook') {
            $app_id = "313237515438160";
            $app_secret = "5b42cde47aac75e09cd57cf5ebacb0fa";

            $my_url = base_url() . 'openid/facebook';

            $code = isset($_GET["code"]) ? $_GET["code"] : '';

            if (empty($code)) {
//                $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
                $scope = '&scope=email';
//                $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state=" . $_SESSION['state'] . $scope;
                $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state=1" . $scope;
                echo("<script> top.location.href='" . $dialog_url . "'</script>");
            }

//            if (isset($_GET['state']) && $_GET['state'] == $_SESSION['state']) {
            if (isset($_GET['state'])) {
                $token_url = "https://graph.facebook.com/oauth/access_token?"
                        . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                        . "&client_secret=" . $app_secret . "&code=" . $code;

                $response = $this->openIDExecCURL($token_url);
                if (!$response) {
                    echo '<h1>Đăng nhập thất bại vui lòng thử lại.</h1>';
                    die;
                }
                $params = null;
                parse_str($response, $params);

                $graph_url = "https://graph.facebook.com/me?access_token=" . $params['access_token'];

                $user = json_decode($this->openIDExecCURL($graph_url));
                $params = array(
                    'email' => $user->email,
                    'taken_key' => $user->id, //facebook id
                    'fullname' => $user->first_name . ' ' . $user->last_name,
                    'gender' => $user->gender == 'male' ? 'Nam' : 'Nữ',
                    'openid' => 2//facebook
                );
                if ($params['email'] == '' || $params['taken_key'] == '') {
                    echo '<h1>Đăng nhập thất bại vui lòng thử lại.</h1>';
                    die;
                }
                //kiem tra neu chua co user nao mang email nay thi tao moi user
                $this->openid_create_user($params);
                $this->openid_close();
            } else {
                echo("The state does not match. You may be a victim of CSRF.");
                die;
            }

            $this->openid_close();
        } elseif ($param == 'twitter') {
            $this->openid_close();
        } elseif ($param == 'yahoo') {
            $this->openid_close();
        }
        $this->openid_close();
    }

    function openid_create_user($params) {
        $uid = $this->user_model->get_by(array('email' => $params['email']));
        if (!$uid) {
            $password = $this->generate_password(10, 2);
            $real_pass = md5($password);
            $name = explode('@', $params['email']);

            $data = array(
                'username' => $name[0],
                'fullname' => $params['fullname'],
                'password' => $real_pass,
                'email' => $params['email'],
                'created_date' => date('Y-m-d H:i:s'),
                'active' => 'yes',
                'group_id' => 4,
                'openid' => $params['openid'],
                'taken_key' => $params['taken_key']
            );

            $uid = $this->user_model->insert($data);

            $this->openid_auto_login($uid);
        } else {
            $uid = $this->user_model->get_by(array('openid' => $params['openid'], 'taken_key' => $params['taken_key']));
            if ($uid) {
                $this->openid_auto_login($uid->id);
            } else {
                echo '<h1>Đăng nhập thất bại vui lòng thử lại.</h1>';
                die;
            }
        }
    }

    function openid_auto_login($mid) {
        if ($user = $this->user_model->get_by_id_to_array($mid)) {
            $_SESSION['user'] = $user;

            $query = "INSERT INTO `sessions` (`userid`, `sessid`, `created`) VALUES
                    (" . $user['id'] . ", '" . session_id() . "', " . time() . ");"
            ;
            $this->db->query($query);

            set_cookie('__user', $user["id"], time() + 7200); //20*60*60
        }
    }

    function openid_close() {
        echo '<script type="text/javascript">window.opener.location.replace(\'' . $_SESSION['redirect_login'] . '\');window.close();</script>';
        die;
    }

    function generate_password($length = 9, $strength = 0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        } elseif ($strength & 2) {
            $vowels .= "AEUY";
        } elseif ($strength & 4) {
            $consonants .= '23456789';
        } elseif ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    function openIDExecCURL($url) {
        $data = array();
        $server = 'xoso.com';
        $data = $this->execCURL($url);
        if ($data == FALSE) {
            $encode_url = urlencode($url);
            $encode_url = 'http://websitemeta.com/fb.php?openid=1&url=' . $encode_url;
            $data = $this->execCURL($encode_url);
            if ($data == FALSE) {
                $server = 'websitemeta.com';
            }
        }
        return $data;
    }

    function execCURL($url) {
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
