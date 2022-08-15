<?php

function cek_login()
{
 $ci = get_instance();
 //cek belum login
 if (!$ci->session->userdata('email')) {
  redirect('auth');
 } else {
  //cek yg login siapa
  $role_id = $ci->session->userdata('role_id');
  //mengambil data url
  $menu = $ci->uri->segment(1);



  $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
  $menu_id = $queryMenu['id_menu'];
  $user_access = $ci->db->get_where('user_access_menu', [
   'role_id' => $role_id,
   'id_menu' => $menu_id
  ]);

  if ($user_access->num_rows() < 1) {
   redirect('auth/block');
  }
 }

 function check_access($role_id, $id_menu)
 {
  $ci = get_instance();
  $result = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'id_menu' => $id_menu]);
  if ($result->num_rows() > 0) {
   return "checked = 'checked'";
  }
 }
}
