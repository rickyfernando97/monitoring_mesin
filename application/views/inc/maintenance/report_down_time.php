          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <select id="filterMesin" class="form-control input-lg">
                  <option value="">All</option>
                  <?php
                    foreach ($mesin as $k) {
                      echo '<option value="'.$k->id_mesin.'">'.$k->kode_mesin.' - '.$k->nama_mesin.'</div>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                 <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" id="filterTanggal" class="form-control input-lg" value="<?php echo date('d/m/Y') ?>">
                </div>
              </div>
            </div>
            <div class="col-md-3">
             <div class="form-group">
                <button id="buttonTampilkan" class="btn btn-default form-control input-lg">Tampilkan</button>
              </div>
            </div>
            <div class="col-md-3">
             <div class="form-group">
                <button id="buttonCetak" class="btn btn-default form-control input-lg">Cetak</button>
              </div>
            </div>
          </div>

          <div class="row">
            <table id="tableData" class="display" width="100%" cellspacing="0">
              <thead>
                  <tr>
                      <th>Tanggal</th>
                      <th>Batch</th>
                      <th>Kode Mesin</th>
                      <th>Jam Mulai</th>
                      <th>Jam Selesai</th>
                      <th>Kendala</th>
                      <th>Lama</th>
                      <th>Ket</th>
                      <th>Kategori</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th>Tanggal</th>
                      <th>Batch</th>
                      <th>Kode Mesin</th>
                      <th>Jam Mulai</th>
                      <th>Jam Selesai</th>
                      <th>Kendala</th>
                      <th>Lama</th>
                      <th>Ket</th>
                      <th>Kategori</th>
                  </tr>
              </tfoot>
          </table>
          </div>


          <script src="<?php echo $this->config->item('base_media') ?>plugins/datepicker/bootstrap-datepicker.js"></script>
          <script src="<?php echo $this->config->item('base_media') ?>plugins/datepicker/locales/bootstrap-datepicker.id.js"></script>
          <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>plugins/datepicker/datepicker3.css">

          <script src="<?php echo $this->config->item('base_media') ?>plugins/datatables/jquery.dataTables.min.js"></script>
          <script src="<?php echo $this->config->item('base_media') ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
          <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>plugins/datatables/css/jquery.dataTables.min.css">
          <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>plugins/datatables/css/dataTables.bootstrap.css">
          <script type="text/javascript">
            $(document).ready(function(){
              $('#buttonCetak').click(function(){
                var ajax = $('#tableData').DataTable().ajax;
                var params = jQuery.param(ajax.params());
                var url = '<?php echo site_url() ?>/supervisor/report/cetak_downtime?'+params;
                window.open(url);
              });

              $('#filterTanggal').datepicker({
                format: 'dd/mm/yyyy',
                language: "id" 
              });

              $('#buttonTampilkan').click(function(){
                var ajax = $('#tableData').DataTable().ajax;
                mask_body();
                ajax.reload();
              });

              $('#tableData').on( 'draw.dt', function () {
                  un_mask_body();
              } );

               $('#tableData')
               .on('preXhr.dt', function ( e, settings, data ) {
                    data.id_mesin = $('#filterMesin').val();
                    data.tgl_mulai = $('#filterTanggal').val();
                })
               .DataTable( {
                  ordering: false,
                  paging: false,
                  bFilter: false,
                  bInfo: false,
                  ajax: {
                    url: "<?php echo site_url('supervisor/report/get_downtime') ?>",
                    dataSrc: 'data',
                    data: {},
                    type: 'POST'
                  },
                  columns: [
                    { "data": "tanggal" },
                    { "data": "kode_batch" },
                    { "data": "kode_mesin" },
                    { "data": "jam_mulai" },
                    { "data": "jam_selesai" },
                    { "data": "kode_problem" },
                    {
                      "data": "downtime_duration",
                      "render": function ( data, type, full, meta ) {
                        return data+' Detik';
                      }
                    },
                    { "data": "keterangan_problem" },
                    { "data": "kategori" }
                  ]
              } );
            });
          </script>