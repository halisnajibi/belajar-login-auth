<div class="container-fluid">
 <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
 <div class="ro">
  <div class="col-lg-8">
   <form action="<?= base_url('user/edit') ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
     <label for="email">Email</label>
     <input type="text" class="form-control" id="email" name="email" readonly value="<?= $user['email'] ?>">

    </div>
    <div class="form-group">
     <label for="name">Full Name</label>
     <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
     <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
    </div>
    <div class=" row">
     <div class="col-3">
      <img src="<?= base_url('assets/img/profiel/') . $user['image'] ?>" alt="" class="img-thumbnail" width="100">
     </div>
     <div class="col-9">
      <div class="custom-file">
       <input type="file" class="custom-file-input" id="image" name="image">
       <label class="custom-file-label" for="image">Choose file</label>
      </div>
     </div>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary  mt-3">simpan</button>
   </form>
  </div>
 </div>
</div>
</div>