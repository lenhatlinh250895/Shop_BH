<div class="page-header">
  <?php $this->load->view('admin/admin/head'); ?>
</div>

<div class="col-md-12 grid-margin stretch-card">
	<div class="card">
	  <div class="card-body">
	    <h4 class="card-title">Horizontal Form</h4>
	    <p class="card-description"> Horizontal form layout </p>
	    <form class="forms-sample" method="post" enctype="multipart/form-data" id="form" action="">
	      <div class="form-group row">
	        <label for="Name" class="col-sm-3 col-form-label">Name</label>
	        <div class="col-sm-9">
	          <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $info->name; ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('name'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="UserName" class="col-sm-3 col-form-label">User Name</label>
	        <div class="col-sm-9">
	          <input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo $info->username; ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('username'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Pass Word</label>
	        <div class="col-sm-9">
	          <input type="password" name="password" class="form-control" placeholder="Pass Word" value="<?php echo set_value('password'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('password'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="RePass" class="col-sm-3 col-form-label">Re Pass</label>
	        <div class="col-sm-9">
	          <input type="password" name="repassword" class="form-control" placeholder="Re Pass" value="<?php echo set_value('repassword'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('repassword'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="Email" class="col-sm-3 col-form-label">Email</label>
	        <div class="col-sm-9">
	          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $info->email; ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('email'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="Level" class="col-sm-3 col-form-label">Level</label>
	        <div class="col-sm-9">
	          <select name="level" class="form-control">
	          	<?php if($info->level == 1): ?>
                <option id="admin" value="1" selected>Admin</option>
                <option id="member" value="0">Member</option>
            	<?php else: ?>
            	<option id="admin" value="1">Admin</option>
                <option id="member" value="0" selected>Member</option>
            	<?php endif ?>
              </select>
	        </div>
	      </div>
	      <div class="form-check form-check-flat form-check-primary">
	        <label class="form-check-label">
	          <input type="checkbox" class="form-check-input"> Remember me </label>
	      </div>
	      <button type="submit" class="btn btn-primary mr-2">Submit</button>
	      <button class="btn btn-light">Cancel</button>
	    </form>
	  </div>
	</div>
</div>