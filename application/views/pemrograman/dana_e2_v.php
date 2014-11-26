            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="dana-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="dana-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array("Pilih Unit Kerja Eselon II"),'','id="dana-kode_e2" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="dana-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
                   
	<div id="dana_kl_konten" class="hide">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#keuanganE2Modal" data-toggle="modal" onclick="keuangane2_Add();" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        
        <br />
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="dana-tbl">
                <thead>
                <tr>
                	<th rowspan="2">No</th>
                    <th rowspan="2">Nama Kegiatan</th>
                    <th colspan="5"><center>Alokasi Pendanaan</center></th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                	<th><span id="dana-tahun1">-</span></th>
                    <th><span id="dana-tahun2">-</span></th>
                    <th><span id="dana-tahun3">-</span></th>
                    <th><span id="dana-tahun4">-</span></th>
                    <th><span id="dana-tahun5">-</span></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
	
    </div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="keuanganE2Modal" class="modal fade">
            <div class="modal-dialog">
            <form method="post" id="keuangankl-form" class="form-horizontal bucket-form" role="form">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                        <h5 class="modal-title" id="keuangan_title_form"></h5>
                    </div>
                    <div class="modal-body" id="keuangan_form_konten">
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
        
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#dana-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#dana-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		$("#dana-btn").click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			kode2 = $('#dana-kode_e2').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#dana-tahun').select2('open');
			}
			if (kode=="0") {
				alert("Unit Kerja Eselon I belum ditentukan");
				$('#dana-kode_e1').select2('open');
			}
			else {
				var arrayrenstra = tahun.split('-');
				//alert(arrayrenstra[0]);
				var no = 1;
				for (i = arrayrenstra[0]; i <=arrayrenstra[1]; i++) { 
					$('#dana-tahun'+no).html(i);
					no++;
				}
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_body_pendanaan/"+tahun+"/"+kode+"/"+kode2,
                        success:function(result) {
                            table_body = $('#dana-tbl tbody');
                            table_body.empty().html(result);        
                            $('#dana_kl_konten').removeClass("hide");
                        }
                });
			}
		});
		keuangane2_Add =function(){
			$("#keuangan_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Kebutuhan Pendanaan');
			$("#keuangankl-form").attr("action",'<?=base_url()?>pemrograman/pendanaan_e2/save');
			$.ajax({
				url:'<?=base_url()?>pemrograman/pendanaan_e2/add',
					success:function(result) {
						$('#keuangan_form_konten').html(result);
					}
			});
		}
		
		keuangane2_Edit =function(renstra,program){
			$("#keuangan_title_form").html('<i class="fa fa-plus-square"></i>  Update Kebutuhan Pendanaan');
			$("#keuangankl-form").attr("action",'<?=base_url()?>pemrograman/pendanaan_e2/update');
			$.ajax({
				url:'<?=base_url()?>pemrograman/pendanaan_e2edit/'+renstra+'/'+program,
					success:function(result) {
						$('#keuangan_form_konten').html(result);
					}
			});
		}
		
		$("#keuangankl-form").submit(function( event ) {
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
						$('#btn-close').click();
						$("#dana-btn").click();
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
	})
	</script>	        