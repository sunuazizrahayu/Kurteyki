<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_Payment_Confirmation extends CI_Model
{

    public $table_user = 'tb_user';

    public $table_lms_courses = 'tb_lms_courses';
    public $table_lms_user_payment = 'tb_lms_user_payment';	

    public function read($identity){
        $this->db->select('
            tb_lms_courses.title,
            tb_lms_courses.id_user as id_user_courses,
            tb_lms_user_payment.*
            ');
        $this->db->from($this->table_lms_user_payment);		
        $this->db->where('tb_lms_user_payment.id',$identity);
        $this->db->join($this->table_lms_courses, 'tb_lms_courses.id = tb_lms_user_payment.id_courses', 'LEFT JOIN');			
        $data = $this->db->get()->row_array();

        if ($data['status'] == 'Checking') redirect(base_url('user/order'));

        $data['amount'] = $this->_Currency->set_currency($data['amount']);

        $payment = json_decode($this->_Process_MYSQL->get_data($this->table_user,[
            'id' => $data['id_user_courses']
            ])->row()->payment,true);

        foreach ($payment['transaction'] as $transaction) {
            if ($transaction['type'] == $data['token']) {
                $data['transaction_type'] = $transaction['type'];
                $data['transaction_account_number'] = $transaction['account_number'];
                $data['transaction_receiver'] = $transaction['receiver'];                
            }
        }

        return $data;
    }

    public function process(){

        $order_id = $this->input->post('id');

        /**
         * upload proof
         */
        $proof = false;
        if (!empty($_FILES['proof']['name'])) {

            $upload_photo = $this->_Process_Upload->Upload_File(
                'image', // config upload
                'storage/uploads/user/confirmation', // dir upload
                'proof', // file post data
                false, // delete file
                $order_id.'_confirmation', // file name
                false //is image for resizing image or create thumb
                );

            if ($upload_photo['proof']) {
                $proof =  $upload_photo['proof'];
            }
        }   

        if (!$proof) return false;

        $proof_data = json_encode([
            'proof' => $proof,
            'sender' => $this->input->post('sender')
            ]);

        $post_data = [
        'proof' => $proof_data,
        'status' => 'Checking',
        ];

        if ($this->_Process_MYSQL->update_data($this->table_lms_user_payment,$post_data,['id' => $order_id])) {
            return true;
        }
    }

    public function set_validation(){

        if (empty($_FILES['proof']['name']))
        {
            $this->form_validation->set_rules('proof', 'lang:proof_transaction', 'required', [
                'required' => '{field} '.$this->lang->line('must_filled'),
                ]);
        }

        $this->form_validation->set_rules('sender', 'lang:proof_sender', 'required', [
            'required' => '{field} '.$this->lang->line('must_filled'),
            ]);
    }        

}