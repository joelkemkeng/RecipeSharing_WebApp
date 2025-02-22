<?php
  session_start();
  require_once(__DIR__ . '/../functions.php');
  $conn = getDatabaseConnection();

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://15.188.49.243/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  if(isset($_POST['restore_true'])){ 
    $Category_ID = $_POST['category_id'];
    restoredata($Category_ID);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SimpleSweets Recipe Sharing Application</title>
  <link rel="icon" type="image/jpg" href="http://15.188.49.243/RecipeSharing_WebApp/RecipeHomepage/cookielogo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Pacifico&family=Russo+One&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://15.188.49.243/RecipeSharing_WebApp/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://15.188.49.243/RecipeSharing_WebApp/assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php require(__DIR__ . '/../navbar.php'); ?>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-dark">
    <!-- Brand Logo -->
    <?php require(__DIR__ . '/../headlogo_sidebar.php'); ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="http://15.188.49.243/RecipeSharing_WebApp/assets/dist/img/Idpic.png" class="img-circle img-fluid img-bordered-sm" style="width: 60px;" alt="User Image" >
        </div>
        <div class="info">
        <h5 class="text-wrap"><b><?php echo $_SESSION['user_name']; ?></b></h5>
        <form action="" method="post">
        <h6 class="m-0"><a href="http://15.188.49.243/RecipeSharing_WebApp/admin/updateprofile.php?user_id=<?php echo htmlentities($_SESSION['userID']); ?>" class="link h7 mr-1" title="Edit Profile"><i class="bi bi-person-lines-fill h5 border rounded px-1"></i></a><span class="badge border border-secondary text-uppercase" style="vertical-align: top; color:#a07b4a"> <?php echo htmlentities($_SESSION['user_role']); ?></span></h6>
        </form>
      </div>
    </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
              <li class="nav-item">
                <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/dashboard.php" class="nav-link">
                <i class="nav-icon bi bi-columns-gap"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon bi bi-person-circle" style= "font-size: 20px;"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/add_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>
             <li class="nav-item menu-open">
                <a href="#" class="nav-link active bg-orange">
                <i class="nav-icon bi bi-journals"></i>
                  <p>Bake Recipe Categories
                  <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/rcp_category.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>Manage Categories</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/add_category.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="http://15.188.49.243/RecipeSharing_WebApp/admin/archive_category.php" class="nav-link active bg-gray">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Archived Categories</p>
                    </a>
                  </li>
               </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!------------------------------- Content Wrapper. Contains page content ------------------------------->
  <div class="content-wrapper bg-gradient-dark">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php" class="text-warning">Home</a></li>
              <li class="breadcrumb-item"><a href="rcp_category.php" class="text-warning">Manage Categories</a></li>
              <li class="breadcrumb-item active text-white-50">Archived Categories</li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Archived Categories</b></h1>
          </div>
        </div>
        <hr class="bg-gray pt-1 mt-2 mb-2">
      </div><!-- /.container-fluid -->
    </section>
<!-- --------------------------------LIST START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!-- left column -->
          <div class="col">
          <div class="container">
          <?php require(__DIR__ . '/../alert.php'); ?>
          </div>
            <div class="card">
            <div class="card-header bg-dark px-4 d-flex justify-content-start align-items-center">
                <h6 class="card-title mr-0" style="font-size: 23px;">Categories</h6>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <?php
                  $start = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                  $rowsper_page = 10;
                  // Page load
                  $result = retrieve_alldata2archive($start, $rowsper_page);
                  // Calculate total number of pages for all categories
                  $query = $conn->prepare("SELECT COUNT(*) as total_num FROM rcp_categories WHERE Status = 'Archived'");
                  $query->execute();
                  $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];

                  $num_of_pages = ceil($totalnum_records / $rowsper_page);
                  if(empty($result)){
                    echo"<h5 class='text-danger d-flex justify-content-center py-2'><strong>Sorry, no result found.</strong></h5>";
                  } else{
                    ?>
                    <table class="table table-black text-nowrap">
                    <thead>
                      <tr class="text-dark">
                        <th class="px-4">Category Name</th>
                        <th class="px-4">Category Criteria</th>
                        <th class="px-5">Number of Recipes</th>
                        <th class="px-4">Date Created</th>
                        <th class="px-4">Date Updated</th>
                        <th class="px-3">Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-dark">
                      <?php
                       if (isset($result) && !empty($result)){
                        foreach($result as $key => $row){
                          $created_at = new DateTime($row['Date_Created']);
                          $f_created_at = $created_at->format('m/d/Y h:i:s');
                          $updated_at = new DateTime($row['Date_Updated']);
                          $f_updated_at = $updated_at->format('m/d/Y h:i:s');
                          echo'<tr class="align-items-center">';
                          echo'<td class="px-4">'.$row['Category_Name'].'</td>';
                          echo'<td class="px-4">'.$row['Category_Criteria'].'</td>';
                          echo'<td class="px-5 text-center">'.$row['Num_of_Recipes'].'</td>';
                          echo'<td class="px-4">'.$f_created_at.'</td>';
                          echo'<td class="px-4">'.$f_updated_at.'</td>';
                          echo'<td class="px-4 py-2">';
                          echo'<form action="" method="post">';
                          echo '<input type="hidden" name="category_name" value="'.htmlentities($row['Category_Name']).'">';
                          echo'<button type="submit" value="'.htmlentities($row['Category_ID']).'" name="restore" class="btn btn-link btn-sm text-success data-bs-toggle="modal"  data-bs-target="#exampleModal" title="Restore Category" style="padding:0.1rem; padding-bottom: 0.1px; border: none;"><h4><i class="bi bi-arrow-repeat"></h5></i></button>';
                          echo'</form>';
                        }
                        // Display modal confirmation dialog
                        if(isset($_POST['restore'])){
                          $restoreCategoryId = $_POST['restore'];
                          $Category_Name = $_POST['category_name'];
                          echo '<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; bottom: 0; left: 0; right: 0;">
                          <div class="modal-dialog modal-dialog-centered" role="modal" style="margin: auto;max-width: 480px;">
                              <div class="modal-content">
                                  <div class="modal-header bg-dark py-2">
                                      <h4 class="modal-title" id="exampleModalLabel">Restore Confirmation</h4>
                                      <button type="button" class="btn-close col-sm-1 p-0" data-bs-dismiss="modal" style="background-color: transparent; color:white; font-size:22px; padding: 3px; margin: 0px;"aria-label="Close">&times;</button>
                                  </div>
                                  <div class="modal-body col text-wrap">
                                      <p>Are you sure you want to restore this "'.$Category_Name.'" recipe category?</p>
                                  </div>
                                  <div class="modal-footer py-1">
                                  <form id="deleteForm" action="" method="post">
                                        <input type="hidden" name="category_id" id="deleteCategoryID" value="'.htmlentities($restoreCategoryId).'">
                                        <button type="submit" name="restore_true" value="1" class="btn btn-success col-6">Restore</button>
                                        <button type="button" class="btn btn-outline-info btn-close col-6"  data-bs-dismiss="modal">Cancel</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                        </div>';
                        }
                      }  
                    }
                  ?>
                  </td></tr> 
                </tbody>
              </table>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer border rounded-bottom pb-0" aria-label="Page navigation example">
              <p class="text-muted float-left justify-content-start pt-2"><?php if($num_of_pages > 0){echo'Showing '.$start.' of '.$num_of_pages.' pages';} else{echo 'No pages to show';} ?></p>
              <ul class="pagination justify-content-end mb-2">
                <li class="page-item <?php if($start <= 1){ echo 'disabled'; } ?>">
                  <a class="page-link text-bold" href="?page=<?php echo $start - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&lsaquo;</span>
                  </a>
                </li>
                <?php for($i = 1; $i <= $num_of_pages; $i++): ?>
                  <li class="page-item <?php if($start == $i){ echo 'active'; } ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?php if($start >= $num_of_pages){ echo 'disabled'; } ?>">
                  <a class="page-link text-bold" href="?page=<?php echo $start + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&rsaquo;</span>
                  </a>
                </li>
              </ul>
            </div>
            </div>
          </div>
        </div>
      </section>
      <script>
        const exampleModal = document.getElementById('exampleModal');
        if (exampleModal) {
          // Closes the modal when clicking the cancel or x button
          const closeButton = exampleModal.querySelector('.btn-close');
          const cancelButton = exampleModal.querySelector('.btn.btn-outline-info.btn-close');
          closeButton.addEventListener('click', () => closeModal());
          cancelButton.addEventListener('click', () => closeModal());

          function closeModal(){
            exampleModal.classList.remove('show');
            exampleModal.setAttribute('aria-hidden', 'true');
            exampleModal.setAttribute('style', 'display: none;');
          }
        }
        // Delete Specifier (Category_ID)
        document.querySelectorAll('button[name="delete_true"]').forEach(button =>{
          button.addEventListener('click', function(){
            const userId = this.target.value;
            document.getElementById('deleteCategoryID').value = userId;
          });
        });
      </script>
  <!-- Control Sidebar -->
  <br>
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php require(__DIR__ . '/../footer_page.php'); ?>
  
<!-- jQuery -->
<script src="http://15.188.49.243/RecipeSharing_WebApp/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="http://15.188.49.243/RecipeSharing_WebApp/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="http://15.188.49.243/RecipeSharing_WebApp/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="http://15.188.49.243/RecipeSharing_WebApp/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://15.188.49.243/RecipeSharing_WebApp/assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
