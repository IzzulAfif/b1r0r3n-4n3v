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
                         	<select name="tahun" class="populate" id="id-tahun">
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
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="id-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="id-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
	
    <div id="bodytable" class="hide">
    
        <div class="row">
            <div class="col-sm-12">
            	<?php if(count($kl)==0): ?>
                <div class="pull-right" id="kl_add_btn">
                  <a href="#fModal" data-toggle="modal" class="btn btn-primary btn-sm" onclick="kl_add();" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <br />
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="id-tbl">
            <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Kementerian</th>
                
                <th>Tugas </th>
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
        <form method="post" id="kl_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="kl_title"></h5>
                </div>
                <div class="modal-body" id="kl_konten">
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
		$("#id-btn").click(function(){
			tahun = $('#id-tahun').val();
			//kl = $('#id-kodekl').val();
			if (tahun=="") {
					alert("Periode Renstra belum ditentukan");
					$('#id-tahun').select2('open');
					return;
			}
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/anev_kl/get_body_identitas/"+tahun,
                        success:function(result) {
                            table_identitas = $('#id-tbl tbody');
                            table_identitas.empty().html(result);        
                            $('#bodytable').removeClass("hide");
                        }
                });  
		});
	});
	kl_add =function(){
		$("#kl_title").html('<i class="fa fa-plus-square"></i> Tambah Kementerian');
		$("#kl_form").attr("action",'<?=base_url()?>unit_kerja/anev_kl/save');
		$.ajax({
			url:'<?=base_url()?>unit_kerja/anev_kl/add/id',
				success:function(result) {
					$('#kl_konten').html(result);
				}
		});
	}
	kl_edit =function(tahun,kode){
		$("#kl_title").html('<i class="fa fa-pencil"></i> Update Kementerian');
		$("#kl_form").attr("action",'<?=base_url()?>unit_kerja/anev_kl/update');
		$('#kl_konten').html("");
		$.ajax({
			url:'<?=base_url()?>unit_kerja/anev_kl/edit/id/'+tahun+'/'+kode,
				success:function(result) {
					$('#kl_konten').html(result);
				}
		});
	}
	kl_delete = function(tahun,kode){
		var confir = confirm("Anda yakin akan menghapus data ini ?");
		
		if(confir==true){
			$.ajax({
				url:'<?=base_url()?>unit_kerja/anev_kl/hapus/id/'+tahun+'/'+kode,
					success:function(result) {
						$.gritter.add({text: result});
						$("#id-btn").click();
					}
			});
		}
	}
	$( "#kl_form" ).submit(function( event ) {
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
					renstra_update();
					$('#btn-close').click();
					$("#id-btn").click();
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
			url:"<?=site_url()?>unit_kerja/anev_kl/get_renstra",
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
	$('#id-tahun').change(function(){
		tahun	= $('#id-tahun').val();
		$.ajax({
			url:"<?=site_url()?>unit_kerja/anev_kl/get_kementerian/"+tahun,
			success:function(result) {
				$('#id-kodekl').empty();
				result = JSON.parse(result);
				for (a in result) {
					$('#id-kodekl').append(new Option(result[a].nama,result[a].kode));
				}
				$('#id-kodekl').select2({minimumResultsForSearch: -1, width:'resolve'});
			}
		});
	});
	
</script>	