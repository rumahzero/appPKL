
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
      <li class="active">RAB</li>
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
              <a href="<?= site_url('dashboard/owner/rab/add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
            </tr>
            <tr>
              <th class="dthead dthead-blue">Action</th>
              <th class="dthead dthead-blue">RAB</th>
              <th class="dthead dthead-blue">Created</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>[Action]</th>
              <th>[RAB]</th>
              <th>[Created]</th>
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

<script>
    $(window).load(function(){

      loadDt();

      $( "#btn-reload" ).click(function() {
        loadDt();
      });

        $(document).on("click","a[id='btn-delete']", function (e) {
        var id = $(this).attr("data-id");

        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this imaginary file!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel plx!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            swal("Success!", "Sudah diterima.", "success");
            window.location.href = '<?= site_url('dashboard/owner/rab/delete/'."'+id+'"); ?>';
          } else {
        	    swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
        });

      });


      function loadDt(){
        $('#data-table').DataTable({
          "processing": true,
          "serverSide": true,
          "bDestroy" : true,
          "ajax": "<?= site_url('rab/get_list_data/'); ?>",
          "sServerMethod": "POST",
          "language": {
              "processing": "Sedang memuat data..."
          },
          "searching": true,
          "order": [[ 0, "DESC" ]],
          "columns": [
            { "data": "rab_id", "width": "2%", name: "rab_id", "searchable": false, "sortable": false, className: 'text-center'},
            { "data": "rab_nama", "sortable": true, "searchable": true, name: "rab_nama" },
            { "data": "rab_created", "sortable": true, "searchable": true, name: "rab_created","width": "18%" }
          ],
          "columnDefs": [
            {
              "render": function ( data, type, row ) {
                return '<div class="btn-group">'+
                       '<a class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></a>'+
                       '<ul class="dropdown-menu" role="menu">'+
                       '<li><a href="<?= site_url('dashboard/owner/rab/edit/'."'+row.rab_id+'") ?>" title="Edit"><span class="fa fa-pencil"></span> Edit</a></li>'+
                       '<li class="divider"></li>' +
                       '<li><a href="javascript:void(0)" data-id="'+row.rab_id+'" title="Delete" id="btn-delete"><span class="fa fa-trash-o text-red"></span> Delete</a></li>'+
                       '</ul></div>';

              },
              "targets": 0 // column index
            },
            {
              "render": function ( data, type, row ) {
                  if(data == '0000-00-00 00:00:00'){
                    return 'Belum diproses';
                  }
                  else{
                    return moment(data).format("DD MMM YYYY hh:mm:ss a")
                  }
              },
              "targets": 2 // column index
            },

          ],
        });
      }

    });
</script>
