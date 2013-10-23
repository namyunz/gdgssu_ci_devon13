<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Member extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('alert');
			$this->load->model('member_model');
		}
		
		public function index()
		{
			if(@$this->session->userdata('logged_in')==FALSE)
			{
				if(!file_exists('application/views/signin.php'))
				{
					show_404();
				}
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
				
				$this->form_validation->set_rules('email','email','required|valid_email');
				$this->form_validation->set_rules('password','password','required|alpha_numeric|md5');
				
				if ($this->form_validation->run() == FALSE)
	            {
					$data['title']="TODO";
					$this->load->view('templates/header',$data);
		            $this->load->view('signin');
		            $this->load->view('templates/footer');
	            }
	            else
	            {
		            $email=$this->input->post('email',TRUE);
		            $password=$this->input->post('password',TRUE);

		            $result=$this->member_model->authorize($email,$password);

		            if($result!=FALSE)
		            {
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
			else
			{
				redirect('/lists/view/'.$this->session->userdata('member_id'),'refresh');
			}
		}

		public function signout()
		{
			$this->session->sess_destroy();

			redirect(base_url(),'refresh');
		}
	}