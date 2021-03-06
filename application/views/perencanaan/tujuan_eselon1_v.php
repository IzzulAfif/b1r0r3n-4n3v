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
                         		<?=form_dropdown('tahun',$renstra,'0','id="tujuan-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="tujuan-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="tujuan-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
    
    <div id="tujuan_es1_konten" class="hide">

    	<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#tujuanModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="tujuan_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
    
        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="tujuan-tbl">
        <thead>
        <tr>
        	<th>Unit Kerja</th>
            <th>No</th>
            <th>Kode</th>
            <th>Tujuan</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>
	
    </div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="tujuanModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="tujuan_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="tujuan_title"></h5>
                </div>
                <div class="modal-body" id="tujuan_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btntujuan-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btntujuan-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<style type="text/css">
	select {width:100%;}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#tujuan-btn").click(function(){
			tahun = $('#tujuan-tahun').val();
			kode = $('#tujuan-kode_e1').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#tujuan-tahun').select2('open');
			}
			else {
				$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_eselon1/get_body_tujuan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#tujuan-tbl tbody');
                            table_body.empty().html(result);        
                         	$('#tujuan_es1_konten').removeClass("hide");   
                        }
                });  
			}
		});
		 $("#tujuan-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#tujuan-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#tujuan-kode_e1').append(new Option(result[k],k));
						}
						$("#tujuan-kode_e1").select2("val", "0");
					}
				});
			});
		
		tujuan_add =function(){
			$("#tujuan_title").html('<i class="fa fa-plus-square"></i> Tambah Tujuan Eselon I');
			$("#tujuan_form").attr("action",'<?=base_url()?>perencanaan/rencana_eselon1/save/tujuan');
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_eselon1/add/tujuan',
					success:function(result) {
						$('#tujuan_konten').html(result);
					}
			});
		}
		tujuan_edit =function(tahun,kode){
			$("#tujuan_title").html('<i class="fa fa-pencil"></i> Edit Tujuan Eselon I');
			$("#tujuan_form").attr("action",'<?=base_url()?>perencanaan/rencana_eselon1/update');
			$('#tujuan_konten').html("");
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_eselon1/edit/tujuan/'+tahun+'/'+kode,
					success:function(result) {
						$('#tujuan_konten').html(result);
					}
			});
		}
		tujuan_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>perencanaan/rencana_eselon1/hapus/tujuan/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#tujuan-btn").click();
						}
				});
			}
		}
		$("#tujuan_form").submit(function( event ) {
			var tahun 	= $('#form-e1-tahun-tujuan').val();
			var kl		= $('#form-e1-tujuan').val();
			var kdt		= $('#form-e1-kode-tujuan').val();
			var tujuan	= $('#form-e1-data-tujuan').val();
			
			if(tahun==""){
				alert("Periode Renstra belum ditentukan");
				return false;
			}else if(kl==""){
				alert("Nama unit kerja belum ditentukan");
				return false;
			}else if(kdt==""){
				alert("Kode Tujuan belum ditentukan");
				return false;
			}else if(tujuan==""){
				alert("Tujuan belum ditentukan");
				return false;
			}else{
				
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
							$('#btntujuan-close').click();
							$("#tujuan-btn").click();
						},
						error: function(jqXHR, textStatus, errorThrown) 
						{
							//if fails
							$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
							$('#btntujuan-close').click();
						}
					});
				  event.preventDefault();
			}
		});
	})
</script>	
               