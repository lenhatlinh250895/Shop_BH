<ul class="nav">
  <li class="nav-item nav-profile">
    <a href="#" class="nav-link">
      <div class="profile-image">
        <img class="img-xs rounded-circle" src="<?php echo base_url(); ?>public/images/faces/face8.jpg" alt="profile image">
        <div class="dot-indicator bg-success"></div>
      </div>
      <div class="text-wrapper">
        <p class="profile-name">Allen Moreno</p>
        <p class="designation">Administrator</p>
      </div>
      <div class="icon-container">
        <i class="icon-bubbles"></i>
        <div class="dot-indicator bg-danger"></div>
      </div>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
      <span class="menu-title">Admin</span>
      <i class="icon-layers menu-icon"></i>
    </a>
    <div class="collapse" id="ui-basic">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Admin'); ?>">List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Admin/add'); ?>">Add</a></li>
      </ul>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#i-basic" aria-expanded="false" aria-controls="ui-basic">
      <span class="menu-title">Catalog</span>
      <i class="icon-layers menu-icon"></i>
    </a>
    <div class="collapse" id="i-basic">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Catalog'); ?>">List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Catalog/add'); ?>">Add</a></li>
      </ul>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#product" aria-expanded="false" aria-controls="ui-basic">
      <span class="menu-title">Product</span>
      <i class="icon-layers menu-icon"></i>
    </a>
    <div class="collapse" id="product">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Product'); ?>">List</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo admin_url('Product/add'); ?>">Add</a></li>
      </ul>
    </div>
  </li>
</ul>