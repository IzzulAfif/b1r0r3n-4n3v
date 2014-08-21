<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                <section class="panel panel-primary">
                    <header class="panel-heading">
                        <h3 class="panel-title">EVALUASI PROGRAM</h3>
                    </header>
                    <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                        <label class="col-md-2">Periode Renstra</label>
                        <div class="col-md-2"><?=form_dropdown('renstra',$renstra,'0','id="renstra"')?></div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-2">Tahun</label>
                        <div class="col-md-2"><?=form_dropdown('tahun_awal',array(),'','id="tahun_awal"')?></div>
                        <div class="col-md-2"><?=form_dropdown('tahun_akhir',array(),'','id="tahun_akhir"')?></div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-2">Nama Program</label>
                        <div class="col-md-7"><?=form_dropdown('nama_program',array(),'','id="nama_program"')?></div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-2">Nama Kegiatan</label>
                        <div class="col-md-10" id="nama_kegiatan"></div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-2">Pelaksana Program</label>
                        <div class="col-md-7" id="pelaksana"></div>
                        </div>
                    </form>
                    <section class="panel panel-default">
                    <div class="panel-heading">Capaian Kinerja</div>
                    <div class="panel-body">
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="tabel_capaian">
                    </table>

                    </div>
                    </div>
                    </section>
                    <section class="panel panel-default">
                    <div class="panel-heading">Serapan Anggaran</div>
                    <div class="panel-body">
                    <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="tabel_serapan">
                    </table>

                    </div>
                    </div>
                    </section>
                    </div>
                </section>
        </section>
    </section>
    <!--main content end-->
     <style type="text/css">
        select {width:100%;}
    </style>
    <!--js-->
    <script src="<?=base_url("static")?>/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('select').select2({minimumResultsForSearch: -1, width:'resolve'});
        renstra = $('#renstra');
        tahun_awal = $('#tahun_awal');
        tahun_akhir = $('#tahun_akhir');
        nama_program = $('#nama_program');
        pelaksana = '';
        renstra.change(function(){
            tahun_awal.empty(); tahun_akhir.empty(); nama_program.empty();
            if (renstra.val()!=0) {
                year = renstra.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    tahun_awal.append(new Option(i,i));
                    tahun_akhir.append(new Option(i,i));
                }
            }
            tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
        });
        tahun_awal.change(function(){
            
        });
        tahun_akhir.change(function(){
            val_awal = tahun_awal.val();
            val_akhir = tahun_akhir.val();
            $.ajax({
                url:"<?php echo site_url(); ?>evaluasi/program/get_program/"+val_awal+"/"+val_akhir,
                success:function(result) {
                    nama_program.empty();
                    result = JSON.parse(result);
                    for (k in result) {
                        nama_program.append(new Option(result[k],k));
                    }
                    nama_program.select2({minimumResultsForSearch: -1, width:'resolve'});
                }
            });
        });

        nama_program.change(function(){
            if (nama_program.val()!=0) {
                kode_program = nama_program.val();
                val_awal = tahun_awal.val();
                val_akhir = tahun_akhir.val();
                //req kegiatan & pelaksana
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/program/get_kegiatan_pelaksana_program/"+kode_program,
                    success:function(result) {
                        result = JSON.parse(result);
                        update_table(kode_program, val_awal, val_akhir, result.pelaksana.kode_e1);
                        $('#pelaksana').html(result.pelaksana.nama_e1+" ("+result.pelaksana.kode_e1+")");
                        list_kegiatan = '<ol>';
                        nama_kegiatan = $('#nama_kegiatan');
                        nama_kegiatan.empty();
                        //nama_kegiatan.append('<ol>');
                        for (i in result.kegiatan) list_kegiatan+='<li>'+result.kegiatan[i]+'</li>';                
                        list_kegiatan += '</ol>';
                        nama_kegiatan.append(list_kegiatan);
                    }
                });
            } 
        });

        function update_table(kd_program, thn_awal, thn_akhir, kd_pelaksana) {
            //req capaian
            if (kd_program!=0 && kd_program!='' && kd_pelaksana!=0 && kd_pelaksana!='' && thn_akhir>=thn_awal) {
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/program/get_tabel_capaian_kinerja/"+thn_awal+"/"+thn_akhir+"/"+kd_pelaksana,
                        success:function(result) {
                            tabel_capaian = $('#tabel_capaian');
                            tabel_capaian.empty().html(result);        
                            tabel_capaian.dataTable( {
                                "bDestroy": true
                        });
                    }
                });
                //req serapan                     
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/program/get_tabel_serapan_anggaran/"+thn_awal+"/"+thn_akhir+"/"+kd_program,
                        success:function(result) {
                            tabel_serapan = $('#tabel_serapan');
                            tabel_serapan.empty().html(result);        
                            tabel_serapan.dataTable( {
                                "bDestroy": true
                        });
                    }
                });
            }
        }
    });
    </script>
    <!--js-->