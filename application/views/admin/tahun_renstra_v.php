<!--main content start-->
	
    <div id="bodytable" class="">
    
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#fModal" data-toggle="modal" class="btn btn-primary btn-sm" onclick="tahun_add();" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="tahun-tbl">
            <thead>
            <tr>
                <th>Tahun Renstra</th>
                <th width="10%">Aksi</th>
            </tr>
            </thead>
            <tbody></tbody>
            </table>
        </div>
	
    </div>
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="fModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="tahun_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="tahun_title"></h5>
                </div>
                <div class="modal-body" id="tahun_konten">
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
		
	load_ajax_datatable('tahun-tbl','<?=base_url()?>admin/tahun_renstra/get_tables');
	tahun_add =function(){
		$("#tahun_title").html('<i class="fa fa-plus-square"></i> Tambah Tahun Renstra');
		$("#tahun_form").attr("action",'<?=base_url()?>admin/tahun_renstra/save');
		$.ajax({
			url:'<?=base_url()?>admin/tahun_renstra/add',
				success:function(result) {
					$('#tahun_konten').html(result);
				}
		});
	}
	tahun_edit =function(tahun,kode){
		$("#tahun_title").html('<i class="fa fa-pencil"></i> Update Tahun Renstra');
		$("#tahun_form").attr("action",'<?=base_url()?>admin/tahun_renstra/update');
		$('#tahun_konten').html("");
		$.ajax({
			url:'<?=base_url()?>admin/tahun_renstra/edit/'+tahun,
				success:function(result) {
					$('#tahun_konten').html(result);
				}
		});
	}
	tahun_delete = function(tahun,kode){
		var confir = confirm("Anda yakin akan menghapus data ini ?");
		
		if(confir==true){
			$.ajax({
				url:'<?=base_url()?>admin/tahun_renstra/hapus/id/'+tahun+'/'+kode,
					success:function(result) {
						$.gritter.add({text: result});
						$("#id-btn").click();
					}
			});
		}
	}
	
	$( "#tahun_form" ).submit(function( event ) {
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
	
	renstra_update = function(){
		$.ajax({
			url:"<?=site_url()?>admin/tahun_renstra/get_renstra",
			success:function(result) {
				$('#id-tahun').empty();
				result = JSON.parse(result);
				for (a in result) {
					$('#id-tahun').append(new Option(result[a],result[a]));
				}
				$('#id-tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
			}
		});
	}
	
	});
</script>	