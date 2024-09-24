<?php
session_start();
error_reporting(0);
include('include/cheklogin.php');
check_login();
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>ADMIN || DASHBOARD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
  </head>
  <body>
		
  <div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/img.png);"></a>
	        <ul class="list-unstyled components mb-5">
            <li>
              <a style="text-align: center; margin-top:-30px"><?php echo $_SESSION['uname'];  ?></a>
	          </li>
            <li  class="active">
	              <a href="header.php">Dashboard</a>
	          </li>
            <li>
                <a href="departmenet.php">Add Department</a>
            </li>
            <li>
                <a href="add-room.php">Manage Room</a>
            </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Doctors</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="add-doctor.php">Add Doctor</a>
                </li>
                <li>
                    <a href="manage-doctor.php">Manage Doctor</a>
                </li>
              </ul>
	          </li>
            <li>
              <a href="#docSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Patient</a>
              <ul class="collapse list-unstyled" id="docSubmenu">
                <li>
                    <a href="view-patient.php">View Patient</a>
                </li>                
              </ul>
	          </li>
            <li>
              <a href="approve.php">Appointment History</a>
	          </li>
            <li>
              <a href="patient-quries.php">Patient Queries</a>
	          </li> 
            <li>
              <a href="#trSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transection</a>
              <ul class="collapse list-unstyled" id="trSubmenu">
                <li>
                    <a href="manage-transection.php">Manage Transection</a>
                </li>                
              </ul>
	          </li>
            <li>
              <a href="#rpSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reprts</a>
              <ul class="collapse list-unstyled" id="rpSubmenu">
                <li>
                    <a href="between-dates-reports.php">B/W Dates Reports</a>
                </li>                
              </ul>
	          </li>
	          <li>
              <a href="search.php">Search</a>
	          </li>
	        	        </ul>
	        <div class="footer pt-5">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="" target="_blank">JUNAID</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>          
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Online Portal for Hospital Out Patient Department (OPD)</a>
                </li>
            </ul>
            </div>
            <a href="logut.php" class="btn btn-o btn-primary">logout</a>
          </div>
        </nav>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
          <h2>ADMIN || User</h2>
        </div> 

        <table class="table md-5">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User Name</th>
      <th scope="col">Father Name</th>
      <th scope="col">Email Address</th>
      <th scope="col">Cell No</th>
      <th scope="col">D-O-B</th>
      <th scope="col">Gender</th>
      <th scope="col">Register Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  $con=mysqli_connect('localhost','root','','opd_final');
    $SelectQuery="SELECT*FROM tblreg WHERE role = 2";
    $john=mysqli_query($con,$SelectQuery);
   while ($show=mysqli_fetch_array($john)) {?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $show['uid']; ?></th>
      <td><?php echo $show['uname']; ?></td>
      <td><?php echo $show['ufname']; ?></td>
      <td><?php echo $show['uemail']; ?></td>
      <td><?php echo $show['ucell']; ?></td>
      <td><?php echo $show['udob']; ?></td>
      <td><?php echo $show['ugender']; ?></td>
      <td><?php echo $show['regDate']; ?></td>
      <td style="cursor:pointer;">
      <a href="user-update.php?userID=<?php echo $show['uid'];?>"><i class="fa fa-edit"></i></a>
      
      </td>
    </tr>
  </tbody>
  <?php }?>
</table>
  
  </div>
  </div>
</div>
</div>
</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
