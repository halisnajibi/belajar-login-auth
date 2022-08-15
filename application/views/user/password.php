<div class="container-fluid">
 <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
 <div class="row">
  <div class="col-6">
   <?= $this->session->flashdata('message') ?>
  </div>
 </div>
 <div class="row">
 </div>
 <div class="row">
  <div class="col-6">
   <form action="<?= base_url('user/password') ?>" method="post">
    <div class="form-group">
     <label for="password">Current Password</label>
     <input type="password" class="form-control" id="password" name="current_password">
     <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
    </div>
    <div class="form-group">
     <label for="password">New Password</label>
     <input type="password" class="form-control" id="password" name="new_password1">
     <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
    </div>
    <div class="form-group">
     <label for="password">Repeat Password</label>
     <input type="password" class="form-control" id="password" name="new_password2">
     <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
    </div>
    <div class="form-group">
     <button type="submit" name="" class="btn btn-primary">Simpan</button>
    </div>
   </form>
  </div>
 </div>
</div>
</div>