
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
      <li class="active">LPA</li>
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
              <th></th>
              <th></th>
              <th>
                <select class="form-control select2" name="filterPerumahan" id="filterPerumahan" style="font-size:12px;width:200px !important">
                  <option value="all">All</option>
                  <?php if(!empty($data['perumahan'])): ?>
                    <?php foreach($data['perumahan'] as $row):  ?>
                      <option value="<?= $row->rumah_id ?>"><?= $row->rumah_nama ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </th>
              <th></th>
            </tr>
            <tr>
              <th class="dthead dthead-blue">Action</th>
              <th class="dthead dthead-blue">No Booking</th>
              <th class="dthead dthead-blue">No LPA</th>
              <th class="dthead dthead-blue">Pelanggan</th>
              <th class="dthead dthead-blue">Perumahan</th>
              <th class="dthead dthead-blue">Blok</th>
              <th class="dthead dthead-blue">Tanggal</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>[Action]</th>
              <th>[No Booking]</th>
              <th>[No LPA]</th>
              <th>[Pelanggan]</th>
              <th>[Perumahan]</th>
              <th>[Blok]</th>
              <th>[Tanggal]</th>
            </tr>
          </tfoot>
        </table>

      </div><!-- /.box-body -->
    </div><!-- /.box -->

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
      var status = $( "#filterStatus" ).val() || "all";

      loadDt(perumahan, status);

      $( "#btn-reload" ).click(function() {
        var perumahan = $( "#filterPerumahan" ).val() || "all";
        var status = $( "#filterStatus" ).val() || "all";

        loadDt(perumahan, status);

        $("#filterPerumahan").val('all').trigger("change");
        $("#filterStatus").val('all').trigger("change");
      });

      $( "#filterPerumahan" ).change(function() {
        var perumahan = $( "#filterPerumahan" ).val() || "all";
        var status = $( "#filterStatus" ).val() || "all";

        loadDt(perumahan, status);
      });

      $( "#filterStatus" ).change(function() {
        var perumahan = $( "#filterPerumahan" ).val() || "all";
        var status = $( "#filterStatus" ).val() || "all";

        loadDt(perumahan, status);
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

      function loadDt(perumahan, status){
        $('#data-table').DataTable({
          "processing": true,
          "serverSide": true,
          "bDestroy" : true,
          "ajax": "<?= site_url('transaksi/get_lpa_list/'.'"+perumahan+"/"+status+"'); ?>",
          "sServerMethod": "POST",
          "language": {
              "processing": "Sedang memuat data..."
          },
          "searching": true,
          "order": [[ 0, "DESC" ]],
          "columns": [
            { "data": "lpa_id", "width": "8%", name: "lpa_id", "searchable": false, "sortable": false, className: 'text-center'},
            { "data": "booking_no", "sortable": true, "searchable": true, name: "booking_no", "width": "11%" },
            { "data": "lpa_no", "sortable": true, "searchable": true, name: "lpa_no", "width": "15%" },
            { "data": "pelanggan_nama", "sortable": true, "searchable": true, name: "pelanggan_nama" },
            { "data": "rumah_nama", "sortable": true, "searchable": true, name: "rumah_nama" },
            { "data": "kavling_blok", "sortable": true, "searchable": true, name: "kavling_blok", "width": "6%", className: 'text-center' },
            { "data": "lpa_date", "sortable": true, "searchable": true, name: "lpa_date","width": "10%" }
          ],
          "columnDefs": [
            {
              "render": function ( data, type, row ) {
                return '<div class="btn-group">'+
                       '<a class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></a>'+
                       '<ul class="dropdown-menu" role="menu">'+
                       '<li><a href="<?= site_url('dashboard/admin/transaksi/lpa/dokument/'."'+row.lpa_id+'"); ?>" target="_blank" title="Print" id="btn-print"><span class="fa fa-print"></span> Print</a></li>'+
                       '</ul></div>';

              },
              "targets": 0 // column index
            },
            {
              "render": function ( data, type, row ) {
                return '<strong>'+data+'</strong>';
              },
              "targets": 1 // column index
            },
            {
              "render": function ( data, type, row ) {
                return '<strong>'+data+'</strong>';
              },
              "targets": 2 // column index
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
              "targets": 6 // column index
            },

          ],
        });
      }

    });
</script>
