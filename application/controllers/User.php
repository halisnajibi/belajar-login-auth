<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login();
  }
  public function index()
  {
    $session_user = $this->session->userdata('email');
    $data['title'] = 'My Profiel';
    $data['user'] = $this->M_user->getAll($session_user);
    $this->load->view('template/header', $data);
    $this->load->view('user/index', $data);
    $this->load->view('template/footer');
  }

  public function edit()
  {
    $session_user = $this->session->userdata('email');
    $data['title'] = 'Edit Profiel';
    $data['user'] = $this->M_user->getAll($session_user);
    $this->form_validation->set_rules('name', 'full name', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/header', $data);
      $this->load->view('user/edit', $data);
      $this->load->view('template/footer');
    } else {
      //cek jik ada upload
      $upload_image = $_FILES['image']['name'];
      if ($upload_image) {
        //cek validasi upload
        $config['upload_path'] = './assets/img/profiel/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']     = '1000';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
          $old_image = $data['user']['image'];
          if ($old_image != 'default.jpg') {
            unlink(FCPATH . 'assets/img/profiel/' . $old_image);
          }
          $new_image = $this->upload->data('file_name');
          $this->M_user->profiel($new_image);
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
' . $this->upload->display_errors()  . '
  </div>');
          redirect('user');
        }
      }
      $this->M_user->profiel();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
Your Profiel Has been update !
  </div>');
      redirect('user');
    }
  }



  public function password()
  {

    $session_user = $this->session->userdata('email');
    $data['title'] = 'Change Password';
    $data['user'] = $this->M_user->getAll($session_user);
    $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
    $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/header', $data);
      $this->load->view('user/password', $data);
      $this->load->view('template/footer');
    } else {
      //cek password lama dan baru ini sama
      $current_password = $this->input->post('current_password');
      $new_password = $this->input->post('new_password1');
      if (!password_verify($current_password, $data['user']['password'])) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
Wrong current password !
  </div>');
        redirect('user/password');
      } else {
        //cek apakah password lama dan password baru sama karena ga boleh
        if ($current_password == $new_password) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
new password cannot be the same as current password !
  </div>');
          redirect('user/password');
        } else {
          //passwod sudah ok
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
password change!
  </div>');
          redirect('user/password');
        }
      }
    }
  }
}
