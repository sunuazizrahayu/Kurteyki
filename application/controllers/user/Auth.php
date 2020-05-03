<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends My_Site{

	public $redirect_login = 'auth';
	public $redirect_register = 'auth/register';	
	public $redirect_dashboard_user = 'user/courses';		

	public $redirect_dashboard_instructor = 'app/lms_courses';
	public $redirect_dashboard_app = 'app/dashboard';	

	public function __construct(){
		parent::__construct();

		$this->_Language->load();
		
		$this->load->library('form_validation');

		$this->load->model('user/M_Auth');
	}

	public function index()
	{

		// if ($this->session->userdata('user')) {
		// 	$this->M_Auth->check('exist','user','user/profile');
		// }elseif ($this->session->userdata('status')) {
		// 	$this->M_Auth->check('not_exist', 'status', 'auth');
		// }

		$this->session->set_userdata('csrf_code', substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32));

		$site = $this->site;

		$data = array(
			'title' => $this->lang->line('login').' '.$site['title'],
			'classbody' => 'o-page--center',
			'site' => $site
			);

		$this->load->view('user/auth/login',$data);
	}

	public function process_login(){
		
		$login = $this->M_Auth->login();

		if (!empty($this->input->post('redirect'))) {

			$redirect_url = $this->input->post('redirect');
			$redirect_status = false;

			if(filter_var($redirect_url, FILTER_VALIDATE_URL)) {

				$redirect_url = parse_url($redirect_url);
				$myurl = parse_url(base_url());

				if ($redirect_url['host'] == $myurl['host']) {
					$redirect_url = $this->input->post('redirect');
					$redirect_status = true;
				}
			}

			if ($redirect_status) {
				$redirect = '?'.http_build_query(['redirect' => $redirect_url]);
				$this->redirect_login = $this->redirect_login.$redirect;
				$this->redirect_dashboard = urldecode($redirect_url);
			}else {
				$this->redirect_dashboard = base_url($this->redirect_dashboard);
			}
		}else{
			$this->redirect_dashboard = base_url($this->redirect_dashboard);
		}

		if ($login == 'invalid') {

			$this->session->set_flashdata([
				'message' => true,
				'message_type' => 'warning',
				'message_text' => $this->lang->line('invalid_csrf'),
				]);

			redirect(base_url($this->redirect_login));

		}elseif ($login == 'success_user') {

			redirect($this->redirect_dashboard_user);

		}elseif ($login == 'success_instructor') {

			redirect($this->redirect_dashboard_instructor);

		}elseif ($login == 'success_app') {

			redirect($this->redirect_dashboard_app);

		}elseif ($login == 'not_exist') {

			$this->session->set_flashdata([
				'message' => true,
				'message_type' => 'danger',
				'message_text' => $this->lang->line('failed_login'),
				]);

			redirect(base_url($this->redirect_login));
		}

	}

	public function register(){

		$this->M_Auth->check('exist','user','user/profile');

		$this->M_Auth->set_validation_register();

		$googlecaptcha = $this->M_Auth->googlecaptcha($this->site);

		if($this->form_validation->run() != false AND $googlecaptcha != false){

			$register = $this->M_Auth->register();

			if ($register == 'invalid') {

				$this->session->set_flashdata([
					'message' => true,
					'message_type' => 'warning',
					'message_text' => $this->lang->line('invalid_csrf'),
					]);

				redirect(base_url($this->redirect_register));
			}elseif ($register == 'success') {

				$this->session->set_flashdata([
					'message' => true,
					'message_type' => 'success',
					'message_text' => $this->lang->line('success_register'),
					]);

				redirect(base_url($this->redirect_login));

			}else{

				$this->session->set_flashdata([
					'message' => true,
					'message_type' => 'warning',
					'message_text' => $this->lang->line('failed_create'),
					]);

				redirect(base_url($this->redirect_register));
			}

		}else{

			$this->session->set_userdata('csrf_code', substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32));

			$site = $this->site;

			$data = array(
				'title' => $this->lang->line('register').' '.$site['title'],
				'classbody' => 'o-page--center',
				'site' => $site
				);

			$this->load->view('user/auth/register',$data);
		}		
	}

	public function auth_facebook(){

		$settings['facebook_app_id']                = '2035153033287427';
		$settings['facebook_app_secret']            = 'ea196826decb02b3a566c113b9ceef26';
		$settings['facebook_login_redirect_url']    = 'auth/facebook';
		$settings['facebook_logout_redirect_url']   = 'auth/logout';
		$settings['facebook_login_type']            = 'web';
		$settings['facebook_permissions']           = array('email');
		$settings['facebook_graph_version']         = 'v3.2';
		$settings['facebook_auth_on_load']          = TRUE;

		$this->load->library('facebook', $settings);

		if ($this->facebook->is_authenticated()) {

			$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,picture.width(100).height(100),email');

			/**
			 * Remove access_token
			 */
			$this->facebook->destroy_session();

			/**
			 * Checking Email if exist update and set session
			 */
			$data_login = [
			'email' => $userProfile['email'],
			'status' => 'Active'
			];
			if ($this->M_Auth->LoginSocialMedia($data_login)) {
				redirect($this->redirect_dashboard_user);
			}else{	

				/**
				 * Save Image
				 */
				$url = $userProfile['picture']['data']['url'];
				$photoname = $userProfile['id'].date('-YmdHis').'.jpg';  
				file_put_contents('storage/uploads/user/photo/'.$photoname, file_get_contents($url)); 

				$data_register = [
				'username' => $userProfile['first_name'].' '.$userProfile['last_name'],
				'password' => '',  
				'email' => $userProfile['email'],                      
				'no_handphone' => '',
				'photo' => $photoname,				
				'grade' => 'User',
				'created' => date('Y:m:d H:i:s'),
				'last_login' => date('Y:m:d H:i:s'),			
				'status' => 'Active',
				];

				/**
				 * Insert to database
				 */
				if ($this->M_Auth->RegisterSocialMedia($data_register)) {
					redirect($this->redirect_dashboard_user);
				}
			}


		}else{			
			redirect($this->facebook->login_url());
		}
	}

	public function auth_google(){

		$settings['client_id']        = '149457348626-hl17uddbuhjup4mfhtdltbkln7vej215.apps.googleusercontent.com';
		$settings['client_secret']    = 'JJbM0ETn_tdtPpKRGDpr6Hbi';
		$settings['redirect_uri']     = base_url('auth/google');
		$settings['application_name'] = 'Kurteyki';
		$settings['api_key']          = '';
		$settings['scopes']           = array();

		$this->load->library('google', $settings);

		if(isset($_GET['code'])){ 

            // Authenticate user with google 
			if($this->google->getAuthenticate()){ 

                /**
                 * Get user info from google
                 */
                $userProfile = $this->google->getUserInfo(); 

				/**
				 * Reset OAuth access token 
				 */
				$this->google->revokeToken(); 

				/**
				 * Checking Email if exist update and set session
				 */				
				$data_login = [
				'email' => $userProfile['email'],
				'status' => 'Active'
				];

				if ($this->M_Auth->LoginSocialMedia($data_login)) {
					redirect($this->redirect_dashboard_user);
				}else{	

					/**
					 * Save Image
					 */
					$url = $userProfile['picture'];
					$photoname = $userProfile['id'].date('-YmdHis').'.jpg';  
					file_put_contents('storage/uploads/user/photo/'.$photoname, file_get_contents($url)); 

					$data_register = [
					'username' => $userProfile['name'],
					'password' => '',  
					'email' => $userProfile['email'],                      
					'no_handphone' => '',
					'photo' => $photoname,				
					'grade' => 'User',
					'created' => date('Y:m:d H:i:s'),
					'last_login' => date('Y:m:d H:i:s'),			
					'status' => 'Active',
					];

					/**
					 * Insert to database
					 */
					if ($this->M_Auth->RegisterSocialMedia($data_register)) {
						redirect($this->redirect_dashboard_user);
					}
				}


			}

		}else{			
			redirect($this->google->loginURL()); 
		}

	}

	public function process_logout(){

		$logout = $this->M_Auth->logout();

		if ($logout == 'success') {
			redirect(base_url('auth'));
		}
	}

}