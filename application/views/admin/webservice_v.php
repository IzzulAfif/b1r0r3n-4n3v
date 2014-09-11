<!--main content start-->
	
    <div id="bodytable" class="">
    
        <br />
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="webservice-tbl">
            <thead>
            <tr>
                <th>Aplikasi</th>
                <th>Jenis Data</th>
                <th>Url</th>
                <th width="10%">Aksi</th>
            </tr>
            </thead>
            <tbody></tbody>
            </table>
        </div>
	
    </div>
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="webservice-modal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="webservice_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="webservice_title"></h5>
                </div>
                <div class="modal-body" id="webservice_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btn-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btn-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<style type="text/css">
	select {width:100%;}
</style>
<script>
$(document).ready(function(){
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tipe_aplikasi" },					
					  { "mData": "jenis_data" },					
					  { "mData": "url" },					
					  { "mData": "aksi", "sWidth": "100px" }
					];
					
	load_ajax_datatable2('webservice-tbl','<?=base_url()?>admin/webservice/get_tables',columsDef,1,'desc');
	
	webservice_edit =function(id){
		$("#webservice_title").html('<i class="fa fa-pencil"></i> Update Web Service');
		$("#webservice_form").attr("action",'<?=base_url()?>admin/webservice/update');
		$('#webservice_konten').html("");
		$.ajax({
			url:'<?=base_url()?>admin/webservice/edit/'+id,
				success:function(result) {
					$('#webservice_konten').html(result);
				}
		});
	}
	
	
	$( "#webservice_form" ).submit(function( event ) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
			$.ajax({
				url : formURL,
				type: "POST",
				data : postData,
				success:function(data, textStatus, jqXHR) 
				{
					//data: return data from server
					$.gritter.add({text: data});
					//renstra_update();
					$('#btn-close').click();
					//$("#id-btn").click();
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
					$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
					$('#btn-close').click();
				}
			});
		  event.preventDefault();
	});
	
	
	
	});
</script>	