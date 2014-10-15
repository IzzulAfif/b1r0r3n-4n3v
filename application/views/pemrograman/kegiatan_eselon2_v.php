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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kegiatan-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group" id="kode_e1-box1">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1_s',array("Pilih Unit Kerja Eselon I"),'0','id="kegiatan-kode_e1_S" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group hide" id="kode_e1-box2">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="kegiatan-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array("Pilih Unit Kerja Eselon II"),'','id="kegiatan-kode_e2" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="kegiatan-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

	<div id="kegiatan_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="kegiatan-tbl">
            <thead>
            <tr>
            	<th>No</th>
            	<th>Unit Kerja</th>
                <th>Nama Program</th>
                <th>Kode</th>
                <th>Nama Kegiatan</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
	</div>
    
<style type="text/css">
	select {width:100%;}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#kegiatan-tahun").click(function(){
			$("#kode_e1-box1").addClass("hide");
			$("#kode_e1-box2").removeClass("hide");
		});
		$("#kegiatan-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#kegiatan-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		$("#kegiatan-btn").click(function(){
			tahun = $('#kegiatan-tahun').val();
			kode_e1 = $('#kegiatan-kode_e1').val();
			kode_e2 = $('#kegiatan-kode_e2').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#kegiatan-tahun').select2('open');
			}
			else if (kode_e1=="0") {
				alert("Unit kerja eselon I belum ditentukan");
				$('#kegiatan-kode_e1').select2('open');
			}
			else {
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_body_kegiatan/"+tahun+"/"+kode_e1+"/"+kode_e2,
                        success:function(result) {
                            table_body = $('#kegiatan-tbl tbody');
                            table_body.empty().html(result);        
                            $('#kegiatan_konten').removeClass("hide");
                        }
                });
			}
		});
	})
</script>	                              