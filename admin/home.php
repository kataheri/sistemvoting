<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <!-- Small boxes (Stat box) -->
      <div class="d-flex">
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM positions";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>Total Posisi</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="positions.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM `group`";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>Total Kelompok</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="group.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM president";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
          
              <p>Total Kandidat A</p>
            </div>
            <div class="icon">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="candidates.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>    
        <!-- ./col -->
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM candidates";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
              <p>Total Kandidat B</p>
            </div>
            <div class="icon">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="president.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM voters";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
             
              <p>Total Voters</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="voters.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-6 col-md-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM votes GROUP BY voters_id";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>Total Voters telah Voting</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <a href="votes.php" class="small-box-footer">Selengkapnya.. <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div> 
      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

</body>
</html>
