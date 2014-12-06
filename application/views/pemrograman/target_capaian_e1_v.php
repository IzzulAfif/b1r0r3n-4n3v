            
<div class="feed-box">
        <section class="panel tab-bg-form" style="z-index:auto">
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
                    <div class="form-group <?php if($page=="kl"): echo "hide"; endif; ?>" id="kodep_e1-box1">
                        <label class="col-md-2 control-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <div class="col-md-6">
						 <?=form_dropdown('kode_e1_s',array("Semua Unit Kerja"),'0','id="target-kode_e1_s"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group hide" id="kodep_e1-box2">
                        <label class="col-md-2 control-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <div class="col-md-6">
						 <?=form_dropdown('kode_e1',$eselon1,'0','id="target-kode_e1"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sasaran Strategis</label>
                        <div class="col-md-8">
                            <?=form_dropdown('sasaran',array('0'=>"Semua Sasaran Strategis"),'','id="target-sasaran" class="populate" style="width:100%"')?>
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
                     <a href="#capaianes1Modal" data-toggle="modal" onclick="capaianes1_Add();" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
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
	
    </div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="capaianes1Modal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="capaianes1-form" class="form-horizontal bucket-form" role="form">  
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="capaianes1_title_form"></h5>
                </div>
                <div class="modal-body" id="capaianes1_form_konten">
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" id="btncapaian-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
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
		<?php if($page!="kl"):?>
		$("#target-tahun").click(function(){
			$("#kodep_e1-box1").addClass("hide");
			$("#kodep_e1-box2").removeClass("hide");
		});
		<?php endif; ?>
		renstra = $('#target-tahun');
		sasaran = $('#target-sasaran');
		e1		= $('#target-kode_e1');
		renstra.change(function(){
            if (renstra.val()!="") {
				var arrayrenstra = $('#target-tahun').val().split('-');
				var kode_e1		 = $('#target-kode_e1').val();
                $.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_sasprog/"+arrayrenstra[0]+"/"+arrayrenstra[1]+"/0",
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
		e1.change(function(){
            if (renstra.val()!="") {
				var arrayrenstra = $('#target-tahun').val().split('-');
				var kode_e1		 = $('#target-kode_e1').val();
                $.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_sasprog/"+arrayrenstra[0]+"/"+arrayrenstra[1]+"/"+kode_e1,
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
			es1		= $('#target-kode_e1').val();
			
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#target-tahun').select2('open');
			}
			else if (es1=="0") {
				alert("Nama unit kerja belum ditentukan");
				$('#target-kode_e1').select2('open');
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
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_body_target/"+tahun+'/'+sasaran,
                        success:function(result) {
                            table_body = $('#target-tbl tbody');
                            table_body.empty().html(result);        
                            $('#target_kl_konten').removeClass("hide");
                        }
                });
			}
		});
		
		capaianes1_Add =function(){
			$("#capaianes1_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Target Capaian Kinerja');
			$("#capaianes1-form").attr("action",'<?=base_url()?>pemrograman/target_capaian_e1/save');
			$.ajax({
				url:'<?=base_url()?>pemrograman/target_capaian_e1/add',
					success:function(result) {
						$('#capaianes1_form_konten').html(result);
					}
			});
		}
		
		capaianes1_edit =function(tahun,kode){
			$("#capaianes1_title_form").html('<i class="fa fa-pencil"></i> Edit Target Capaian Kinerja');
			$("#capaianes1-form").attr("action",'<?=base_url()?>pemrograman/target_capaian_e1/update');
			$.ajax({
				url:'<?=base_url()?>pemrograman/target_capaian_e1/edit/'+tahun+'/'+kode,
					success:function(result) {
						$('#capaianes1_form_konten').html(result);
					}
			});
		}
		
		$("#capaianes1-form").submit(function( event ) {
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
						$('#btncapaian-close').click();
						$("#target-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btncapaian-close').click();
					}
				});
			  event.preventDefault();
		});
	})
	</script>	        