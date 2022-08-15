<?php

class M_user extends CI_Model
{
 public function getAll($session_user)
 {
  return $this->db->get_where('user', ['email' => $session_user])->row_array();
 }

 public function profiel($image = null)
 {
  // $name = $this->input->post('name');
  $data = [
   'name' => $this->input->post('name')
  ];
  $email = $this->input->post('email');
  // $this->db->set('name',$name);
  $this->db->where('email', $email);
  $this->db->update('user', $data);
  if ($image != null) {
   $data = [
    'name' => $this->input->post('name'),
    'image' => $image
   ];
   $this->db->where('email', $email);
   $this->db->update('user', $data);
  }
 }
}
