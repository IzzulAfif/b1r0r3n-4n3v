<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-4">
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="iku-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="iku-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="iku-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

 	<div id="iku_konten" class="hide">

        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#ssModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ss_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="iku-tbl">
            <thead>
            <tr>
                <th>Sasaran Program</th>
                <th>Kode IKU</th>
                <th>Deskripsi</th>                        
                <th>Satuan</th>                        
                <th width="10%">Aksi</th>
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
		$("#iku-btn").click(function(){
			tahun = $('#iku-tahun').val();
			kode = $('#iku-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_body_iku/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#iku-tbl tbody');
                            table_body.empty().html(result);        
                            $('#iku_konten').removeClass("hide");
                        }
                });  
		});
	})
</script>	                              