<div class="modal fade" id="verify">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Verifikasi (mohon isi dengan sebenar-benarnya)</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="verify.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Nomor Induk Kependudukan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="voter" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Simpan</button>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verifikasi NIK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="voter">NIK:</label>
                            <input type="text" class="form-control" id="voter" name="voter" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="verify">Verifikasi Username</button>
                    </form>
                </div>
            </div>
        </div>
</div> -->
