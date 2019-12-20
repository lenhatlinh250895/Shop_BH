<div class="page-header">
  <?php $this->load->view('admin/admin/head'); ?>
</div>

<div class="col-md-12 grid-margin stretch-card">
	<div class="card">
	  <div class="card-body">
	    <h4 class="card-title">Add Catalog</h4>
	    <p class="card-description">Add Catalog</p>
	    <form class="forms-sample" method="post" enctype="multipart/form-data" id="form" action="">
	      <div class="form-group row">
	        <label for="Name" class="col-sm-3 col-form-label">Name</label>
	        <div class="col-sm-9">
	          <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo set_value('name'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('name'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="UserName" class="col-sm-3 col-form-label">Parent Id</label>
	        <div class="col-sm-9">
	          <select name="parent_id">
	          	<option value="0">Parent</option>
	          	<?php foreach($list as $row): ?>
	          		<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
	          	<?php endforeach ?>
	          </select>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Sort Order</label>
	        <div class="col-sm-9">
	          <input type="text" name="sort_order" class="form-control" placeholder="Sort Order" value="<?php echo set_value('sort_order'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('sort_order'); ?></div>
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