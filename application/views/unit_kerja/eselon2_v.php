<!--main content start-->
<div class="panel-body">
 <header class="panel-heading">
	Identitas dan Tugas Pokok Eselon II
	<span class="pull-right">
		 <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
	 </span>
</header>
                    <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="table_e2">
                    <thead>
                        <tr>
                            <th width="30%">Eselon I</th>
                            <th>Kode Unit Kerja</th>
                            <th>Nama Unit Kerja</th>
                            <th>Singkatan</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    </table>
                    </div>
                   
    <!--main content end-->
    
    <script>
		$(document).ready(function(){
			load_ajax_datatable('table_e2','<?=base_url()?>unit_kerja/eselon2/load_data_e2');
		});
	</script>