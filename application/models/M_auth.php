<?php

class M_auth extends CI_Model
{

 public function regInsert()
 {
  $email = $this->input->post('email', true);
  $data = [
   'name' => htmlspecialchars($this->input->post('name', true)),
   'email' => htmlspecialchars($email),
   'image' => 'default.jpg',
   'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
   'role_id' => 2,
   'is_active' => 0,
   'date_created' => time()
  ];

  $this->db->insert('user', $data);
 }

 public function login()
 {
  $email = $this->input->post('email');
  $password = $this->input->post('password');
  return $this->db->get_where('user', ['email' => $email])->row_array();
 }
}
