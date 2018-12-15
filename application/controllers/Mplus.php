<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mplus extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('mplus_model','mplus_m');
    }
 
    public function index()
    {
        $this->load->view('list_book');
    }
 
    public function ajax_list()
    {
        $list = $this->mplus_m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $person->title;
            $row[] = $person->author;
            $row[] = $person->date_published;
            $row[] = $person->number_of_pages;
            $row[] = $person->type_of_book;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mplus_m->count_all(),
                        "recordsFiltered" => $this->mplus_m->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        if($_POST['draw'] != null){
	        echo json_encode($output);
	    }
    }
 
    public function ajax_edit($id)
    {
        $data = $this->mplus_m->get_by_id($id);
        $data->date_published = ($data->date_published == '0000-00-00') ? '' : $data->date_published; 
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $result=array();
        $data = array(
                'title' => $this->input->post('title'),
                'author' => $this->input->post('author'),
                'date_published' => $this->input->post('date_published'),
                'number_of_pages' => $this->input->post('number_of_pages'),
                'type_of_book' => $this->input->post('type_of_book'),
            );
        $insert = $this->mplus_m->save($data);
        if($insert){
        	$result['status']=TRUE;
        	$result['action'] = 'save';
        	$result['message'] = 'Data saved successfully';
        }
        echo json_encode($result);
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $result=array();
        $data = array(
                'title' => $this->input->post('title'),
                'author' => $this->input->post('author'),
                'date_published' => $this->input->post('date_published'),
                'number_of_pages' => $this->input->post('number_of_pages'),
                'type_of_book' => $this->input->post('type_of_book'),
            );
        $update = $this->mplus_m->update(array('id' => $this->input->post('id')), $data);
        if($update){
        	$result['status']=TRUE;
        	$result['action'] = 'update';
        	$result['message'] = 'Data updated successfully';
        }else{
        	$result['status']=TRUE;
        	$result['action'] = 'update';
        	$result['message'] = 'Data has not changed';
        }
        echo json_encode($result);
    }
 
    public function ajax_delete($id)
    {
    	$result=array();
        $delete =$this->mplus_m->delete_by_id($id);
        if($delete){
        	$result['status']=TRUE;
        	$result['action'] = 'delete';
        	$result['message'] = 'Data deleted successfully';
        }
        echo json_encode($result);
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('title') == '')
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'title is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('author') == '')
        {
            $data['inputerror'][] = 'author';
            $data['error_string'][] = 'author is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('number_of_pages') < 0)
        {
            $data['inputerror'][] = 'number_of_pages';
            $data['error_string'][] = 'Number of page must > 0';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
