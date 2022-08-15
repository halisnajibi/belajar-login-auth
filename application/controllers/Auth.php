<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/auth_header');
      $this->load->view('auth/login');
      $this->load->view('template/auth_footer');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $password = $this->input->post('password');
    $query = $this->M_auth->login();
    //jika user nya ada
    if ($query != null) {
      //jika usernya aktif
      if ($query['is_active'] == 1) {
        //cek password 
        if (password_verify($password, $query['password'])) {
          //berhasil login
          //siapakn data user untuk di seimpan di halaman user
          $data = [
            'email' => $query['email'],
            'role_id' => $query['role_id']
          ];
          $this->session->set_userdata($data);
          if ($query['role_id'] == 1) {
            redirect('admin');
          } else if ($query['role_id'] == 2) {
            redirect('user');
          }
        } else {
          //password salah & gagal login
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
Wrong Password!
  </div>');
          redirect('auth');
        }
      } else {
        //error akun belum aktif
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
  This Email is not been activeted !
  </div>');
        redirect('auth');
      }
    } else {
      //tidak ada usernya
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
  Email is not resgistered !
  </div>');
      redirect('auth');
    }
  }

  public function resgistrasi()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }
    //cek validasi
    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
      'matches' => 'Password dont match!',
      'min_length' => 'Password too short!'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
    if ($this->form_validation->run() == false) {
      //jika gagal maka tampilkan view dan error
      $this->load->view('template/auth_header');
      $this->load->view('auth/registrasi');
      $this->load->view('template/auth_footer');
    } else {
      //jika berhasil validasi
      $this->M_auth->regInsert();
      //siapkan token
      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' => $this->input->post('email', true),
        'token' => $token,
        'date_created' => time(),
      ];
      $this->db->insert(
        'user_token',
        $user_token
      );
      //kirim email
      $this->_sendEmail($token, 'verify');


      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
 Congratulation! your account has been created. Please activate your account !!
</div>');
      redirect('auth');
    }
  }


  private function _sendEmail($token, $type)
  {

    // EMAIL GATEWAY // 
    $config = [
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'protocol'  => 'smtp',
      'smtp_host' => 'smtp.gmail.com',
      'smtp_user' => 'belajarkirimemailci3@gmail.com',  // Email gmail 
      'smtp_pass'   => 'csyhbwfqohzwtpnu',  // Password gmail 
      'smtp_crypto' => 'ssl',
      'smtp_port'   => 465,
      'crlf'    => "\r\n",
      'newline' => "\r\n"
    ];


    // Load library email dan konfigurasinya 
    $this->load->library('email', $config);

    // Email dan nama pengirim 
    $this->email->from('belajarkirimemailci3@gmail.com', 'admin');

    // Email penerima 
    $this->email->to($this->input->post('email')); // Ganti dengan email tujuan 
    //cek type kegunaan
    if ($type == 'verify') {
      // Subject email 
      $this->email->subject('Account Verification');
      // Isi email 
      $this->email->message('Clik this link to verify you account : <a href= "' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Active</a>');
    } else if ($type == 'forgot') {
      // Subject email 
      $this->email->subject('reset password');
      // Isi email 
      $this->email->message('Clik this link to reset  you password : <a href= "' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
    }
    // Tampilkan pesan sukses atau error 
    if ($this->email->send()) {
      // echo 'Sukses! email berhasil dikirim.';
    } else {
      // echo 'Error! email tidak dapat dikirim.';
    }

    // END EMAIL GATEWAY //
  }

  public function verify()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    //validasi email
    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
      if ($user_token) {
        //cek waktu validasi account
        if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('user');
          $this->db->delete('user_token', ['email' => $email]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
' . $email . ' has been activated! please login.
</div>');
          redirect('auth');
        } else {
          $this->db->delete('user_token', ['email' => $email]);
          $this->db->delete('user', ['email' => $email]);
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
Account activation failed!token expired!!
</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
Account activation failed!wrong token !!
</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
Account activation failed!wrong email !!
</div>');
      redirect('auth');
    }
  }











  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');
    redirect('auth');
  }

  public function block()
  {
    $data['title'] = '404';
    $this->load->view('errors/404', $data);
  }

  public function forgotPassword()
  {
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/auth_header');
      $this->load->view('auth/forgot-password');
      $this->load->view('template/auth_footer');
    } else {
      //berhasil validasi
      $email = $this->input->post('email');
      $user = $this->db->get_Where('user', ['email' => $email, 'is_active' => 1])->row_array();
      if ($user) {
        //jika ada user
        $token = base64_encode(random_bytes(32));
        $user_token = [
          'email' => $email,
          'token' => $token,
          'date_created' => time()
        ];
        $this->db->insert('user_token', $user_token);
        $this->_sendEmail($token, 'forgot');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
please check your email to reset password
</div>');
        redirect('auth/forgotPassword');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
email is not register or active!
</div>');
        redirect('auth/forgotPassword');
      }
    }
  }

  public function resetpassword()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');
    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

      if ($user_token) {
        //jika berhasil validasi
        $this->session->set_userdata('reset_email', $email);
        $this->changepassword();
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
wrong token!
</div>');
        redirect('auth/forgotPassword');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
wrong email!
</div>');
      redirect('auth/forgotPassword');
    }
  }

  public function changepassword()
  {
    if (!$this->session->userdata('reset_email')) {
      redirect('auth');
    }
    $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
    if ($this->form_validation->run() == false) {
      $this->load->view('template/auth_header');
      $this->load->view('auth/changepasswod');
      $this->load->view('template/auth_footer');
    } else {
      $password  = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
      $email = $this->session->userdata('reset_email');
      $this->db->set('password', $password);
      $this->db->where('email', $email);
      $this->db->update('user');
      $this->session->unset_userdata('reset_email');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
Password hash been change !!please login!!
</div>');
      redirect('auth');
    }
  }
}
