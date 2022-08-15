<?php

class M_admin extends CI_Model
{
 public function getRole()
 {
  return $this->db->get('user_role')->result_array();
 }
 public function getRowRole($id)
 {
  return $this->db->get_where('user_role', ['id' => $id])->row_array();
 }

 public function access($id)
 {
  return $this->db->get_where('user_role', ['id' => $id])->row_array();
 }
}
