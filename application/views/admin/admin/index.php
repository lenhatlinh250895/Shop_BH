<div class="page-header">
  <?php $this->load->view('admin/admin/head'); ?>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Table Admin</h4><nav class="breadcrumb">Total:<?php echo $total; ?></nav>
        <?php $this->load->view('admin/message'); ?>
        <div>
          <form action="" method="post" id="search_parent">
            <table>
              <tr>
                <th>ID</th>
                <td><input type="text" id="id" value=""></td>
              </tr>
              <tr>
                <th>EMAIL</th>
                <td><input type="text" id="email" value=""></td>
              </tr>
              <tr>
                <th>NAME</th>
                <td><input type="text" id="name" value=""></td>
              </tr>
            </table>
            <div>
              <button type="submit" class="btn btn-secondary" id="btn_search">Search</button>
            </div>
          </form>
        </div>
        <div class="table-responsive" id="showalluser">
          <table class="table table-striped table-bordered border">
            <thead>
              <tr>
                <th> ID </th>
                <th> NAME </th>
                <th> USER NAME </th>
                <th> EMAIL </th>
                <th> LEVEL </th>
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
                <td><?php echo $row->username; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->level; ?></td>
                <td><a href="" class="btn btn-danger verify_action" id="btndel" data-id="<?php echo $row->id; ?>">Delete</a></td>
                <td><a href="<?php echo admin_url('Admin/edit/'.$row->id); ?>" class="btn btn-success">Update</a></td>
              </tr>
            <?php endforeach ?>
            </tbody>
          </table>
         
        </div>
        <div class="pagination clearfix">
          <?php echo $pagination; ?>
        </div>
        <input type="hidden" name="this_page" id="this_page">
        <input type="hidden" name="last_page" id="last_page">
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','#btndel',function(e){
    e.preventDefault();
    var id = $(this).data('id');
    user_remove(id);
    // if(!confirm('Are you sure?'))
    //   return false;
  });

  function user_remove(id)
  {
    //console.log(id);
     swal({
      title: 'Bạn có chắc chắn muốn xóa?',
      text: 'Không thể hoàn tác!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Vâng, Xóa đê!',
      cancelButtonText: 'Hủy bỏ',
      showLoaderOnConfirm: true,
      preConfirm: function() {
        return new Promise(function(resolve,reject) {
          //alert(11);
          $.ajax({
            url: '<?= admin_url(); ?>Admin/removeUserAjax',
            type: 'POST',
            data: 'delete='+id,
            dataType: 'json'
          })
          .done(function(response){
            //alert(11);
            console.log(response);
            swal('Đã xóa!', response.message, response.status);
            setTimeout(location.reload.bind(location), 1500);
          })
          .fail(function(){
            //alert(11);
            swal('Oops...', 'Xóa thất bại!', 'error');
          });
        });
      }
    });

  }

  $('#search_parent').submit(function(even){
    even.preventDefault();
    var id = $('#id').val();
    var email = $('#email').val();
    var name = $('#name').val();
    //console.log(id,email,name);
    $.ajax({
      url: '<?= admin_url(); ?>Admin/search',
      data: {
        id : id,
        email : email,
        name : name
      },
      type: 'POST',
      //dataType: 'json',
      success: function(data)
      {
        console.log(data.data_pagination);
        var obj = JSON.parse(data);
        // console.log(obj);
        $('.table').html(obj.data_html);
        $('.pagination').html(obj.data_pagination);
        $('#this_page').val(obj.data_this_page);
        $('#last_page').val(obj.data_total_rows);
        rewrite_onclick();
      }
    });
  });

  function clicknext()
  {
    var pageSearch = $('#this_page').val();
    ++pageSearch;
    F_pageSearch(pageSearch);
  }

  function clickprev()
  {
    var pageSearch = $('#this_page').val();
    --pageSearch;
    F_pageSearch(pageSearch);
  }

  function rewrite_onclick(){
    $('.pagclick').each(function() {
      var thisa = $(this);
      var childa = thisa.find('a');
      //alert(childa.html());
      childa.attr('href','javascript:void(0)');
      childa.attr('onclick','F_pageSearch('+childa.html()+');');
    });
    $('.next').each(function(){
      var thisa = $(this);
      var childa = thisa.find('a');
      childa.attr('href','javascript:void(0)');
      childa.attr('onclick','clicknext();');
    });
    $('.prev').each(function(){
      var thisa = $(this);
      var childa = thisa.find('a');
      childa.attr('href','javascript:void(0)');
      childa.attr('onclick','clickprev();');
    });
    $('.last').each(function(){
      var thisa = $(this);
      var childa = thisa.find('a');
      var last_page = $('#last_page').val();
      childa.attr('href','javascript:void(0)');
      childa.attr('onclick','F_pageSearch('+last_page+');');
    });
    $('.first').each(function(){
      var thisa = $(this);
      var childa = thisa.find('a');
      childa.attr('href','javascript:void(0)');
      childa.attr('onclick','F_pageSearch(1);');
    });
  }

  function F_pageSearch(pageSearch){
    var id = $('#id').val();
    var email = $('#email').val();
    var name = $('#name').val();
    $.ajax({
      url: '<?=admin_url()?>Admin/search/'+pageSearch,
      data: {
        id : id,
        email : email,
        name : name
      },
      type: 'post',
      success: function(data){
        var obj = JSON.parse(data);
        $('.table').html(obj.data_html);
        $('.pagination').html(obj.data_pagination);
        $('#this_page').val(obj.data_this_page);
        $('#last_page').val(obj.data_total_rows);
        rewrite_onclick();
      }
    });
  }
</script>
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