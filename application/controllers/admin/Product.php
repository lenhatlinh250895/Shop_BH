<?php 
/**
 * 
 */
class Product extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->data['head'] = 'admin/head';
		$this->data['script'] = 'admin/script';
		$this->load->model('admin/Product_M');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('admin/Catalog_M');
	}

	function index()
	{
		$total = $this->Product_M->getTotal();
		//textData($list);
		$this->data['total'] = $total;
		$this->load->library('pagination');
		$config = array();
		$config['total_rows'] = $total;
		$config['base_url'] = admin_url('Product/index');
		$config['per_page'] = 4;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$segment = $this->uri->segment(4);
		$segment = intval($segment);
		$input = array();
		$input['limit'] = array($config['per_page'],$segment);
		$list = $this->Product_M->getList($input);
		$this->data['list'] = $list;

		$this->load->model('admin/Catalog_M');
		$input = array();
		$input['where'] = array('parent_id' => 0);
		$catalogs = $this->Catalog_M->getList($input);
		foreach($catalogs as $row)
		{
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->Catalog_M->getList($input);
			$row->subs = $subs;
		}
		//textData($catalogs);
		$this->data['catalogs'] = $catalogs;
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['temp'] = 'admin/product/index';
		$this->load->view('admin/main',$this->data);
	}

	function add()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required');

			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$catalog_id = $this->input->post('catalog');
				$price = $this->input->post('price');
				$discount = $this->input->post('discount');
				$name = $this->input->post('name');

				$this->load->library('upload_library');
				$upload_path = './upload/product';
				$upload_data = $this->upload_library->upload($upload_path,'imagelink');
				$image_link = '';
				if(isset($upload_data['file_name']))
				{
					$image_link = $upload_data['file_name'];
				}

				$image_list = $this->upload_library->upload_file($upload_path,'imagelist');
				$image_list = json_encode($image_list);
				//textData($image_list);
				$data = array(
					'name' => $name,
					'catalog_id' => $catalog_id,
					'price' => $price,
					'discount' => $discount,
					'image_link' => $image_link,
					'image_list' => $image_list,
					'created'	=> now()
				);
				if($this->Product_M->create($data))
				{
					$this->session->set_flashdata('message','Create product successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Create product failed!');
				}
					
				redirect(admin_url('Product'));
				//textData($data);
			}
		}
		$input = array();
		$input['where'] = array('parent_id' => 0);
		$catalogs = $this->Catalog_M->getList($input);
		foreach($catalogs as $row)
		{
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->Catalog_M->getList($input);
			$row->subs = $subs;
		}

		$this->data['catalogs'] = $catalogs;
		$this->data['temp'] = 'admin/product/add';
		$this->load->view('admin/main',$this->data);
	}

	function edit()
	{
		$id = $this->uri->rsegment(3);
		$product = $this->Product_M->getInfo($id);
		if(!$product)
		{
			$this->session->set_flashdata('message','NO!!!!!!');
			redirect(admin_url('Product'));
		}
		$this->data['product'] = $product;
		//textData($product);

		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required');

			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$catalog_id = $this->input->post('catalog');
				$price = $this->input->post('price');
				$price = str_replace(",","",$price);
				$discount = $this->input->post('discount');
				$discount = str_replace(",","",$discount);
				$name = $this->input->post('name');

				$this->load->library('upload_library');
				$upload_path = './upload/product';
				$upload_data = $this->upload_library->upload($upload_path,'imagelink');
				$image_link = '';
				if(isset($upload_data['file_name']))
				{
					$image_link = $upload_data['file_name'];
				}

				$image_list = array();
				$image_list = $this->upload_library->upload_file($upload_path,'imagelist');
				$image_list_json = json_encode($image_list);
				//textData($image_list);
				$data = array(
					'name' => $name,
					'catalog_id' => $catalog_id,
					'price' => $price,
					'discount' => $discount,
					'created' => now()
				);
				if($image_link != '')
				{
					$data['image_link'] = $image_link;
				}
				if(!empty($image_list))
				{
					$data['image_list'] = $image_list_json;
				}
				if($this->Product_M->update($id,$data))
				{
					$this->session->set_flashdata('message','Update product successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Update product failed!');
				}
					
				redirect(admin_url('Product'));
				//textData($data);
			}
		}
		$input = array();
		$input['where'] = array('parent_id' => 0);
		$catalogs = $this->Catalog_M->getList($input);
		foreach($catalogs as $row)
		{
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->Catalog_M->getList($input);
			$row->subs = $subs;
		}

		$this->data['catalogs'] = $catalogs;
		$this->data['temp'] = 'admin/product/edit';
		$this->load->view('admin/main',$this->data);
	}

	function delete()
	{
		$id = $this->uri->rsegment(3);
		$this->_del($id);

		$this->session->set_flashdata('message','Delete product successfully!');
		redirect(admin_url('Product'));
	}

	function dellAll()
	{
		$ids = $this->input->post('ids');
		//textData($ids);
		foreach($ids as $id)
		{
			$this->_del($id);
		}
	}

	function _del($id)
	{
		$product = $this->Product_M->getInfo($id);
		if(!$product)
		{
			$this->session->set_flashdata('message','NO!!!!!!');
			redirect(admin_url('Product'));
		}
		$this->Product_M->delete($id);
		$image_link = './upload/product/'.$product->image_link;
		if(file_exists($image_link)){
			unlink($image_link);
		}

		$image_list = json_decode($product->image_list);
		if(is_array($image_list))
		{
			foreach($image_list as $img)
			{
				$image_link = './upload/product/'.$img;
				if(file_exists($image_link))
				{
					unlink($image_link);
				}
			}
		}
	}
}
?>