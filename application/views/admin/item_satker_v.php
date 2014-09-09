<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="id-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="id-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="id-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

<!--main content start-->
	<div class="hide" id="konten_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
        <table class="display table table-bordered table-striped" id="item_satker-tbl">
        <thead>
            <tr>
                
                <th>Tahun</th>
                <th>Kode Satker</th>
                <th>Nama Item</th>
            </tr>
        </thead>
        <tbody>
        
            
        
        </tbody>
        </table>
        </div>
	</div>                   
    <!--main content end-->
 <script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#id-btn").click(function(){
			tahun = $('#id-tahun').val();
			kode = $('#id-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_body_identitas/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#id-tbl tbody');
                            table_body.empty().html(result);        
                            $('#konten_es2').removeClass("hide");
                        }
                });  
		});
		
		
		 $('#item_satker-tbl').dataTable({
                "processing": true,
				"serverSide": true,
				"scrollY":        "200px",
				"scrollCollapse": true,
				"ajax": "<?=base_url()?>admin/ekstrak_item_satker/getdata_itemsatker",
				"columns": [
					{ "data": "tahun" },
					{ "data": "kode_satker" },
					{ "data": "nm_item" }
				]
 
           });
		   
		   
	});
</script>	   
   