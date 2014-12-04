<!--main content start-->
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
                        	<select name="tahun" class="populate" id="fungsi-tahun">
								<?php $no=0; foreach($renstra as $r): ?>
                                    <?php if($no==0): $val = ""; else: $val=$r; endif; ?>
                                    <option value="<?=$val?>"><?=$r?></option>
                                <?php $no++; endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="fungsi-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" id="fungsi-btn" class="btn btn-info" id="fungsi-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
	
    <div class="hide" id="konten_fungsikl">
	<div class="row">
        <div class="col-sm-12">
        	<?php if(count($kl)==0): ?>
            <div class="pull-right">
                 <a href="#fungsiModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="fungsi_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
             </div>
            <?php endif; ?>
        </div>
    </div>
    <br />
	<div class="adv-table">
        <table  class="display table table-bordered table-striped" id="fungsi-tbl">
        <thead>
        <tr>
            <th>No.</th>
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
        <form method="post" id="fungsi_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="fungsi_title"></h5>
                </div>
                <div class="modal-body" id="fungsi_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnfungsi-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnfungsi-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<!--main content end-->
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#fungsi-btn").click(function(){
			tahun = $('#fungsi-tahun').val();
			if (tahun=="") {
					alert("Periode Renstra belum ditentukan");
					$('#fungsi-tahun').select2('open');
					return;
			}
			kl = $('#fungsi-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/anev_kl/get_body_fungsi/"+tahun+"/"+kl,
                        success:function(result) {
                            table_identitas = $('#fungsi-tbl tbody');
                            table_identitas.empty().html(result);
                            $('#konten_fungsikl').removeClass("hide");
                        }
                });  
		});
		fungsi_add =function(){
			$("#fungsi_title").html('<i class="fa fa-plus-square"></i> Tambah Fungsi Kementerian');
			$("#fungsi_form").attr("action",'<?=base_url()?>unit_kerja/anev_kl/save/fungsi');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/anev_kl/add/fungsi',
					success:function(result) {
						$('#fungsi_konten').html(result);
					}
			});
		}
		fungsi_edit =function(tahun,kode){
			$("#fungsi_title").html('<i class="fa fa-pencil"></i> Edit Fungsi Kementerian');
			$("#fungsi_form").attr("action",'<?=base_url()?>unit_kerja/anev_kl/update');
			$('#fungsi_konten').html("");
			$.ajax({
				url:'<?=base_url()?>unit_kerja/anev_kl/edit/fungsi/'+tahun+'/'+kode,
					success:function(result) {
						$('#fungsi_konten').html(result);
					}
			});
		}
		fungsi_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>unit_kerja/anev_kl/hapus/fungsi/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#fungsi-btn").click();
						}
				});
			}
		}
		$("#fungsi_form").submit(function( event ) {
			var tahun 	= $('#form-tahun').val();
			var kl		= $('#form-kl').val();
			var kdf		= $('#form-kode-fungsi').val();
			var fungsi	= $('#form-fungsi').val();
			
			if(tahun==""){
				alert("Periode Renstra belum ditentukan");
				return false;
			}else if(kl==""){
				alert("Nama Kementerian belum ditentukan");
				return false;
			}else if(kdf==""){
				alert("Kode Fungsi belum ditentukan");
				return false;
			}else if(fungsi==""){
				alert("Fungsi belum ditentukan");
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
						$('#btnfungsi-close').click();
						$("#fungsi-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btnfungsi-close').click();
					}
				});
			  event.preventDefault();
			
			}
		});
		$('#fungsi-tahun').change(function(){
			tahun	= $('#fungsi-tahun').val();
			$.ajax({
				url:"<?=site_url()?>unit_kerja/anev_kl/get_kementerian/"+tahun,
				success:function(result) {
					$('#fungsi-kodekl').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#fungsi-kodekl').append(new Option(result[a].nama,result[a].kode));
					}
					$('#fungsi-kodekl').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
	});
</script>	
    
    