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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="fungsi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="fungsi-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e2',array("0"=>"Pilih Unit Kerja Eselon II"),'0','id="fungsi-kode_e2" class="populate"  style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="fungsi-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
<!--main content start-->

	<div class="hide" id="fungsi_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#fungsiModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="fungsiAdd();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
		<table  class="display table table-bordered table-striped" id="fungsi-tbl">
		<thead>
		<tr>
			<th>Kode</th>
			<th>Fungsi</th>
			
			<th width="10%">Aksi</th>
		</tr>
		</thead>
		<tbody>
		
		</tbody>
		</table>
		</div>
   </div>
   
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="fungsiModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="fungsi-form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="fungsi_title_form"></h5>
                </div>
                <div class="modal-body" id="fungsi_form_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnf-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnf-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#fungsi-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#fungsi-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		
		$("#fungsi-btn").click(function(){
			tahun = $('#fungsi-tahun').val();
			kode = $('#fungsi-kode_e1').val();
			kode2 = $('#fungsi-kode_e2').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_body_fungsi/"+tahun+"/"+kode+"/"+kode2,
                        success:function(result) {
                            table_body = $('#fungsi-tbl tbody');
                            table_body.empty().html(result);        
                            $('#fungsi_es2').removeClass("hide");
                        }
                });  
		});
		
		fungsiAdd =function(){
			$("#fungsi_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Fungsi Eselon II');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/save');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/add/fungsi',
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		fungsiEdit = function(tahun,kode){
			$("#fungsi_title_form").html('<i class="fa fa-pencil"></i>  Update Fungsi Eselon II');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/update');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/edit/fungsi/'+tahun+'/'+kode,
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		 fungsiDelete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
		
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>unit_kerja/eselon2/hapus/fungsi/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#fungsi-btn").click();
						}
				});
			}
		}
		
		$( "#fungsi-form" ).submit(function( event ) {
			 var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax(
				{
					url : formURL,
					type: "POST",
					data : postData,
					success:function(data, textStatus, jqXHR) 
					{
						//data: return data from server
						$.gritter.add({text: data});
						$("#btnf-close").click();
						$("#fungsi-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails   
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btnf-close').click();   
					}
				});
			
			  event.preventDefault();
		});
	});
</script>	

    
    <!--main content end-->
    
    