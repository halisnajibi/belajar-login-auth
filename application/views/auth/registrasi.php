 <div class="container">
  <div class="row">
   <div class="col-7 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
     <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
       <div class="col-lg">
        <div class="p-5">
         <div class="text-center">
          <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
         </div>

         <form class="user" method="POST" action="<?= base_url('auth/resgistrasi') ?>">
          <div class="form-group">
           <input type="text" class="form-control form-control-user" placeholder="Full Name" name="name" value="<?= set_value('name') ?>">
           <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group">
           <input type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" value="<?= set_value('email') ?>">
           <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class=" form-group row">
           <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password1">
            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
           </div>
           <div class="col-sm-6">
            <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="password2">
           </div>
          </div>
          <button type="submit" name="resgistrasi" class="btn btn-primary btn-user btn-block"> Register Account</button>
          <hr>
         </form>
         <div class="text-center">
          <a class="small" href="<?= base_url('auth/forgotPassword') ?>">Forgot Password?</a>
         </div>
         <div class="text-center">
          <a class="small" href="<?= base_url('auth') ?>">Already have an account? Login!</a>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>

  </div>
 </div>