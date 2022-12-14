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
         <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
        </div>
        <?= $this->session->flashdata('message') ?>
        <form class="user" action="<?= base_url('auth') ?>" method="POST">
         <div class="form-group">
          <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" value="<?= set_value('email') ?>">
          <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
         </div>
         <div class="form-group">
          <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
          <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
         </div>
         <button type="submit" name="login" class="btn btn-primary btn-user btn-block"> Login</button>

        </form>
        <hr>
        <div class="text-center">
         <a class="small" href="<?= base_url('auth/forgotPassword') ?>">Forgot Password?</a>
        </div>
        <div class="text-center">
         <a class="small" href="<?= base_url('auth/resgistrasi') ?>">Create an Account!</a>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>

  </div>

 </div>

</div>