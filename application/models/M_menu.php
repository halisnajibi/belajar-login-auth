<?php

class M_menu extends CI_Model
{
 public function getAllMenu()
 {
  return $this->db->get('user_menu')->result_array();
 }

 public function getAllSubMenu()
 {
  $this->db->select('*');
  $this->db->from('user_menu');
  $this->db->join('user_sub_menu', 'user_sub_menu.id_menu = user_menu.id_menu');
  return $this->db->get()->result_array();
 }

 public function insertMenu()
 {
  $data = [
   'menu' => $this->input->post('menu', true)
  ];
  $this->db->insert('user_menu', $data);
 }

 public function insertSubMenu()
 {
  $data = [
   'id_menu' => $this->input->post('headmenu', true),
   'title' => $this->input->post('title', true),
   'url' => $this->input->post('url', true),
   'icon' => $this->input->post('icon', true),
   'is_active' => $this->input->post('is_active', true),
  ];
  $this->db->insert('user_sub_menu', $data);
 }
}
