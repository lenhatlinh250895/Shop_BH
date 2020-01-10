<div class="page-header">
  <?php $this->load->view('admin/product/head'); ?>
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
	        <label for="UserName" class="col-sm-3 col-form-label">Catalog</label>
	        <div class="col-sm-9">
	          <select name="catalog">
	            <?php foreach($catalogs as $row): ?>
	              <?php if(count($row->subs) > 0): ?>
	                <optgroup label="<?php echo $row->name; ?>">
	                  <?php foreach($row->subs as $sub): ?>
	                    <option value="<?php echo $sub->id; ?>"><?php echo $sub->name; ?></option>
	                  <?php endforeach ?>
	                </optgroup>
	              <?php else: ?>
	                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>}
	              <?php endif ?>
	            <?php endforeach ?>
	          </select>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Price</label>
	        <div class="col-sm-9">
	          <input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo set_value('price'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('price'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Discount</label>
	        <div class="col-sm-9">
	          <input type="text" name="discount" class="form-control" placeholder="Discount" value="<?php echo set_value('discount'); ?>">
	          <div class="clearfix alert-danger" name="nameerror"><?php echo form_error('discount'); ?></div>
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Image Link</label>
	        <div class="col-sm-9">
	          <input type="file" name="imagelink" class="form-control">
	        </div>
	      </div>
	      <div class="form-group row">
	        <label for="PassWord" class="col-sm-3 col-form-label">Image list</label>
	        <div class="col-sm-9">
	          <input type="file" name="imagelist[]" class="form-control" multiple="">
	        </div>
	      </div>
	      <div class="form-check form-check-flat form-check-primary">
	        <label class="form-check-label">
	          <input type="checkbox" class="form-check-input"> Remember me </label>
	      </div>
	      <button type="submit" class="btn btn-primary mr-2">Submit</button>
	      <button type="reset" class="btn btn-light">Cancel</button>
	    </form>
	  </div>
	</div>
</div>