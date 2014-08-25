<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Data Eselon II
                        <span class="pull-right">
                            <a href="<?=base_url()?>unit_kerja/eselon2/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="panel-body">
                    
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
                    </div>
                </section>
            </div>
        </div>
        </section>
    </section>
    <!--main content end-->
    
    <script>
		$(document).ready(function(){
			load_ajax_datatable('table_e2','<?=base_url()?>unit_kerja/eselon2/load_data_e2');
		});
	</script>