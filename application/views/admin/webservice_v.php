<!--main content start-->
	
    <div id="bodytable" class="">
    
        <br />
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="webservice-tbl">
            <thead>
            <tr>
                <th >Aplikasi</th>
                <th >Jenis Data</th>
                <th >Url</th>
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
                		<button type="button" id="btn-close-webservice" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
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
					  { "mData": "tipe_aplikasi", "aaTargets":[0],"sWidth": "200px","bSortable": true },					
					  { "mData": "jenis_data","sWidth": "200px","bSortable": false  },					
					  { "mData": "url","sWidth": "350px","bSortable": false  },					
					  { "mData": "aksi", "sWidth": "100px","bSortable": false  },
					  { "mData": "urutan", "aaTargets":[4], "sWidth": "100px","bSortable": true,"bVisible":false}
					];
					
	//load_ajax_datatable2('webservice-tbl','<?=base_url()?>admin/webservice/get_tables',columsDef,4,'asc');
	
	$('#webservice-tbl').dataTable
	({
		"iDisplayStart ": 0,
		"iDisplayLength" : 10, //jumlah default data yang ditampilkan
		"aLengthMenu" : [5,10,25,50,100], //isi combo box menampilkan jumlah data
		"aaSorting" : [[0,'asc'],[4,'asc']], //index kolom yg akan di-sorting
		"bProcessing" : true, //show tulisan dan loading bar
		'bServerSide' : true, //ajax server side
		'sAjaxSource' : '<?=base_url()?>admin/webservice/get_tables', //url ajax nya
		"sAjaxDataProp": "data",
		"sServerMethod" : "POST",
		"bDestroy": true,
		 "aoColumns":columsDef,
		"bJQueryUI":true,	
		"scrollX": true	,
		"sDom": 'rt<"top"lpi>',	//mengatur posisi toolbar  cek http://legacy.datatables.net/usage/options#sDom
		 
		'fnServerData' : function(sSource, aoData, fnCallback)
						{
							//alert(aoData);
							$.ajax
							({
								'dataType': 'json',
								'type' : 'POST',
								'url' : sSource,
								'data' : aoData,
								'success' : function(json){
										fnCallback(json);
										$(".pop_over").popover();
								}
							});
						}
	}); 
	
	
	
	
	
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
				//	$("#webservice-tbl").DataTable().ajax.reload();
					$("#webservice-tbl").DataTable().fnDraw();
				//load_ajax_datatable2('webservice-tbl','<?=base_url()?>admin/webservice/get_tables',columsDef,1,'desc');
					//renstra_update();
					$('#btn-close-webservice').click();
					//$("#id-btn").click();
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
					$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
					$('#btn-close-webservice').click();
				}
			});
		  event.preventDefault();
	});
	
	
	
	});
</script>	