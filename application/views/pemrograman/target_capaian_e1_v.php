            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="target-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sasaran Strategis</label>
                        <div class="col-md-8">
                            <?=form_dropdown('sasaran',array('0'=>"Pilih Sasaran Strategis"),'','id="target-sasaran" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="target-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
                   
	<div id="target_kl_konten" class="hide">

        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="target-tbl">
            <thead>
            <tr>
                <th rowspan="2" width="3%">No</th>
                <th rowspan="2" width="5%">Kode</th>
                <th rowspan="2" width="40%">Indikator Kerja Utama</th>
                <th rowspan="2">Satuan</th>
                <th colspan="5"><center>Target Capaian</center></th>
            </tr>
            <tr>
                	<th><span id="target-tahun1">-</span></th>
                    <th><span id="target-tahun2">-</span></th>
                    <th><span id="target-tahun3">-</span></th>
                    <th><span id="target-tahun4">-</span></th>
                    <th><span id="target-tahun5">-</span></th>
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
		renstra = $('#target-tahun');
		sasaran = $('#target-sasaran');
		renstra.change(function(){
            if (renstra.val()!="") {
				var arrayrenstra = $('#target-tahun').val().split('-');
                $.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_sasprog/"+arrayrenstra[0]+"/"+arrayrenstra[1],
                    success:function(result) {
                        $('#target-sasaran').empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            $('#target-sasaran').append(new Option(result[k],k));
                        }
                        $('#target-sasaran').select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            }
        });
		$("#target-btn").click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#target-sasaran').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#target-tahun').select2('open');
			}
			else {
				var arrayrenstra = tahun.split('-');
				//alert(arrayrenstra[0]);
				var no = 1;
				for (i = arrayrenstra[0]; i <=arrayrenstra[1]; i++) { 
					$('#target-tahun'+no).html(i);
					no++;
				}
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_body_target/"+tahun+'/'+sasaran,
                        success:function(result) {
                            table_body = $('#target-tbl tbody');
                            table_body.empty().html(result);        
                            $('#target_kl_konten').removeClass("hide");
                        }
                });
			}
		});
	})
	</script>	        