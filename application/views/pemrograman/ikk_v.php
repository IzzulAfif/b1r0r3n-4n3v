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
                         		<?=form_dropdown('tahun',$renstra,'0','id="ikk-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tahun <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <?=form_dropdown('form-tahun',array("Pilih Tahun"),'','id="form-tahun-ikk"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="ikk-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array("0"=>"Semua Unit Kerja Eselon II"),'','id="ikk-kode_e2" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="ikk-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

                   
                    
 	<div id="ikk_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        
        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="ikk-tbl">
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

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		
		renstra_ikk = $('#ikk-tahun');
		form_tahun_ikk	= $('#form-tahun-ikk');
		
		renstra_ikk.change(function(){
            form_tahun_ikk.empty();
            if (renstra_ikk.val()!=0) {
                year = renstra_ikk.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    form_tahun_ikk.append(new Option(i,i));
                }
                form_tahun_ikk.select2({minimumResultsForSearch: -1, width:'resolve'});
            }
        });
		
		 $("#ikk-tahun").change(function(){
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon2/get_list_eselon1/"+this.value,
					success:function(result) {
						
						$('#ikk-kode_e1').empty();
						result = JSON.parse(result);
						for (k in result) {
							$('#ikk-kode_e1').append(new Option(result[k],k));
						}
						$("#ikk-kode_e1").select2("val", "0");
						$("#ikk-kode_e1").change();
					}
				});
			}); 
			
			
		$("#ikk-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>laporan/renstra_eselon2/get_list_eselon2/"+$("#ikk-tahun").val()+"/"+this.value,
				success:function(result) {
					kode_e2=$("#ikk-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
					kode_e2.select2("val", "0");
				}
			});
		});
		$("#ikk-btn").click(function(){
			tahun = $('#ikk-tahun').val();
			kode_e1 = $('#ikk-kode_e1').val();
			kode_e2 = $('#ikk-kode_e2').val();
			tahun2 = $('#form-tahun-ikk').val();
			
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#ikk-tahun').select2('open');
			}
			else if (kode_e1=="0") {
				alert("Unit Kerja Eselon I belum ditentukan");
				$('#ikk-kode_e1').select2('open');
			}
			else {
				$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_body_ikk/"+tahun2+"/"+kode_e1+"/"+kode_e2,
                        success:function(result) {
                            table_body = $('#ikk-tbl tbody');
                            table_body.empty().html(result);        
                            $('#ikk_konten').removeClass("hide");
                        }
                });  
			}
		});
	})
</script>	                                                            