<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_Review extends CI_Model
{

	public $table_lms_user_review = 'tb_lms_user_review';
	public $table_lms_courses = 'tb_lms_courses';

	public function read(){

		$post = $this->input->post();

		$check_data = [
		'id_user' => $this->session->userdata('id_user'),
		'id_courses' => $post['id_courses'],
		];

		/** check if user have review */
		$user_review = $this->_Process_MYSQL->get_data($this->table_lms_user_review,$check_data);

		if ($user_review->num_rows() < 1) return false;

		$read = $user_review->row_array();

		echo json_encode($read);
	}

	public function process(){

		$post = $this->input->post();

		$check_data = [
		'id_user' => $this->session->userdata('id_user'),
		'id_courses' => $post['id_courses'],
		];

		$post_data = [
		'rating' => $post['rating'],
		'review' => $post['review']
		];

		$post_data = array_merge($check_data,$post_data);

		/** check if user have review */
		$user_review = $this->_Process_MYSQL->get_data($this->table_lms_user_review,$check_data);

		if ($user_review->num_rows() < 1) {
			if ($this->create_review($post_data)) {
				echo json_encode([
					'message' => 'Sukses mengirim review'
					]);
			}
		}else{
			if ($this->update_review($post_data)) {
				echo json_encode([
					'message' => 'Sukses update review'
					]);
			}
		}

	}

	public function create_review($post_data){

		/** check if courses exist */
		$courses = $this->_Process_MYSQL->get_data($this->table_lms_courses,['id' => $post_data['id_courses']]);

		if ($courses->num_rows() > 0) { 

			$post_data['time'] = date('Y:m:d H:i:s');
			return $this->_Process_MYSQL->insert_data($this->table_lms_user_review, $post_data);
		}else {
			redirect(base_url());
		}

	}

	public function update_review($post_data){

		/** check if courses exist */
		$courses = $this->_Process_MYSQL->get_data($this->table_lms_courses,['id' => $post_data['id_courses']]);

		if ($courses->num_rows() > 0) { 
			return $this->_Process_MYSQL->update_data($this->table_lms_user_review, $post_data, ['id_user' => $post_data['id_user'],'id_courses' => $post_data['id_courses']]);
		}else {
			redirect(base_url());
		}

	}	

}