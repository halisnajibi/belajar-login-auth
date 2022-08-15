<div class="container-fluid">
 <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
 <div class="row">
  <div class="col-lg">
   <?= $this->session->flashdata('message'); ?>
   <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
   <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modaladd">Add Sub Menu</a>
   <table class="table table-hover">
    <thead>
     <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Header Menu</th>
      <th scope="col">Url</th>
      <th scope="col">Icon</th>
      <th scope="col">Activetion</th>
      <th scope="col">Action</th>
     </tr>
    </thead>
    <tbody>
     <?php $i = 1;
     foreach ($submenu as $sm) : ?>
      <tr>
       <th scope="row"><?= $i++ ?></th>
       <td><?= $sm['title'] ?></td>
       <td><?= $sm['menu'] ?></td>
       <td><?= $sm['url'] ?></td>
       <td><?= $sm['icon'] ?></td>
       <td>
        <?php if ($sm['is_active'] == 1) {
         echo 'Active';
        } else {
         echo 'Disable';
        } ?>
       </td>
       <td>
        <a href="" class="badge badge-success">edit</a>
        <a href="" class="badge badge-danger">hapus</a>
       </td>
      </tr>
     <?php endforeach ?>
    </tbody>
   </table>
  </div>
 </div>
</div>
</div>


<!-- menu add -->
<!-- Modal -->
<div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <form action="<?= base_url('menu/submenu') ?>" method="post">
    <div class="modal-body">
     <div class="form-group">
      <label for="menu">title</label>
      <input type="text" class="form-control" id="title" name="title">
      <label for="exampleFormControlSelect1">Header Menu</label>
      <select class="form-control" id="exampleFormControlSelect1" name="headmenu">
       <?php foreach ($menu as $m) : ?>
        <option value="<?= $m['id_menu'] ?>"><?= $m['menu'] ?></option>
       <?php endforeach; ?>
      </select>
      <label for="menu">url</label>
      <input type="text" class="form-control" id="url" name="url">
      <label for="menu">icon</label>
      <input type="text" class="form-control" id="icon" name="icon">

     </div>
     <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="customCheck1" name="is_active" value="1" checked>
      <label class="custom-control-label" for="customCheck1">Active</label>
     </div>
    </div>
    <div class="modal-footer">
     <button type="submit" class="btn btn-primary">Save</button>
   </form>
  </div>
 </div>
</div>
</div>