            
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                     <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="tujuan-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="tujuan-kodekl"  class="populate" style="width:100%"')?>
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
    
    <div id="tujuan_kl_konten" class="hide">
    
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />

        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="tujuan-tbl">
        <thead>
        <tr>
          
            <th width="10%">Kode Tujuan</th>
            <th>Tujuan</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        
            <?php if (isset($data)){foreach($data as $d): ?>
            <tr class="gradeX">
             
                <td><?=$d->kode_tujuan_kl?></td>
                <td><?=$d->tujuan_kl?></td>
                <td>
                    <a href="#" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                    <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                </td>
            </tr>
            <?php endforeach; } else {?>
                <tr class="gradeX">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>			
                   
                </tr>
                <?php }?>
        
        </tbody>
        </table>
        </div>

	</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#tujuan-btn").click(function(){
			tahun = $('#tujuan-tahun').val();
			kode = $('#tujuan-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_kl/get_body_tujuan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#tujuan-tbl tbody');
                            table_body.empty().html(result);        
                            $('#tujuan_kl_konten').removeClass("hide");
                        }
                });  
		});
	})
</script>	               
               