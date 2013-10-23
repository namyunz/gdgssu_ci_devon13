<?php

	class Todo_model extends CI_Model
	{
		public function getTodoList($member_id)
		{
			$query=$this->db->select('*')
							->from('todo_list')
							->where('member_id',$member_id);

			return $query->get()->result_array();
		}

		public function addTodo($member_id,$contents)
		{
			$new_todo=array('todo_id'=>0,
							'member_id'=>$member_id,
							'contents'=>$contents,
							'date'=>date("Y-m-d H:i:s"),
							'is_done'=>0);

			$this->db->insert('todo_list',$new_todo);
			return $this->db->insert_id();
		}

		public function markDone($todo_id)
		{
			$edit_todo=array('is_done'=>1);

			$this->db->where('todo_id',$todo_id);
			$this->db->update('todo_list',$edit_todo);
		}
	}