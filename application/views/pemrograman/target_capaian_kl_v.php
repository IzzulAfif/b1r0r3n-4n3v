            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="target-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sasaran Strategis</label>
                        <div class="col-md-6">
                            <?=form_dropdown('sasaran',array('0'=>"Pilih Sasaran Strategis"),'','id="target-sasaran" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="target-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
                   
	<div id="target_kl_konten" class="hide">
		
        <div class="row hide">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#tcModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="tc_kl_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="target-tbl">
            <thead>
            <tr>
                <th rowspan="2" width="3%">No</th>
                <th rowspan="2" width="5%">Kode</th>
                <th rowspan="2" width="40%">Indikator Kerja Utama</th>
                <th rowspan="2">Satuan</th>
                <th colspan="5"><center>Target Capaian</center></th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                	<th><span id="target-tahun1">-</span></th>
                    <th><span id="target-tahun2">-</span></th>
                    <th><span id="target-tahun3">-</span></th>
                    <th><span id="target-tahun4">-</span></th>
                    <th><span id="target-tahun5">-</span></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
        
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_targetkl"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_targetkl"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>
	
    </div>
    
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="tcModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="tc_kl_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="tc_kl_title"></h5>
                </div>
                <div class="modal-body" id="tc_kl_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btntc-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btntc-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		renstra = $('#target-tahun');
		sasaran = $('#target-sasaran');
		renstra.change(function(){
            if (renstra.val()!="") {
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/sasaran_strategis/get_sasaran/"+renstra.val(),
                    success:function(result) {
                        $('#target-sasaran').empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            $('#target-sasaran').append(new Option(result[k],k));
                        }
                        $('#target-sasaran').select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            }
        });
		$("#target-btn").click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#target-sasaran').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#target-tahun').select2('open');
			}
			else {
				var arrayrenstra = tahun.split('-');
				//alert(arrayrenstra[0]);
				var no = 1;
				for (i = arrayrenstra[0]; i <=arrayrenstra[1]; i++) { 
					$('#target-tahun'+no).html(i);
					no++;
				}
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_target/"+tahun+'/'+sasaran,
                        success:function(result) {
                            table_body = $('#target-tbl tbody');
                            table_body.empty().html(result);        
                            $('#target_kl_konten').removeClass("hide");
                        }
                });
			}
		});
		
		$('#cetakpdf_targetkl').click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#target-sasaran').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_target_pdf/'+tahun+"/"+sasaran,'_blank');			
		});
		
		$('#cetakexcel_targetkl').click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#target-sasaran').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_target_excel/'+tahun+"/"+sasaran,'_blank');			
		});
		
		tc_kl_add =function(){
			$("#tc_kl_title").html('<i class="fa fa-plus-square"></i> Tambah Target Capaian Kinerja');
			$("#tc_kl_form").attr("action",'<?=base_url()?>pemrograman/target_capaian_kl/save');
			$.ajax({
				url:'<?=base_url()?>pemrograman/target_capaian_kl/add',
					success:function(result) {
						$('#tc_kl_konten').html(result);
					}
			});
		}
		tc_kl_edit =function(tahun,kode){
			$("#tc_kl_title").html('<i class="fa fa-pencil"></i> Update Target Capaian Kinerja');
			$("#tc_kl_form").attr("action",'<?=base_url()?>pemrograman/target_capaian_kl/update');
			$('#tc_kl_konten').html("");
			$.ajax({
				url:'<?=base_url()?>pemrograman/target_capaian_kl/edit/'+tahun+'/'+kode,
					success:function(result) {
						$('#tc_kl_konten').html(result);
					}
			});
		}
		tc_kl_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>perencanaan/rencana_kl/hapus/tujuan/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#tc_kl-btn").click();
						}
				});
			}
		}
		
		$("#tc_kl_form").submit(function( event ) {
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
						$('#btntc-close').click();
						$("#target-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btntc-close').click();
					}
				});
			  event.preventDefault();
		});
	})
	</script>	        