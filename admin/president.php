<?php include 'includes/session.php'; ?>
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
       Daftar Kandidat Presiden
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kandidat Presiden</li>
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
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Tambah Kandidat</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Posisi</th>
                  <th>Foto</th>
                  <th>Nama Lengkap</th>
                  <th>Platform</th>
                  <th>Opsi</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, positions.description as jabatan, president.id AS presid 
                    FROM president 
                    LEFT JOIN positions ON positions.id=president.position_id
                    ORDER BY positions.priority ASC";

                    $query = $conn->query($sql);
                    
                    while($row = $query->fetch_assoc()){
                      $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';              

                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$row['jabatan']."</td>
                          <td>
                            <img src='".$image."' width='30px' height='30px'>
                            <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='".$row['presid']."'></a>
                          </td>
                          <td>".$row['fullname']."</td>
                          <td><a href='#platform' data-toggle='modal' class='btn btn-info btn-sm btn-flat platform' data-id='".$row['presid']."'><i class='fa fa-search'></i> Lihat</a></td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['presid']."'><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['presid']."'><i class='fa fa-trash'></i> Hapus</button>
                          </td>
                        </tr>
                      ";
                    }

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/president_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.platform', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id) {
  $.ajax({
    type: 'POST',
    url: 'president_row.php',
    data: { id: id },
    dataType: 'json',
    success: function(response) {
      // set url image 
      var url = window.location.href; //full url yang sekarang sedang aktif
      var urlBaru = url.replace('president.php', '');
      var urlFix = urlBaru.replace('/admin', '');

      $('.id').val(response.presid);
      $('#edit_fullname').val(response.fullname);
      $('#posselect').val(response.position_id).html(response.jabatan);      
      $('#edit_platform').val(response.platform);
      $('.fullname').html(response.fullname);
      // Mengganti karakter newline (\n) dengan tag <br> untuk menampilkan platform dengan spasi
      $('#desc').html(response.platform.replace(/\n/g, '<br>'));
      $('#photo_candidate').attr('src', urlFix + 'images/' + response.photo);
    }
  });
}

</script>
</body>
</html>
