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
                         		<?=form_dropdown('tahun',$renstra,'0','id="sasaran-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tahun <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <?=form_dropdown('form-tahun',array("Pilih Tahun"),'','id="form-tahun-sasprog"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="sasaran-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="sasaran-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
                   
	<div id="sp_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#spModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="sp_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="sasaran-tbl">
            <thead>
            <tr>
                <th>Unit Kerja</th>
                <th>No</th>
                <th>Kode</th>
                <th>Sasaran Strategis</th>
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
		
		renstra = $('#sasaran-tahun');
		form_tahun2	= $('#form-tahun-sasprog');
		
		renstra.change(function(){
            form_tahun2.empty();
            if (renstra.val()!=0) {
                year = renstra.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    form_tahun2.append(new Option(i,i));
                }
                form_tahun2.select2({minimumResultsForSearch: -1, width:'resolve'});
            }
        });
		
		$("#sasaran-btn").click(function(){
			tahun = $('#sasaran-tahun').val();
			kode = $('#sasaran-kode_e1').val();
			tahun2 = $('#form-tahun-sasprog').val();
			
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#sasaran-tahun').select2('open');
			}
			else {
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_body_sasaran/"+tahun2+"/"+kode,
                        success:function(result) {
                            table_body = $('#sasaran-tbl tbody');
                            table_body.empty().html(result);        
                         	$('#sp_konten').removeClass("hide");   
                        }
                });
			}
		});
	})
</script>	               