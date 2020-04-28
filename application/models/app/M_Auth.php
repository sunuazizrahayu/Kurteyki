<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_Auth extends CI_Model
{

    public $table_user = 'tb_user';

    public function data_post(){

        $username = strip_tags($this->input->post('username'));
        $password = strip_tags($this->input->post('password'));
        $csrf_code = $this->input->post('csrf_code');

        return [
        'username' => $username,
        'password' => $password,
        'csrf_code' => $csrf_code,
        ];
    }

    public function login(){

        $post_data = $this->data_post();


        if ($post_data['csrf_code'] != '' AND $this->session->userdata('csrf_code') == $post_data['csrf_code']) {

            $data = array(
                'username' => $post_data['username'],
                'password' => sha1($post_data['password']),  
                'grade' => 'App'    
                );

            $read = $this->_Process_MYSQL->get_data($this->table_user,$data);

            if ($read->num_rows() > 0) {

                $read_data = $read->row_array();
                $id = $read_data['id'];

                $data_update = array(
                    'last_login' => date('Y:m:d H:i:s'),
                    );

                if ($this->_Process_MYSQL->update_data($this->table_user, $data_update, array('id' => $id)) == TRUE) {

                    $this->session->set_userdata(array(
                        'id' => $read_data['id'],
                        'app_username' => $read_data['username'],                  
                        'app_photo' => $read_data['photo'],
                        'app_grade' => $read_data['grade'], 
                        'status' => "login",
                        'key' => sha1($read_data['id'].$read_data['username'].date('YmdHis'))
                        ));

                    $this->session->unset_userdata('csrf_code');

                    return 'success';
                }

            }else {

                return 'not_exist';
            }

        }else {

            return 'invalid';
        }
    } 

    function logout(){

        $this->session->unset_userdata(['id','app_username','app_photo','app_grade','status','key']);
        return 'success';
    }

    function check($type,$data,$redirect){
        if ($type == 'exist') {
            if ($this->session->userdata($data)) {
                redirect(base_url($redirect));
            }
        }elseif ($type == 'not_exist') {
            if (empty($this->session->userdata($data))) {
                redirect(base_url($redirect));
            }
        }
    }      

}
