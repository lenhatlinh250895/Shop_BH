<?php 
/**
 * 
 */
class Admin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['head'] = 'admin/head';
		$this->data['script'] = 'admin/script';
		$this->load->model('admin/Admin_M');
		$this->load->library('form_validation');
		$this->load->helper('form');
	}

	function index($offset = 1)
	{
		$this->data['temp'] = 'admin/admin/index';
		$total = $this->Admin_M->getTotal();
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = admin_url('Admin/index');
		$config['total_rows'] = $total;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config['per_page'] = 2;
		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();
		$this->data['pagination'] = $pagination;
		$input = array();
		$input['limit'] = array(
			$config['per_page'],
			($offset - 1)*$config['per_page']
		);
		$list = $this->Admin_M->getList($input);
		$this->data['list'] = $list;

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['total'] = $this->Admin_M->getTotal();
		//textData($list);
		$this->load->view('admin/main',$this->data);
	}

	function add()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|min_length[4]');
			$this->form_validation->set_rules('username','User Name','required|is_unique[admin.username]');
			$this->form_validation->set_rules('password','Pass Word','required|min_length[6]');
			$this->form_validation->set_rules('repassword','Re Pass Word','required|matches[password]');
			$this->form_validation->set_rules('email','Email','required|valid_email');

			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$email = $this->input->post('email');
				$level = $this->input->post('level');
				$data = array(
					'name' => $name,
					'username' => $username,
					'password' => md5($password),
					'email' => $email,
					'level' => $level, 
				);
				if($this->Admin_M->create($data))
				{
					$this->session->set_flashdata('message','Create admin successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Create admin failed!');
				}
				redirect(admin_url('admin'));
			}
		}

		$this->data['temp'] = 'admin/admin/add';
		$this->load->view('admin/main',$this->data);
	}

	function edit()
	{
		$id = $this->uri->rsegment('3');
		$info = $this->Admin_M->getInfo($id);
		if(!$info)
		{
			$this->session->set_flashdata('message','No!!!');
			redirect(admin_url('admin'));
		}
		$this->data['info'] = $info;
		if($this->input->post())
		{
			$username = $this->input->post('username');
			$this->form_validation->set_rules('name','Name','required|min_length[4]');
			if($username != $info->username)
				$this->form_validation->set_rules('username','User Name','required|is_unique[admin.username]');
			$this->form_validation->set_rules('email','Email','required|valid_email');
			$password = $this->input->post('password');
			if($password)
			{
				$this->form_validation->set_rules('password','Pass Word','required|min_length[6]');
				$this->form_validation->set_rules('repassword','Re Pass Word','required|matches[password]');
			}

			if($this->form_validation->run())
			{
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$level = $this->input->post('level');
				$data = array(
					'name' => $name,
					'username' => $username,
					'email' => $email,
					'level' => $level, 
				);
				if($password)
				{
					$data['password'] = md5($password);
				}

				if($this->Admin_M->update($id,$data))
				{
					$this->session->set_flashdata('message','Update admin successfully!');
				}
				else
				{
					$this->session->set_flashdata('message','Update admin failed!');
				}
				redirect(admin_url('admin'));

			}
		}

		$this->data['temp'] = 'admin/admin/edit';
		$this->load->view('admin/main',$this->data);
	}

	function removeUserAjax()
	{
		$response = array();
		if($this->input->post('delete'))
		{
			$id = intval($this->input->post('delete'));
			$delete = $this->Admin_M->delete($id);
			if($delete)
			{
				$response['status'] = 'success';
				$response['message'] = 'Đã xóa thành công!';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'Xóa thất bại!';
			}
			echo json_encode($response);
		}
		else
			echo json_encode('adsfsadf');
	}

	function delete()
	{
		$id = $this->uri->rsegment('3');
		$id = intval($id);
		$info = $this->Admin_M->getInfo($id);
		if(!$info)
		{
			$this->session->set_flashdata('message','No!!!');
			redirect(admin_url('admin'));
		}

		if($this->Admin_M->delete($id))
		{
			$this->session->set_flashdata('message','Delete admin successfully!');
		}
		else
		{
			$this->session->set_flashdata('message','Delete admin failed!');
		}
		redirect(admin_url('admin'));
	}

	function logout()
	{
		if($this->session->userdata('admin'))
		{
			$this->session->sess_destroy();
		}
		redirect(admin_url('Login'));
	}

	public function search($offset = 1)
	{
		$post = $this->input->post();
		$config['per_page'] = 2;
		$config['base_url'] = '#';
		$config['uri_sengment'] = 4;
		$input = array();
		if(!empty($post['id']))
		{
			$input['where'] = array(
				'id' => $post['id']
			);
		}
		if(!empty($post['email']))
		{
			$input['like'] = array(
				'email',
				trim($post['email'])
			);
		}
		if(!empty($post['name']))
		{
			$input['like1'] = array(
				'name',
				$post['name']
			);
		}
		$total_user_search = $this->Admin_M->getTotal($input); 
		$limit = ($offset-1)*$config['per_page'];
		$input['limit'] = array(
			$config['per_page'],
			$limit
		);
		// textData($input);
		$list_users_search = $this->Admin_M->getList($input);


		$config['total_rows'] = $total_user_search;
		$total_rows = ceil($config['total_rows']/$config['per_page']);
		$config['use_page_numbers'] = true;
		$config['num_tag_open']     = '<li class="pagclick">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<strong><li class="active"><a href="#">';
        $config['cur_tag_close']    = '</a></li></strong>';
        $config['next_tag_open']    = '<li class="next">';
        $config['next_tag_close']   = '</li>';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '>';
        $config['prev_link']        = '<';
        $config['first_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="last">';
        $config['last_tag_close']   = '</li>';
        $config['last_link']  = 'Last';
        $config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();

		$html = '<thead>
	              <tr>
	                <th> ID </th>
	                <th> NAME </th>
	                <th> USER NAME </th>
	                <th> EMAIL </th>
	                <th> LEVEL </th>
	                <th> DELETE </th>
	                <th> UPDATE </th>
	              </tr>
	            </thead>
	            <tbody>';

	    if($total_user_search > 0)
	    {
	    	foreach($list_users_search as $user_val)
	    	{
	    		$html .= '<tr>
			                <td class="py-1">'.
			                  $user_val->id.
			                '</td>
			                <td>'.$user_val->name.'</td>
			                <td>'.$user_val->username.'</td>
			                <td>'.$user_val->email.'</td>
			                <td>'.$user_val->level.'</td>
			                <td><a href="#" class="btn btn-danger verify_action" id="btndel" data-id="'.$user_val->id.'">Delete</a></td>
			                <td><a href="'.admin_url("Admin/edit/".$user_val->id).'" class="btn btn-success">Update</a></td>
			              </tr>';
	    	}
	    }
	    else
	    {
	    	$html .= '<tr><td colspan="7" style="color: red">Không có kết quả!</td></tr>';
	    }
	    $html .= '</tbody>';

	    $myObj['data_html'] = $html;
	    $myObj['data_pagination'] = $pagination;
	    $myObj['data_total_rows'] = $total_rows;
	    $myObj['data_this_page'] = $offset;
	    $myJSON = json_encode($myObj);
	    echo $myJSON;
	}

	public function fSearch()
	{
		$config['per_page'] = 2;
		$config['base_url'] = '#';
		$config['uri_sengment'] = 4;
	}
	// public function addAdmin()
	// {
	// 	$this->load->library('form_validation');
	// 	$this->form_validation->set_rules('name','name','required');
	// 	if($this->form_validation->run())
	// 	{
	// 		$array_newadmin = array(
	// 			'name' => $_POST['name'],
	// 			'username' => $_POST['username'],
	// 			'password' => md5(md5($_POST['password'])),
	// 			'level' => $_POST['level'],
	// 			'email' => $_POST['email'],
	// 		);
	// 		if($this->Admin_M->addAdmin($array_newadmin))
	// 		{
	// 			echo "Add admin successfully";
	// 		}
	// 		else
	// 		{
	// 			echo "Add admin fail";
	// 		}
	// 	}
	// }

	// public function loadData($offset = 1)
	// {
	// 	$adata['page'] = $this->uri->segment(3);
	// 	$config['base_url'] = "#";
	// 	$config['uri_segment'] = 3;
	// 	$config['per_page'] = 3;
	// 	$data = [
	// 		'start' => $config['per_page'],
	// 		'limit' => ($offset - 1)*$config['per_page'],
	// 	];
	// 	$list_users = $this->Admin_M->listAll($data);
	// 	$total_user = $this->Admin_M->countAll();
	// 	$config['total_rows'] = $total_user;
	// 	$config['use_page_numbers'] = TRUE;
 //        $config['num_tag_open']     = '<li>';
 //        $config['num_tag_close']    = '</li>';
 //        $config['cur_tag_open']     = '<li class="active"><a href="#">';
 //        $config['cur_tag_close']    = '</a></li>';
 //        $config['next_tag_open']    = '<li>';
 //        $config['next_tag_close']   = '</li>';
 //        $config['prev_tag_open']    = '<li>';
 //        $config['prev_tag_close']   = '</li>';
 //        $config['next_link']        = '>';
 //        $config['prev_link']        = '<';
 //        $config['first_tag_open']   = '<li>';
 //        $config['first_tag_close']  = '</li>';
 //        $config['last_tag_open']    = '<li>';
 //        $config['last_tag_close']   = '</li>';
 //        $config['last_link']  		= 'Last';
 //        $config['first_link'] 		= 'First';

 //        $this->pagination->initialize($config);
 //        $pagination = $this->pagination->create_links();

	// 	// echo "<pre>";
	// 	// print_r($data['info']);
	// 	$html = "";
	// 	$html .= 	'<table class="table table-striped table-bordered border">
	// 		            <thead>
	// 		              <tr>
	// 		                <th> ID </th>
	// 		                <th> NAME </th>
	// 		                <th> USER NAME </th>
	// 		                <th> EMAIL </th>
	// 		                <th> LEVEL </th>
	// 		                <th> DELETE </th>
	// 		                <th> UPDATE </th>
	// 		              </tr>
	// 		            </thead>
	// 		            <tbody>';
	// 	foreach($list_users as $row)
	// 	{
	// 		$html .= 	'<tr>
	// 		                <td class="py-1">'.
	// 		                  $row->id.'
	// 		                </td>
	// 		                <td>'.$row->name.'</td>
	// 		                <td>'.$row->username.'</td>
	// 		                <td>'.$row->email.'</td>
	// 		                <td>'.$row->level.'</td>
	// 		                <td><a href="#" class="btn btn-danger" id="btndel" data="'.$row->id.'">Delete</a></td>
 //                			<td><a href="#" class="btn btn-info" id="btnupdate" data="'.$row->id.'">Update</a></td>
	// 		              </tr>';
	// 	}
	// 	$html .= 	'</tbody>
 //          				</table>';
 //        $adata['pagination'] = $pagination;
 //        $adata['html'] = $html;
 //       	echo json_encode($adata);
	// }

	// public function deleteUser()
	// {
	// 	$id = $this->input->post('id');
	// 	$result = $this->Admin_M->deleteUser($id);
	// 	if($result)
	// 		echo 1;
	// 	else
	// 		echo 0;
	// }

	// public function edit()
	// {
	// 	$id = $this->input->post('id');
	// 	$row = $this->Admin_M->getUser($id);
	// 	if($row)
	// 		echo json_encode($row);
	// 	else
	// 		echo json_encode('Error');
	// }

	// public function updateAdmin()
	// {
	// 	$array_updateadmin = array(
	// 		'name' => $_POST['name'],
	// 		'username' => $_POST['username'],
	// 		'level' => $_POST['level'],
	// 		'email' => $_POST['email'],
	// 	);
	// 	if(isset($_POST['password']) && !empty($_POST['password']))
	// 		$array_updateadmin['password'] = md5(md5($_POST['password']));
	// 	$result = $this->Admin_M->updateAdmin($array_updateadmin);
	// 	if($result)
	// 		echo "Update Admin Successfully!";
	// 	else
	// 		echo "Update Admin Fail!";
	// }

}
?>