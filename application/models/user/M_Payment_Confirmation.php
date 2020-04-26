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

}