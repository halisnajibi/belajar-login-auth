<div class="container">

 <!-- Outer Row -->
 <div class="row justify-content-center">

  <div class="col-7">

   <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
     <!-- Nested Row within Card Body -->
     <div class="row">
      <div class="col">
       <div class="p-5">
        <div class="text-center">
         <h1 class="h4 text-gray-900 mb-4">Chnage your password ?</h1>
         <p><?= $this->session->userdata('reset_email') ?></p>
        </div>
        <?= $this->session->flashdata('message') ?>
        <form class="user" action="<?= base_url('auth/changepassword') ?>" method="POST">
         <div class="form-group">
          <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter new password..." name="password1">
          <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
         </div>
         <div class="form-group">
          <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Repet password..." name="password2">
          <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
         </div>
         <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Change Password</button>
        </form>
        <hr>

       </div>
      </div>
     </div>
    </div>
   </div>

  </div>

 </div>

</div>