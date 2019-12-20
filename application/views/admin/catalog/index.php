<div class="page-header">
  <?php $this->load->view('admin/admin/head'); ?>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Table Admin</h4><nav class="breadcrumb">Total:<?php echo $total; ?></nav>
        <?php $this->load->view('admin/message'); ?>
        <div id="alert" class="alert alert-success" style="display: none;"></div>
        <div class="table-responsive" id="showalluser">
          <table class="table table-striped table-bordered border">
            <thead>
              <tr>
                <th> ID </th>
                <th> NAME </th>
                <th> PARENT ID </th>
                <th> SORT ORDER </th>
                <th> DELETE </th>
                <th> UPDATE </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($list as $row): ?>
              <tr>
                <td class="py-1">
                  <?php echo $row->id; ?>
                </td>
                <td><?php echo $row->name; ?> </td>
                <td><?php echo $row->parent_id; ?></td>
                <td><?php echo $row->sort_order; ?></td>
                <td><a href="<?php echo admin_url('Catalog/delete/'.$row->id); ?>" class="btn btn-danger" id="btndel" data="$row->id">Delete</a></td>
                <td><a href="<?php echo admin_url('Catalog/edit/'.$row->id); ?>" class="btn btn-success">Update</a></td>
              </tr>
            <?php endforeach ?>
            </tbody>
          </table>
         
        </div>
        <div class="pagi pagination clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="mymodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mess_succ" id="message"></div>
        <div class="mess_error" id="message"></div>
        <form action="" method="post" id="myform" class="form-sample" enctype="multipart/form-data">
          <input type="hidden" name="id" value="0">
          <div class="alert alert-danger" id="alert" style="display: none;">
  
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" required="true" class="form-control" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" name="username" class="form-control" placeholder="User Name">
          </div>
          <div class="form-group">
            <label for="password">Pass Word</label>
            <input type="password" name="password" class="form-control" placeholder="Pass Word">
          </div>
          <div class="repas form-group">
            <label for="repassword">Re-Pass</label>
            <input type="password" name="repassword" class="form-control" placeholder="Re Pass">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="level">Level</label>
            <select name="level" class="form-control">
              <option id="admin" value="1" selected>Admin</option>
              <option id="member" value="0">Member</option>}
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnsave" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<!-- <script>
  $(document).ready(function(){

    function showData(page)
    {
      $.ajax({
        url: "<?php echo base_url(); ?>admin/Admin/loadData/"+page,
        type: "post",
        dataType: "json",
        success: function(data){
          console.log(data.page);
          $('#showalluser').html(data.html);
          $('.pagi').html(data.pagination);
        }
      });
    }
    showData(1);

    $('#btnadd').on('click',function(){
      $('#myform')[0].reset();
      $('#mymodal').modal('show');
      $('#mymodal').find('.modal-title').text('Add Admin');
      $('#myform').attr('action','<?php echo base_url(); ?>admin/Admin/addAdmin');
    });
    $('#btnsave').on('click',function(){
      var url = $('#myform').attr('action');
      var form_data = new FormData(document.getElementById('myform'));
      console.log(form_data);
      $.ajax({
        type: 'post',
        url: url,
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response){
          console.log(response);
          $('#mymodal').modal('hide');
          $('#myform')[0].reset();
          $('#alert').html(response).fadeIn().delay(4000).fadeOut('slow');
          showData();
        }
      });
    });

    $('#showalluser').on('click','#btndel',function(){
      var id = $(this).attr('data');
      console.log(id);
      $.ajax({
        type: 'post',
        data: {id : id},
        url: '<?php echo base_url(); ?>admin/Admin/deleteUser',
        dataType: 'json',
        success: function(response){
          console.log(response);
          if(response == 1)
          {
            alert("Delete User Successfully!");
            showData();
          }
          else
            alert("Delete User Error!")
        }
      });
    });

    $('#showalluser').on('click','#btnupdate',function(){
      $('#mymodal').modal('show');
      $('#mymodal').find('.modal-title').text('Update User');
      $('#myform').attr('action','<?php echo base_url(); ?>admin/Admin/updateAdmin');
      $('input[name=username]').attr('readonly','true');
      var id = $(this).attr('data');
      console.log(id);
      $('.repas').hide();
      $.ajax({
        type: 'post',
        data: {id: id},
        url: '<?php echo base_url(); ?>admin/Admin/edit',
        dataType: 'json',
        success: function(data){
          console.log(data);
          $('input[name=name]').val(data.name);
          $('input[name=username]').val(data.username);
          $('input[name=email]').val(data.email);
          if(data.level == 0)
          {
            $('#admin').removeAttr('selected');
            $('#member').attr('selected','true');
          }
          else
          {
            $('#member').removeAttr('selected');
            $('#admin').attr('selected','true');
          }
        }
      });
    });

  });
</script> -->