
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header content-header-default">
    <h1 style="font-size:28px;">
      <?= $data['header_title'] ?>
      <?php if(!empty($data['sub_header_title'])):  ?>
      <small>/ <?= $data['sub_header_title'] ?></small>
      <?php endif; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= site_url('dashboard'); ?>">Home</a></li>
      <li class="active">Jaminan 100 Hari</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?= $this->session->flashdata('flashInfo'); ?>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title text-primary"><strong><i class="fa fa-navicon"></i> <?= $data['sub_header_title'] ?></strong></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div style="margin-bottom:20px;">
          <div class="row">
            <div class="col-md-6">
              &nbsp;
            </div>
            <div class="col-md-6 text-right">
              <button class="btn btn-default" id="btn-reload"><i class="fa fa-refresh"></i> Reload Data</button>
            </div>
          </div>
        </div>

        <table id="data-table" class="table table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>
                <select class="form-control select2" name="filterPerumahan" id="filterPerumahan">
                  <option value="all">All</option>
                  <?php if(!empty($data['perumahan'])): ?>
                    <?php foreach($data['perumahan'] as $row):  ?>
                      <option value="<?= $row->rumah_id ?>"><?= $row->rumah_nama ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
            <tr>
              <th class="dthead dthead-blue">No Booking</th>
              <th class="dthead dthead-blue">Pelanggan</th>
              <th class="dthead dthead-blue">Perumahan</th>
              <th class="dthead dthead-blue">Blok</th>
              <th class="dthead dthead-blue">Tanggal</th>
              <th class="dthead dthead-blue">Expired</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>[No Booking]</th>
              <th>[Pelanggan]</th>
              <th>[Perumahan]</th>
              <th>[Blok]</th>
              <th>[Tanggal]</th>
              <th>[Expired]</th>
            </tr>
          </tfoot>
        </table>
        <div class="panel-keterangan">
          <h4>Keterangan Warna</h4>
          <ul>
            <li><i class="fa fa-square" style="color:#fff !important;"></i> Jaminan</li>
            <li><i class="fa fa-square" style="color:#ffd0cb !important;"></i> Expired</li>
          </ul>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- Modal Informasi Detil  -->
    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-circle-o-right"></i> Informasi Detil Booking</h4>
                </div>
                <div class="modal-body edit-content">
                  <div style="border:1px solid #cfcfcf;padding:10px;">
                    <strong style="margin:0;">KELENGKAPAN</strong>
                  </div>

                  <div class="row" style="margin:10px 0;">
                    dsadasdf
                  </div><!--end row-->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Informasi Detil -->


  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view(PATH_BACKEND.'footer'); ?>
<?php $this->load->view(PATH_BACKEND.'default_js'); ?>

<!-- AdminLTE App -->
<script src="<?= base_url(ASSET_JS."app.min.js"); ?>"></script>
<script src="<?= site_url(ASSET_PLUGIN.'datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url(ASSET_PLUGIN.'datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?= site_url(ASSET_PLUGIN.'sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?= base_url(ASSET_JS."jquery.price_format.2.0.min.js"); ?>"></script>
<script src="<?= site_url(ASSET_PLUGIN.'select2/select2.full.min.js'); ?>"></script>

<script>
    $(window).load(function(){
      $(".select2").select2();
      var rupiah ={prefix: 'Rp. ', thousandsSeparator: '.', centsLimit: 0};
      var perumahan = $( "#filterPerumahan" ).val() || "all";

      loadDt(perumahan);

      $( "#btn-reload" ).click(function() {
        var perumahan = $( "#filterPerumahan" ).val() || "all";

        loadDt(perumahan);

        $("#filterPerumahan").val('all').trigger("change");
      });

      $( "#filterPerumahan" ).change(function() {
        var perumahan = $( "#filterPerumahan" ).val() || "all";

        loadDt(perumahan);
      });

      $(document).on("click","a[id='btn-sudah']", function (e) {
        var id = $(this).attr("data-id");
        var status = $(this).attr("status-id");
        var booking_id = $(this).attr("booking-id");

        swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#55dd87",
          confirmButtonText: "Sudah",
          cancelButtonText: "Tutup",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            swal("Success!", "Sudah diterima.", "success");
            window.location.href = '<?= site_url('transaksi/change_ots_status/'."'+id+'/'+status+'/'+booking_id+'"); ?>';
          } else {
        	    swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
        });

      });

      $(document).on("click","a[id='btn-proses']", function (e) {
        var id = $(this).attr("data-id");
        var status = $(this).attr("status-id");
        var booking_id = $(this).attr("booking-id");

        swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3393f7",
          confirmButtonText: "Proses",
          cancelButtonText: "Tutup",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            swal("Success!", "Sudah diterima.", "success");
            window.location.href = '<?= site_url('transaksi/change_ots_status/'."'+id+'/'+status+'/'+booking_id+'"); ?>';
          } else {
        	    swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
        });

      });

      $(document).on("click","a[id='btn-belum']", function (e) {
        var id = $(this).attr("data-id");
        var status = $(this).attr("status-id");
        var booking_id = $(this).attr("booking-id");

        swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#ec5a5a",
          confirmButtonText: "Belum di Proses",
          cancelButtonText: "Tutup",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            swal("Success!", "Sudah diterima.", "success");
            window.location.href = '<?= site_url('transaksi/change_ots_status/'."'+id+'/'+status+'/'+booking_id+'"); ?>';
          } else {
        	    swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
        });

      });

      function loadDt(perumahan){
        $('#data-table').DataTable({
          "processing": true,
          "serverSide": true,
          "bDestroy" : true,
          "ajax": "<?= site_url('transaksi/get_jaminan_list/'.'"+perumahan+"'); ?>",
          "sServerMethod": "POST",
          "language": {
              "processing": "Sedang memuat data..."
          },
          "searching": true,
          "order": [[ 4, "DESC" ]],
          "columns": [
            { "data": "booking_no", "sortable": true, "searchable": true, name: "booking_no", "width": "8%" },
            { "data": "pelanggan_nama", "sortable": true, "searchable": true, name: "pelanggan_nama" },
            { "data": "rumah_nama", "sortable": true, "searchable": true, name: "rumah_nama" },
            { "data": "kavling_blok", "sortable": true, "searchable": true, name: "kavling_blok", "width": "6%", className: 'text-center' },
            { "data": "jaminan_date", "sortable": true, "searchable": true, name: "jaminan_date","width": "10%" },
            { "data": "jaminan_expired", "sortable": true, "searchable": true, name: "jaminan_expired","width": "10%" }
          ],
          "columnDefs": [
            {
              "render": function ( data, type, row ) {
                return '<strong>'+data+'</strong>';
              },
              "targets": 0 // column index
            },
            {
              "render": function ( data, type, row ) {
                  if(data == '0000-00-00 00:00:00'){
                    return 'Belum diproses';
                  }
                  else{
                    return moment(data).format("DD MMM YYYY")
                  }
              },
              "targets": 4 // column index
            },
            {
              "render": function ( data, type, row ) {
                  if(data == '0000-00-00 00:00:00'){
                    return 'Belum diproses';
                  }
                  else{
                    return moment(data).format("DD MMM YYYY")
                  }
              },
              "targets": 5 // column index
            },

          ],
          "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if(Date.parse(aData['jaminan_date']) >= Date.parse(aData['jaminan_expired'])){
              $(nRow).css('background-color', '#ffd0cb')
            }

          }
        });
      }

    });
</script>
