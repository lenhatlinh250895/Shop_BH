<?php 
/**
 *  
 */
class Admin_M extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	// protected $_table = "admin";
	var $table = 'admin';
	// public function listAll($data)
	// {
	// 	if(isset($data['start']) && isset($data['limit']))
	// 	{
	// 		// $this->db->select('id','name','username','level','email');
	// 		return $this->db->get($this->_table,$data['start'],$data['limit'])->result();
	// 	}
	// 	else
	// 	{
	// 		$query = $this->db->get($this->_table);
	// 		if($query->num_rows() > 0)
	// 		{
	// 			return $query->result();
	// 		}
	// 		else
	// 		{
	// 			return false;
	// 		}
	// 	}
	// }

	// public function addAdmin($array_newadmin)
	// {
	// 	$this->db->insert($this->_table,$array_newadmin);
	// 	if($this->db->affected_rows() >0 )
	// 		return true;
	// 	else
	// 		return false;
	// }

	// public function deleteUser($id)
	// {
	// 	$this->db->where('id',$id);
	// 	$this->db->delete($this->_table);
	// 	if($this->db->affected_rows() > 0)
	// 		return true;
	// 	return false;
	// }

	// public function getUser($id)
	// {
	// 	$this->db->where('id',$id);
	// 	$query = $this->db->get($this->_table);
	// 	if($query->num_rows() > 0)
	// 		return $query->row();
	// 	return false;
	// }

	// public function updateAdmin($array_updateadmin)
	// {
	// 	$this->db->where('username',$array_updateadmin['username']);
	// 	$this->db->update($this->_table,$array_updateadmin);
	// 	return true;
	// }

	// public function countAll()
	// {
	// 	return $this->db->count_all($this->_table);
	// }
}
?>