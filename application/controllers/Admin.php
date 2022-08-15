<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  cek_login();
 }
 public function index()
 {
  $session_user = $this->session->userdata('email');
  $data['title'] = 'Dasboard';
  $data['user'] = $this->M_user->getAll($session_user);
  $this->load->view('template/header', $data);
  $this->load->view('admin/index', $data);
  $this->load->view('template/footer');
 }

 public function role()
 {
  $session_user = $this->session->userdata('email');
  $data['title'] = 'Role';
  $data['user'] = $this->M_user->getAll($session_user);
  $data['role'] = $this->M_admin->getRole();
  $this->load->view('template/header', $data);
  $this->load->view('admin/role', $data);
  $this->load->view('template/footer');
 }

 public function roleaccess($id)
 {
  $session_user = $this->session->userdata('email');
  $data['title'] = 'Role Acess';
  $data['user'] = $this->M_user->getAll($session_user);
  $data['role'] = $this->M_admin->getRowRole($id);
  $data['access'] = $this->M_admin->access($id);
  $this->db->where('id_menu !=', 3);
  $data['menu'] = $this->db->get('user_menu')->result_array();
  $this->load->view('template/header', $data);
  $this->load->view('admin/access', $data);
  $this->load->view('template/footer');
 }


 public function changeaccess()
 {
  $menu_id = $this->input->post('menu_id');
  $role_id = $this->input->post('role_id');
  $data = [
   'role_id' => $role_id,
   'id_menu' => $menu_id
  ];


  $result = $this->db->get_where('user_access_menu', $data);
  if ($result->num_rows() < 1) {
   $this->db->insert('user_access_menu', $data);
  } else {
   $this->db->delete('user_access_menu', $data);
  }
 }
}
