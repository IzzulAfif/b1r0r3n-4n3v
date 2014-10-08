            
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
                        <label class="col-md-2 control-label">Sasaran</label>
                        <div class="col-md-6">
                            <?=form_dropdown('sasaran',array(),'','id="sasaran" class="populate" style="width:100%"')?>
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
                <th rowspan="2">No</th>
                <th rowspan="2">Kode</th>
                <th rowspan="2">Indikator Kerja Utama</th>
                <th rowspan="2">Satuan</th>
                <th colspan="5">Target Capaian</th>
            </tr>
            <tr>
            	<th>2010</th>
                <th>2011</th>
                <th>2012</th>
                <th>2013</th>
                <th>2014</th>
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
		sasaran = $('#sasaran');
		renstra.change(function(){
            sasaran.empty();
            if (renstra.val()!=0) {
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/sasaran_strategis/get_sasaran/"+renstra.val(),
                    success:function(result) {
                        sasaran.empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            sasaran.append(new Option(result[k],k));
                        }
                        sasaran.select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            }
        });
		$("#target-btn").click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#sasaran').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_target/"+tahun+'/'+sasaran,
                        success:function(result) {
                            table_body = $('#target-tbl tbody');
                            table_body.empty().html(result);        
                            $('#target_kl_konten').removeClass("hide");
                        }
                });  
		});
	})
	</script>	        