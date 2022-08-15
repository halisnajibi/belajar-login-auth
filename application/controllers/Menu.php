<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login();
  }
  public function index()
  {
    $session_user = $this->session->userdata('email');
    $data['title'] = 'Menu Management';
    $data['user'] = $this->M_user->getAll($session_user);
    $data['menu'] = $this->M_menu->getAllMenu();

    $this->form_validation->set_rules('menu', 'Menu', 'required');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/header', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('template/footer');
    } else {
      $this->M_menu->insertMenu();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
New Menu Add
  </div>');
      redirect('menu');
    }
  }


  public function subMenu()
  {
    $session_user = $this->session->userdata('email');
    $data['title'] = 'Sub Menu Management';
    $data['user'] = $this->M_user->getAll($session_user);
    $data['submenu'] = $this->M_menu->getAllSubMenu();
    $data['menu'] = $this->M_menu->getAllMenu();

    //silahkan jalankan validasi disini tp nda kulir
    $this->form_validation->set_rules('title', 'title', 'required');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/header', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('template/footer');
    } else {
      $this->M_menu->insertSubMenu();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
New Sub Menu Add
  </div>');
      redirect('menu/submenu');
    }
  }
}
