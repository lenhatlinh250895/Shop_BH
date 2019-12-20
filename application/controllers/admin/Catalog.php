<?php 
/**
 * 
 */
class Catalog extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->data['head'] = 'admin/head';
		$this->data['script'] = 'admin/script';
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('admin/Catalog_M');
	}

	function index()
	{
		$list = $this->Catalog_M->getList();
		//textData($list);
		$this->data['total'] = $this->Catalog_M->getTotal();
		$this->data['list'] = $list;
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['temp'] = 'admin/catalog/index';
		$this->load->view('admin/main',$this->data);
	}

	function add()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|min_length[4]');
			$this->form_validation->set_rules('sort_order','Sort Order','integer');
			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$parent_id = $this->input->post('parent_id');
				$sort_order = $this->input->post('sort_order');
				$data = array(
					'name' => $name,
					'parent_id' => $parent_id,
					'sort_order' => $sort_order
				);
				if($this->Catalog_M->create($data))
				{
					$this->session->set_flashdata('message','Create catalog successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Create catalog failed!');
				}
					
				redirect(admin_url('Catalog'));
				//textData($data);
			}
		}
		$input = array();
		$input['where'] = array('parent_id' => 0);
		$list = $this->Catalog_M->getList($input);
		$this->data['list'] = $list;
		$this->data['temp'] = 'admin/catalog/add'; 
		$this->load->view('admin/main',$this->data);
	}
	function edit()
	{
		$id = $this->uri->rsegment(3);
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|min_length[4]');
			$this->form_validation->set_rules('sort_order','Sort Order','integer');
			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$parent_id = $this->input->post('parent_id');
				$sort_order = $this->input->post('sort_order');
				$data = array(
					'name' => $name,
					'parent_id' => $parent_id,
					'sort_order' => $sort_order
				);
				if($this->Catalog_M->update($id,$data))
				{
					$this->session->set_flashdata('message','Upate catalog successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Upate catalog failed!');
				}
					
				redirect(admin_url('Catalog'));
				//textData($data);
			}
		}
		//textData($id);
		$info = $this->Catalog_M->getInfo($id);
		if(!$info)
		{
			$this->session->set_flashdata('message','NO!!!!!!');
			redirect(admin_url('Catalog'));
		}
		$this->data['info'] = $info;

		$input = array();
		$input['where'] = array('parent_id' => 0);
		$list = $this->Catalog_M->getList($input);
		$this->data['list'] = $list;
		$this->data['temp'] = 'admin/catalog/edit'; 
		$this->load->view('admin/main',$this->data);
	}

	function delete()
	{
		$id = $this->uri->rsegment(3);
		//textData($id);
		$id = intval($id);
		$info = $this->Catalog_M->getInfo($id);
		if(!$info)
		{
			$this->session->set_flashdata('message','NO!!!!!!');
			redirect(admin_url('Catalog'));
		}
		if($this->Catalog_M->delete($id))
		{
			$this->session->set_flashdata('message','Delete catalog successfully!');
		}
		else
		{
			$this->session->set_flashdata('message','Delete catalog failed!');
		}
		redirect(admin_url('Catalog'));
	}
}
?>