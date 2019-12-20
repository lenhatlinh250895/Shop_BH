<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view($head); ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <?php $this->load->view('admin/header'); ?>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <?php $this->load->view('admin/sidebar') ?>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <?php $this->load->view($temp); ?>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <?php $this->load->view('admin/footer'); ?>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php $this->load->view($script); ?>
  </body>
</html>