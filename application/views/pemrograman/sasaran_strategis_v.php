
            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="sastra-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-6">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="sastra-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="sastra-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>                  
                   
 	<div id="ss_kl_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="sastra-tbl">
            <thead>
            <tr>
            	<th width="3%">No</th>
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
		
		
		$("#sastra-btn").click(function(){
			tahun = $('#sastra-tahun').val();
			kode = $('#sastra-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_sastra/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#sastra-tbl tbody');
                            table_body.empty().html(result);        
                            $('#ss_kl_konten').removeClass("hide");
                        }
                });  
		});
	
	})
</script>	                
               