<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Lists extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			$this->load->model('todo_model');
			$this->load->helper('alert');
			$this->load->helper('form');
			$this->load->helper('url');
		}

		public function view($member_id)
		{
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				if(!file_exists('application/views/todolist.php'))
				{
					show_404();
				}

				$data['title']="My Todo List";
				$data['list']=$this->todo_model->getTodoList($member_id);

				$this->load->view('templates/header',$data);
	            $this->load->view('todolist');
	            $this->load->view('templates/footer');
	        }
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}

		public function addTodo($member_id)
		{
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('contents','Contents','required');

				if ($this->form_validation->run()==TRUE)
				{
					$contents=$this->input->post('contents',TRUE);

					$this->todo_model->addTodo($member_id,$contents);
				}

				redirect('/lists/view/'.$member_id,'refresh');
			}
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}

		public function done($member_id,$todo_id)
		{
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				$this->todo_model->markDone($todo_id);
				redirect('/lists/view/'.$member_id,'refresh');
			}
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}
	}