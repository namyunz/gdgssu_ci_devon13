<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
	 * 사용자의 할 일 목록을 관리한다.
	 */
	class Lists extends CI_Controller
	{
		/*
		 * 기본 생성자
		 */
		function __construct()
		{
			parent::__construct();

			/* 사용할 Model 호출 */
			$this->load->model('todo_model');
			/* 필요한 라이브러리를 불러온다. */
			$this->load->helper('alert');
			$this->load->helper('form');
			$this->load->helper('url');
		}

		/*
		 * 사용자의 할 일 목록을 출력한다.
		 */
		public function view($member_id)
		{
			/* 자신만이 자신의 목록에 접근할 수 있도록 함 */
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				if(!file_exists('application/views/todolist.php'))
				{
					show_404();
				}

				/* View에게 넘길 데이터들 정의 */
				$data['title']="My Todo List";
				$data['list']=$this->todo_model->getTodoList($member_id);

				/* View를 불러오고 정의한 데이터를 인자로 넘겨줌 */
				$this->load->view('templates/header',$data);
	            $this->load->view('todolist');
	            $this->load->view('templates/footer');
	        }
	        /* 부적절한 접근인 경우 오류창을 띄운다. */
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}

		/*
		 * 사용자가 새로 입력한 할 일을 데이터베이스에 저장한다.
		 */
		public function addTodo($member_id)
		{
			/* 자신만이 자신의 목록에 접근할 수 있도록 함 */
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				/* 폼 검증 라이브러리 호출 */
				$this->load->library('form_validation');

				/* 할 일 내용은 반드시 입력되어야함 */
				$this->form_validation->set_rules('contents','Contents','required');

				if ($this->form_validation->run()==TRUE)
				{
					/* 폼 검증을 통과했다면 데이터를 가져와 Model에 있는 addTodo 함수를 호출한다. */
					$contents=$this->input->post('contents',TRUE);

					$this->todo_model->addTodo($member_id,$contents);
				}

				redirect('/lists/view/'.$member_id,'refresh');
			}
			/* 부적절한 접근인 경우 오류창을 띄운다. */
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}

		/*
		 * 사용자가 완료 버튼을 누른 경우에 데이터베이스를 업데이트한다.
		 */
		public function done($member_id,$todo_id)
		{
			/* 자신만이 자신의 목록에 접근할 수 있도록 함 */
			if(@$this->session->userdata('logged_in')==TRUE&&$this->session->userdata('member_id')==$member_id)
			{
				/* Model에 있는 markDone 함수를 호출에 데이터 업데이트 */
				$this->todo_model->markDone($todo_id);
				redirect('/lists/view/'.$member_id,'refresh');
			}
			/* 부적절한 접근인 경우 오류창을 띄운다. */
	        else
	        {
	        	alert('Wrong Request',base_url());
	        }
		}
	}