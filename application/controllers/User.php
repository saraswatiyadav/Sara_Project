<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() { 
         parent::__construct(); 
        
        $this->load->helper(array('form','url'));
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('user_model');
		$this->load->library('session');
          
      }


	public function index()
	{ 
		echo "Hello Innctech Solution Team..." ;
		//$this->load->view('welcome_message');
		$this->load->view('user_view',array('error'=> ''));
	}
	public function do_upload(){

		//Including validation library

	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	
	$this->form_validation->set_rules('first_name', 'Username', 'required');
	$this->form_validation->set_rules('last_name', 'Address', 'required');
	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	$this->form_validation->set_rules('age', 'Age', 'required');



			if ($this->form_validation->run() == FALSE) 
			{
			$this->load->view('user_view');
			} 
			else
			{
			if($this->input->post())
			{
				$config['upload_path']   = './uploads/';
				$config['allowed_types'] = 'jpg|jpeg|png|doc|docx';
				$cofig['overwrite']		 = true;
				$config['max_size']		 = 2048000; 
				$config['max_width']	 = 1024;
				$config['max_height']	 = 768;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('user_file')){
					$imgdata= array('upload_data'=> $this->upload->data());
				
				//print_r($imgdata); die;
				}		
							
			$data = array(
			//'user_id' => $this->input->post('uid'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'age' => $this->input->post('age'),
			'email' => $this->input->post('email'),
			'image'=> $imgdata['upload_data']['file_name']

			);
			$this->user_model->user_insert($data);
			echo $data['message'] = 'Data Inserted Successfully';		 

			}

			$this->load->view('user_view',array('error'=> ''));
			
		}

	}
}
