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
                        <button type="button" class="btn btn-info" id="satker-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

<!--main content start-->
	<div class="" id="konten_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
        <table class="display table table-bordered table-striped" id="satker-tbl">
        <thead>
            <tr>
                <th>Tahun Renstra</th>
                <th>Kode Satker</th>
                <th>Nama Satker</th>
                <th>Lokasi</th>
                <th>Unit Kerja</th>
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
		
		 
		 
		$("#satker-btn").click(function(){
			//table_satker.fnDraw();
			alert('herddde');
			 $('#satker-tbl').dataTable({
                "processing": true,
				"serverSide": true,
				"sAjaxSource":"<?=base_url()?>admin/ekstrak_satker/getdata_satker",
					
				 "bDestroy": true,
				  "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
					oSettings.jqXHR = $.ajax({
						url: sSource,
						type: "GET",
						dataType: "json",
						timeout: 0, // prevent timeout
					//	data: aoData,
						complete:function() {
							// Conditional logic goes here for completion
						},
						success: function (json) {
							/* Do whatever additional processing you want on the callback, then tell DataTables */
						//	fnCallback(json)
						}
					});
				},
				"columns": [
					{ "data": "tahun_renstra" },
					{ "data": "kode_satker" },
					{ "data": "nama_satker" },
					{ "data": "lokasi_satker" },
					{ "data": "kode_e1" }
				]
 
           });
		});
		
		
		
		   
		
	});
</script>	   
   