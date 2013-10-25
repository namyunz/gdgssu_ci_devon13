<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/*
	 * 사용자 데이터를 관리하는 Model이다.
	 */
	class Member_model extends CI_Model
	{
		/*
		 * Argument로 넘어온 데이터를 이용해 로그인을 시도하고 결과를 리턴한다.
		 */
		public function authorize($email,$password)
		{
			/*
			 * SELECT *
			 * FROM `todo_member`
			 * WHERE `email_address`=$password;
			 */
			$query=$this->db->select('*')
				   			->from('todo_member')
				   			->where('email_address',$email);
			
			$result=$query->get()->result_array();

			if(count($result)>0)
			{
				if(!strcmp($result[0]['password'],$password))
				{
					return $result[0];
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return TRUE;
			}	   
		}
	}