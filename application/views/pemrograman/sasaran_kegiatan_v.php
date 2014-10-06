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
                         		<?=form_dropdown('tahun',$renstra,'0','id="sasaran-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="sasaran-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array(),'','id="sasaran-kode_e2" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="sasaran-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
                  
 	<div id="sk_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="sasaran-tbl">
            <thead>
            <tr>	
            	<th>Unit Kerja</th>
                <th>No</th>
                <th>Kode</th>
                <th>Sasaran Strategis</th>
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
		$("#sasaran-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#sasaran-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		$("#sasaran-btn").click(function(){
			tahun = $('#sasaran-tahun').val();
			kode_e1 = $('#sasaran-kode_e1').val();
			kode_e2 = $('#sasaran-kode_e2').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_body_sasaran/"+tahun+"/"+kode_e1+"/"+kode_e2,
                        success:function(result) {
                            table_body = $('#sasaran-tbl tbody');
                            table_body.empty().html(result);        
                         	$('#sk_konten').removeClass("hide");   
                        }
                });  
		});
	})
</script>	                                             