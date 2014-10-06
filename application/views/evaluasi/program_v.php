
	<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                    	<label class="col-sm-2">Periode Renstra <span class="text-danger">*</span></label>
                    	<div class="col-sm-3"><?=form_dropdown('renstra',$renstra,'0','id="renstra"')?></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-sm-2">Tahun <span class="text-danger">*</span></label>
                    	<div class="col-sm-2"><?=form_dropdown('tahun_awal',array(),'','id="tahun_awal"')?></div>
                    	<div class="col-sm-2"><?=form_dropdown('tahun_akhir',array(),'','id="tahun_akhir"')?></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-sm-2">Nama Program <span class="text-danger">*</span></label>
                    	<div class="col-sm-8"><?=form_dropdown('nama_program',array(),'','id="nama_program"')?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="program-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <form class="form-horizontal grid-form" role="form">
                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Nama Kegiatan</label>
                    	<div class="col-md-10" id="nama_kegiatan"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Pelaksana Program</label>
                    	<div class="col-md-10" id="pelaksana"></div>
                    </div>
                    <div class="form-group">
                    	<p class="text-primary col-md-12"><b>Capaian Kinerja</b></p>
                        <div class="adv-table" id="data-capaian" style="width:100%; overflow: auto; padding:10px 5px 10px 5px;">
                            <table  class="display table table-bordered table-striped" id="tabel_capaian">
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Serapan Anggaran</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <table class="display table table-bordered table-striped" id="tabel_serapan">
                			</table>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Grafik Perbandingan Capaian Kinerja dan Daya Serap Anggaran</b></p>
                        <div id="grafik_program" style="padding:10px 5px 10px 5px">
                            
                        </div>
                    </div>
                    
                </form>
             </div>
        </section>
    </div>
    
    <style type="text/css">
        select {width:100%;}
    </style>
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

        $('#program-btn').click(function(){
            if (nama_program.val()!=0) {
                kode_program = nama_program.val();
                val_awal = tahun_awal.val();
                val_akhir = tahun_akhir.val();
                //req kegiatan & pelaksana
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/program/get_kegiatan_pelaksana_program/"+kode_program,
                    success:function(result) {
						$('#box-result').removeClass("hide");
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
							$("#data-capaian").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
							/*tabel_capaian.dataTable( {
                                "bDestroy": true
                        });*/
                    }
                });
                //req serapan                     
                $.ajax({
                    url:"<?php echo site_url(); ?>evaluasi/program/get_tabel_serapan_anggaran/"+thn_awal+"/"+thn_akhir+"/"+kd_program,
                        success:function(result) {
                            tabel_serapan = $('#tabel_serapan');
							tabel_serapan.empty().html(result);
                            /*tabel_serapan.dataTable( {
                                "bDestroy": true
                        });*/
                    }
                });
            }
			grafik(kd_program, thn_awal, thn_akhir, kd_pelaksana);
        }
		
		function grafik(kd_program, thn_awal, thn_akhir, kd_pelaksana)
		{
			var options = {
				chart: {
						renderTo: 'grafik_program',
						type : "column",
						marginTop: 80,
						marginRight: 20
					},
					colors: ['#3D96AE', '#DB843D', '#E10000'],
					exporting: {
						buttons: { 
							exportButton: {
								enabled:false
							},
							printButton: {
								enabled:true
							}
					
						}
					},
					title: {
						text: 'RATA-RATA CAPAIAN KINERJA DAN DAYA SERAP ANGGARAN',
						style : { "font-size" : "14px" }
					},
					xAxis: {
						categories: [],
					},
					yAxis: {
						title: {
							text: null
						}
					},
				series: [{
						name: 'Capaian Kinerja',
						type: 'column',
						dataLabels: {enabled: true},
					},{
						name: 'Serapan Anggaran',
						type: 'column',
						dataLabels: {enabled: true},
					}]
			};
			$.ajax({
				url: "<?php echo site_url(); ?>evaluasi/program/get_data_serapan/"+thn_awal+"/"+thn_akhir+"/"+kd_program+"/"+kd_pelaksana,
				dataType: "json",
				success: function(data){
					options.xAxis.categories = data.tahun;
					options.series[0].data = data.program;
					options.series[1].data = data.anggaran;
					var chart = new Highcharts.Chart(options);			
				}
			});
		}
    });
    </script>