<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_invoice extends My_App
{

    public $index = 'app/user_invoice/index';
    public $form = 'app/user_invoice/form';
    public $redirect = 'app/user_invoice';

    public function __construct(){
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('app/M_User_Invoice');         
    }    

    public function index()
    {

        $data = [
        'title' => 'Invoice',
        ];

        $this->load->view($this->index, array_merge($data,$this->M_User_Invoice->datatables()));
    }    


    public function datatables()
    {

        $data = $this->M_User_Invoice->data_table();

        echo $data;
    }  

    public function delete($id)
    {
        if ($this->M_User_Invoice->process_delete($id) == TRUE) {
            echo true;
        }else {
            echo false;
        }
    }

    public function process(){       

        if (!empty($this->input->post('id'))) {

            if ($this->M_User_Invoice->process_update() == TRUE) {

                $this->session->set_flashdata([
                    'message' => true,
                    'message_type' => 'info',
                    'message_text' => $this->lang->line('success_update'),
                    ]);
            }   

        }else {

            if ($this->M_User_Invoice->process_create() == TRUE) {

                $this->session->set_flashdata([
                    'message' => true,
                    'message_type' => 'info',
                    'message_text' => $this->lang->line('success_create'),
                    ]);
            }   

        }

        if (!empty($this->input->post('save'))) {
            redirect($this->input->post('save'),'refresh');
        }else {                
            redirect(base_url($this->redirect));
        }
    }

    public function process_multiple()
    {

        $id = explode(',', $this->input->post('id'));
        $action = $this->input->post('action');

        /**
         * Update user to active
         */
        if ($action == 'active') {

            if ($this->M_User_Invoice->process_multiple_update($id,'Active') == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }        

        /**
         * Update user to block
         */
        if ($action == 'block') {

            if ($this->M_User_Invoice->process_multiple_update($id,'Blocked') == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }

        /**
         * Delete user
         */
        if ($action == 'delete') {

            if ($this->M_User_Invoice->process_multiple_delete($id) == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }

    }    

}
