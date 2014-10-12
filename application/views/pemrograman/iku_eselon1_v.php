<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun',$renstra,'0','id="iku-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="iku-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="iku-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

 	<div id="iku_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="iku-tbl">
            <thead>
            <tr>
            	<th>Unit Kerja</th>
                <th>No</th>
                <th>Kode</th>
                <th>Indikator Kerja Utama (IKU)</th>                        
                <th>Satuan</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
	</div>
    
<style type="text/css">
	select {width:100%;}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#iku-btn").click(function(){
			tahun = $('#iku-tahun').val();
			kode = $('#iku-kode_e1').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#iku-tahun').select2('open');
			}
			else {
				$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_body_iku/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#iku-tbl tbody');
                            table_body.empty().html(result);        
                            $('#iku_konten').removeClass("hide");
                        }
                });  
			}
		});
		
		 $("#iku-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#iku-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#iku-kode_e1').append(new Option(result[k],k));
						}
						$("#iku-kode_e1").select2("val", "0");
					}
				});
			});
	})
</script>	                              