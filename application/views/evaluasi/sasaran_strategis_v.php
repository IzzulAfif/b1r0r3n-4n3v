	
    <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
                            <?=form_dropdown('renstra',$renstra,'0','id="renstra"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun</label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array(),'','id="tahun_awal"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array(),'','id="tahun_akhir"')?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sasaran Strategis</label>
                        <div class="col-md-9">
                            <?=form_dropdown('sasaran',array(),'','id="sasaran"')?>
                        </div>
                    </div>
                        
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Capaian Kinerja</p><br />
                <table  class="display table table-bordered table-striped" id="tabel_capaian">
    	        </table>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
    <!--js-->
    <script type="text/javascript">
    $(document).ready(function () {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
        renstra = $('#renstra');
        tahun_awal = $('#tahun_awal');
        tahun_akhir = $('#tahun_akhir');
        sasaran = $('#sasaran');
        renstra.change(function(){
            tahun_awal.empty(); tahun_akhir.empty(); sasaran.empty();
            if (renstra.val()!=0) {
                year = renstra.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    tahun_awal.append(new Option(i,i));
                    tahun_akhir.append(new Option(i,i));
                }
                tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/sasaran_strategis/get_sasaran/"+renstra.val(),
                    success:function(result) {
                        sasaran.empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            sasaran.append(new Option(result[k],k));
                        }
                        sasaran.select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            }
        });
        tahun_awal.change(function(){
            update_table();
        });
        tahun_akhir.change(function(){
            update_table();
        });

        sasaran.change(function(){
            update_table();
        });

        function update_table() {
            val_awal = tahun_awal.val();
            val_akhir = tahun_akhir.val();
            if (sasaran.val()!=0 && sasaran.val()!='' && val_akhir>=val_awal) {
                kode_sasaran = sasaran.val();
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/sasaran_strategis/get_tabel_capaian_kinerja/"+val_awal+"/"+val_akhir+"/"+kode_sasaran,
                        success:function(result) {
                            tabel_capaian = $('#tabel_capaian');
                            tabel_capaian.empty().html(result);        
                            $('#box-result').removeClass("hide");
                            $('.toggler').click(function(e){
                                e.preventDefault();
                                $('.detail'+$(this).attr('id')).toggle();
                                target = $('#'+$(this).attr('target_rowspan'));
                                if (e.target.id==$(this).attr('id')) {
                                    num_rowspan = parseInt($(this).attr('num_rowspan'));
                                    target.attr('rowspan',(num_rowspan+parseInt(target.attr('rowspan'))));
                                    $(this).attr('num_rowspan',num_rowspan*-1);
                                }
                                //console.log('.detail'+$(this).attr('detail_num'));
                            });
                        }
                });    
            }
        }
    });
    </script>
    <!--js-->