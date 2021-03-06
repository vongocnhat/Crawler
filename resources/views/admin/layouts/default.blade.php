<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>SB Admin - Start Bootstrap Template</title>
<base href="{{ asset('/') }}">
<!-- Bootstrap core CSS-->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom fonts for this template-->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Page level plugin CSS-->
<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<!-- Custom styles for this template-->
<link href="css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="styles/nhat.css">
@yield('css')
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="">Start Bootstrap</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav nhat-menus" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DetailWebsite">
          <a class="nav-link" href="{{ URL::to('/') }}">
           <i class="fas fa-home"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="KeyWord">
          <a class="nav-link" href="{{ route('keyword.index') }}">
             <i class="fas fa-table"></i>
            <span class="nav-link-text">KeyWord</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Website">
          <a class="nav-link" href="{{ route('website.index') }}">
            <i class="fas fa-table"></i>
            <span class="nav-link-text">Website</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DetailWebsite">
          <a class="nav-link" href="{{ route('detailwebsite.index') }}">
           <i class="fas fa-table"></i>
            <span class="nav-link-text">DetailWebsite</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="RSS">
          <a class="nav-link" href="{{ route('rss.index') }}">
          <i class="fas fa-table"></i>
            <span class="nav-link-text">RSS</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Content">
          <a class="nav-link" href="{{ route('content.index') }}">
           <i class="fas fa-table"></i>
            <span class="nav-link-text">Content</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Video Tag">
          <a class="nav-link" href="{{ route('videotag.edit', ['id' => 0]) }}">
            <i class="fas fa-table"></i>
            <span class="nav-link-text">Video Tag</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Trang Lấy Tin">
          <a class="nav-link" href="{{ route('getRSS') }}" target="_blank">
          <i class="fas fa-table"></i>
            <span class="nav-link-text">Trang Lấy Tin</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Trang Trộm Tin">
          <a class="nav-link" href="{{ route('getCrawler') }}" target="_blank">
          <i class="fas fa-table"></i>
            <span class="nav-link-text">Trang Trộm Tin</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li>
        <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
<div class="content-wrapper">
  <div class="container-fluid">
    @yield('content')
  </div>
</div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright © Your Website 2018</small>
      </div>
    </div>
  </footer>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
  <!-- Custom scripts for this page-->
  <script src="js/sb-admin-datatables.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script defer src="styles/nhat.js"></script>
  <script type="text/javascript">
    //active menu
    function activeMenu() {
      var currentUrl = window.location.href;
      var urlMenu;
      $('.nhat-menus .nav-link').each(function() {
        urlMenu = $(this).attr('href');
        if(currentUrl == urlMenu || currentUrl == urlMenu + '/create')
        {
          $(this).parent().addClass('active');
          return false;
        }
      });
    }
    activeMenu();
  </script>

  @yield('script')
  <script type="text/javascript">
    $('#dataTable').dataTable( {
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
    }],
    "lengthMenu": [[10, 50, 100, 500, -1], [10, 50, 100, 500, "All"]]
    } );
  </script>
  <script type="text/javascript">
    //delete multi
    $('.thCbDelete').click(function() {
      $('.tdCbDelete').prop('checked', $(this).is(':checked'));
    });
    $('.tdCbActive').click(function() {
      var text = $(this).is(':checked') ? ' Yes' : ' No';
      $(this).siblings('span').text(text);
    });
  </script>
</div>
</body>

</html>