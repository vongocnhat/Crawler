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
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Crawler Admin</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DetailWebsite">
          <a class="nav-link" href="http://localhost:10080/Nhom2/public/detail">
           <i class="fas fa-file-alt"></i>
            <span class="nav-link-text">DetailWebsite</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="KeyWord">
          <a class="nav-link" href="http://localhost:10080/Nhom2/public/keyword">
             <i class="fas fa-trademark"></i>
            <span class="nav-link-text">KeyWord</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Website">
          <a class="nav-link" href="http://localhost:10080/Nhom2/public/website">
        <i class="fas fa-globe"></i>
            <span class="nav-link-text">Website</span>
          </a>
        </li>   
      </ul>    
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header card-header-padding">
         
          <a class="nav-link" href="http://localhost:10080/Nhom2/public/website/create">
             <button><i class="fas fa-globe"></i>
            <span class="nav-link-text"></span>
            
               Create
             </button>
          </a>
          
        <div class="card-body card-body-padding">

          <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>DomainName</th>
                  <th>Menutag</th>
                  <th>NumberPage</th>
                  <th>LimitofOnePage</th>
                  <th>StingfirtPage</th>
                  <th>StringlastPage</th>
                  <th>Active</th>
                   <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>DomainName</th>
                  <th>Menutag</th>
                  <th>NumberPage</th>
                  <th>LimitofOnePage</th>
                  <th>StingfirstPage</th>
                  <th>StringlastPage</th>
                  <th>Active</th>
                   <th>Update</th>
                  <th>Delete</th>
          </td>
                </tr>
              </tfoot>
              <tbody>
                @foreach($website_data as $data)
                <tr>
                  <td>{{ $data->ID }}</td>
                  <td>{{ $data->DomainName }}</td>
                  <td>{{ $data->MenuTag }}</td>
                  <td>{{ $data->NumberPage }}</td>
                  <td>{{ $data->LimitOfOnePage }}</td>
                  <td>{{ $data->StringFirstPage }}</td>
                  <td>{{ $data->StringLastPage }}</td>
                  <td>{{ $data->Active }}</td>
                  <td><a href="" class="btn btn-info">UPDATE...</a>
          </td>
          <td>
          
          <td>
{!! Form::open(['method' => 'DELETE', 'route' => ['website.destroy', 'website' => $data->ID]]) !!}
{{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Website Có tên: $data->DomainName , Id: $data->ID ?')"]) }}
{!! Form::close() !!}

{{-- {!! Form::open(['method' => 'DELETE', 'route' => ['website.destroy', 'website' => $data->ID]])!!}
{{ Form::submit('Xóa', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Website Có tên: $data->DomainName , Id: $data->ID ?')"]) }}
{!! Form::close()!!} --}}
            </td>
         
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
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
    <script src="jquery/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  </div>
</body>

</html>
