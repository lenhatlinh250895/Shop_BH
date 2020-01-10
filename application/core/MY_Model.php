<?php 
/**
 * 
 */
class MY_Model extends CI_Model
{
	var $table 	= '';
	var $key 	= 'id';
	var $order	= '';
	var $select = '';
	
	function create($data)
	{
		if($this->db->insert($this->table,$data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update($id,$data)
	{
		if(!$id)
			return false;
		$where = array();
		$where[$this->key] = $id;
		$this->updateRule($where,$data);
		return true;
	}

	function updateRule($where,$data)
	{
		if(!$where)
			return false;
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return true;
	}

	function delete($id)
	{
		if(!$id)
			return false;
		if(is_numeric($id))
		{
			$where = array($this->key => $id);
		}
		else
		{
			$where = $this->key . "IN (".$id.")";
		}
		$this->delRule($where);
		return true;
	}

	function delRule($where)
	{
		if(!$where)
			return false;
		$this->db->where($where);
		$this->db->delete($this->table);
	}

	function getInfo($id,$field = '')
	{
		if(!$id)
			return false;
		$where = array();
		$where[$this->key] = $id;
		return $this->getInfoRule($where,$field);
	}

	function getInfoRule($where = array(),$field = '')
	{
		if($field)
			$this->db->select($field);
		$this->db->where($where);
		$query = $this->db->get($this->table);
		if($query->num_rows())
			return $query->row();
		return false;
	}

	function getTotal($input = array())
	{
		$this->getListSetInput($input);
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}

	function getList($input = array())
	{
		$this->getListSetInput($input);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	function getListSetInput($input = array())
	{
		if(isset($input['where']) && $input['where'])
		{
			$this->db->where($input['where']);		
		}

		if(isset($input['like']) && $input['like'])
		{
			$this->db->like($input['like'][0],$input['like'][1]);		
		}

		if(isset($input['like1']) && $input['like1'])
		{
			$this->db->like($input['like1'][0],$input['like1'][1]);		
		}

		if(isset($input['order'][0]) && isset($input['order'][1]))
		{
			$this->db->order_by($input['order'][0],$input['order'][1]);		
		}
		else
		{
			$order = ($this->order == '') ? array($this->table.'.'.$this->key,'desc') : $this->order;
			$this->db->order_by($order[0],$order[1]);
		}

		if(isset($input['limit'][0]) && isset($input['limit'][1]))
		{
			$this->db->limit($input['limit'][0],$input['limit'][1]);
		}
	}

	function checkExists($where = array())
	{
		if(!$where)
			return false;
		$this->db->where($where);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
}
?>