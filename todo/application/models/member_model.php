<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Member_model extends CI_Model
	{
		public function authorize($email,$password)
		{
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