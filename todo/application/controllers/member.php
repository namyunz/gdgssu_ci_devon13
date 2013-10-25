<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
	 * 사용자를 관리한다.
	 */
	class Member extends CI_Controller
	{
		/* 
		 * 기본 생성자
		 */
		function __construct()
		{
			parent::__construct();
			
			/* 사용할 Model 호출 */
			$this->load->model('member_model');
			/* 필요한 라이브러리를 불러온다. */
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('alert');
		}
		
		/*
		 * 이 클래스를 호출하면 기본적으로 index 함수가 호출된다. 이 함수에서는 로그인 화면을 출력한다.
		 */
		public function index()
		{
			/* 로그인되지 않은 경우 */
			if(@$this->session->userdata('logged_in')==FALSE)
			{
				if(!file_exists('application/views/signin.php'))
				{
					show_404();
				}
				
				/* 폼 검증 라이브러리 호출 */
				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
				
				/* 폼 검증 규칙을 설정한다. */
				$this->form_validation->set_rules('email','email','required|valid_email');
				$this->form_validation->set_rules('password','password','required|alpha_numeric|md5');
				
				/* 폼 검증에 실패한 경우 */
				if ($this->form_validation->run() == FALSE)
	            {
					$data['title']="TODO";
					$this->load->view('templates/header',$data);
		            $this->load->view('signin');
		            $this->load->view('templates/footer');
	            }
	            /* 폼 검증에 성공했다면 로그인을 시도한다. */
	            else
	            {
		            $email=$this->input->post('email',TRUE);
		            $password=$this->input->post('password',TRUE);

		            /* Model의 로그인관련 함수 호출 */
		            $result=$this->member_model->authorize($email,$password);

		            if($result!=FALSE)
		            {
		            	/* 로그인이 성공했다면 세션을 생성한다. */
			            $new_session=array('member_id'=>$result['member_id'],
			            				   'email'=>$result['email_address'],
			            				   'regdate'=>$result['regdate'],
			            				   'logged_in'=>TRUE);
			            
			            $this->session->set_userdata($new_session);
			            
			            redirect('/lists/view/'.$result['member_id'],'refresh');
		            }
		            else
		            {
		            	alert('The combination you entered could not be found.',base_url());
		            }
	            }
			}
			/* 로그인된 경우에는 자신의 할 일 목록을 보여준다. */
			else
			{
				redirect('/lists/view/'.$this->session->userdata('member_id'),'refresh');
			}
		}

		/*
		 * 사용자의 세션을 제거한다.
		 */
		public function signout()
		{
			$this->session->sess_destroy();

			redirect(base_url(),'refresh');
		}
	}