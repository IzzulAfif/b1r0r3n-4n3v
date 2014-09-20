	<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
                <section class="panel">
                    <header class="panel-heading tab-bg-light tab-right ">
                        <p class="pull-left"><b>Informasi Kegiatan Pembangunan Bidang Transportasi</b></p>
                        <span class="pull-right">
                          
                         </span>
                    </header>
                    <div class="panel-body">
    <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
							 <?=form_dropdown('tahun_renstra',$tahun_renstra,'0','id="tahun_renstra"')?>
                        </div>
                    </div>
                  
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Kelompok Indikator</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="kelompok_indikator" class="populate"')?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-9">
                        	 <?=form_dropdown('kode_e1',$eselon1,'0','id="kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-9">
                        	 <?=form_dropdown('kode_e2',array(),'0','id="kode_e2" class="populate"')?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Lokasi</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kdlokasi',$lokasi,'0','id="list-kdlokasi" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="list-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                        
                </form>
            </div>
        </section>
    </div>
	</div>
		<div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <p class="text-primary">Daftar Detil Belanja</p><br />
                <table  class="display table table-bordered table-striped" id="list-tbl">
                	<thead>
                    	<tr>
                    		<th>No</th>
                            <th>Tahun</th>
                            <th>Nama Kegiatan</th>
                            <th>Volume</th>
                            <th>Harga Satuan</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
					 <tbody>
					 </tbody>
    	        </table>
                </div>
                </section>
            </div>
        </section>
    </section>
    
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
    <!--js-->
    <script type="text/javascript">
    $(document).ready(function () {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$('#tahun_renstra').change(function(){
			tahun	= $('#tahun_renstra').val();
			$.ajax({
				url:"<?=site_url()?>laporan/kegiatan_pembangunan/get_sastra/"+tahun,
				success:function(result) {
					$('#kelompok_indikator').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#kelompok_indikator').append(new Option(result[a],a));
					}
					$('#kelompok_indikator').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		
		$("#kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>laporan/kegiatan_pembangunan/get_list_eselon2/"+this.value,
				success:function(result) {
					
					$('#kode_e2').empty();					
					result = JSON.parse(result);
					for (k in result) {
						$('#kode_e2').append(new Option(result[k],k));
					}
				}
			});
		});
		
		$('#list-lokasi').change(function(){
			$('#box-result').removeClass("hide");
		});
		
		
		$("#list-btn").click(function(){
			tahun = $('#tahun_renstra').val();
			indikator = $('#kelompok_indikator').val();
			kode_e1 = $('#kode_e1').val();
			kode_e2 = $('#kode_e2').val();
			lokasi = $('#list-kdlokasi').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>laporan/kegiatan_pembangunan/get_list_rincian/"+tahun+"/"+indikator+"/"+kode_e1+"/"+kode_e2+"/"+lokasi,
                        success:function(result) {
                            table_body = $('#list-tbl tbody');
                            table_body.empty().html(result);        
                            $('#box-result').removeClass("hide");
                        }
                });  
		});
    });
    </script>
    <!--js-->