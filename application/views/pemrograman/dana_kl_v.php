            
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
                    <div class="form-group <?php if($page=="kl"): echo "hide"; endif; ?>">
                        <label class="col-md-2 control-label">Unit Kerja</label>
                        <div class="col-md-6">
                         <?=form_dropdown('kode_e1',$eselon1,'0','id="dana-kode_e1"  class="populate" style="width:100%"')?>
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
        
        <div class="row hide">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#keuanganklModal" data-toggle="modal" onclick="keuangankl_Add();" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        
        <br />
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="dana-tbl">
                <thead>
                <tr>
                	<th rowspan="2">No</th>
                    <th rowspan="2">Nama Program</th>
                    <th colspan="5"><center>Alokasi Pendanaan</center></th>
                    <th rowspan="2">Total</th>
                  <!--  <th rowspan="2">Action</th> -->
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
	
    	<!--<div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_danakl"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_danakl"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>-->
        
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="keuanganklModal" class="modal fade">
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
    
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#dana-btn").click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#dana-tahun').select2('open');
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
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_pendanaan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#dana-tbl tbody');
                            table_body.empty().html(result);        
                            $('#dana_kl_konten').removeClass("hide");
                        }
                });
			}
		});
		$('#cetakpdf_danakl').click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_dana_pdf/'+tahun+"/"+kode,'_blank');			
		});
		$('#cetakexcel_danakl').click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_dana_excel/'+tahun+"/"+kode,'_blank');			
		});
		
		keuangankl_Add =function(){
			$("#keuangan_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Kebutuhan Pendanaan');
			$("#keuangankl-form").attr("action",'<?=base_url()?>pemrograman/pendanaan_proses/save');
			$.ajax({
				url:'<?=base_url()?>pemrograman/pendanaan_proses/add',
					success:function(result) {
						$('#keuangan_form_konten').html(result);
					}
			});
		}
		
		keuangankl_Edit =function(renstra,program){
			$("#keuangan_title_form").html('<i class="fa fa-plus-square"></i>  Update Kebutuhan Pendanaan');
			$("#keuangankl-form").attr("action",'<?=base_url()?>pemrograman/pendanaan_proses/update');
			$.ajax({
				url:'<?=base_url()?>pemrograman/pendanaan_proses/edit/'+renstra+'/'+program,
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
	});
	</script>	        