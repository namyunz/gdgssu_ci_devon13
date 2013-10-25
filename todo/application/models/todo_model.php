<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*
	 * 할 일 목록을 관리하는 Model이다.
	 */
	class Todo_model extends CI_Model
	{
		/*
		 * 사용자의 할 일 목록을 데이터베이스로부터 가져온다.
		 */
		public function getTodoList($member_id)
		{
			/*
			 * SELECT *
			 * FROM `todo_list`
			 * WHERE `member_id`=$member_id;
			 */
			$query=$this->db->select('*')
							->from('todo_list')
							->where('member_id',$member_id);

			return $query->get()->result_array();
		}

		/*
		 * 사용자가 입력한 할 일을 데이터베이스에 추가한다.
		 */
		public function addTodo($member_id,$contents)
		{
			/*
			 * INSERT INTO `todo_list` (`todo_id`,`member_id`,`contents`,`date`,`is_done`)
			 * VALUES (0,$member_id,$contents,date("Y-m-d H:i:s"),0);
			 */
			$new_todo=array('todo_id'=>0,
							'member_id'=>$member_id,
							'contents'=>$contents,
							'date'=>date("Y-m-d H:i:s"),
							'is_done'=>0);

			$this->db->insert('todo_list',$new_todo);
			return $this->db->insert_id();
		}

		/*
		 * 사용자의 할 일을 완료된 상태로 수정한다.
		 */
		public function markDone($todo_id)
		{
			/*
			 * UPDATE `todo_list`
			 * SET `is_done`=1
			 * WHERE `todo_id`=$todo_id;
			 */
			$edit_todo=array('is_done'=>1);

			$this->db->where('todo_id',$todo_id);
			$this->db->update('todo_list',$edit_todo);
		}
	}