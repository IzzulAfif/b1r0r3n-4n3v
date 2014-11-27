	
    <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
                        <div class="col-md-3">
						<?=form_dropdown('renstra',$renstra,'0','id="detail-tahun_renstra" class="populate"')?>
                        	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-md-2">
							 <?=form_dropdown('tahun',array("0"=>"Pilih Tahun"),'0','id="detail-tahun"')?>
                        	
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Program<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<select name="program" id="detail-program" class="populate" style="width:100%">
                            	<option value="-1">Pilih Program</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kegiatan<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<select name="kegiatan" id="detail-kegiatan" class="populate" style="width:100%">
                            	<option value="-1">Pilih Kegiatan</option>
                            </select>
                        </div>
                    </div>
                    <!--diganti ku output -->
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Lokasi</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kdlokasi',$lokasi,'0','id="detail-kdlokasi" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Output<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kdoutput',array("-1"=>"Pilih Output"),'-1','id="detail-kdoutput" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="detail-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
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
                
                <p class="text-primary">Rincian Paket Pekerjaan</p><br />
                <table  class="display table table-bordered table-striped" id="detail-tbl">
                	<thead>
                    	<tr>
                    		<th width="1%">No</th>
                            <th>Paket Pekerjaan</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                           <th>Kabupaten/Kota</th>
                     <!--        <th>Status</th> -->
                        </tr>
                    </thead>
					 <tbody>
					 </tbody>
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
		
		$('#detail-tahun_renstra').change(function(){
			var periode_renstra = $("#detail-tahun_renstra");
			var tahun = $("#detail-tahun");
			
			tahun.empty();
			tahun.append(new Option("Pilih Tahun","0"));
			 if (periode_renstra.val()!='0') {
				year = periode_renstra.val().split('-');
				//alert(year[0]);
				
				tahun.select2("val", "0");
				for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
					tahun.append(new Option(i,i));
					
				}
				
			 }
			 $('#detail-tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
			
		});
		
		
		$('#detail-tahun').change(function(){
			tahun	= $('#detail-tahun').val();
			$.ajax({
				url:"<?=site_url()?>analisis/kegiatan/get_program/"+tahun,
				success:function(result) {
					$('#detail-program').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#detail-program').append(new Option(result[a].nama_program,result[a].kode_program));
					}
					$('#detail-program').select2({minimumResultsForSearch: -1, width:'resolve'});
					
					$('#detail-kegiatan').empty();
					$('#detail-kegiatan').append(new Option("Pilih Kegiatan","-1"));
					$('#detail-kegiatan').select2({minimumResultsForSearch: -1, width:'resolve'});
					$('#detail-kdoutput').empty();
					$('#detail-kdoutput').append(new Option("Pilih Output","-1"));
					$('#detail-kdoutput').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		$('#detail-program').change(function(){
			tahun	= $('#detail-tahun').val();
			program	= $('#detail-program').val();
			$.ajax({
				url:"<?=site_url()?>analisis/kegiatan/get_kegiatan/"+tahun+"/"+program,
				success:function(result) {
					$('#detail-kegiatan').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#detail-kegiatan').append(new Option(result[a].nama_kegiatan,result[a].kode_kegiatan));
					}
					$('#detail-kegiatan').select2({minimumResultsForSearch: -1, width:'resolve'});
					
					$('#detail-kdoutput').empty();
					$('#detail-kdoutput').append(new Option("Pilih Output","-1"));
					$('#detail-kdoutput').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		
		$('#detail-kegiatan').change(function(){
			
			kegiatan	= $('#detail-kegiatan').val();
			$.ajax({
				url:"<?=site_url()?>analisis/kegiatan/get_output/"+kegiatan,
				success:function(result) {
					$('#detail-kdoutput').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#detail-kdoutput').append(new Option(result[a].nmoutput,result[a].kdoutput));
					}
					$('#detail-kdoutput').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		
		$('#detail-lokasi').change(function(){
			$('#box-result').removeClass("hide");
		});
		
	
		
		$("#detail-btn").click(function(){
			renstra = $('#detail-tahun_renstra').val();
			tahun = $('#detail-tahun').val();
			program = $('#detail-program').val();
			kegiatan = $('#detail-kegiatan').val();
			lokasi = $('#detail-kdlokasi').val();
			output = $('#detail-kdoutput').val();
			if (renstra=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#detail-tahun_renstra').select2('open');
			}
			else if (tahun=="0") {
				alert("Tahun belum ditentukan");
				$('#detail-tahun').select2('open');
			}
			else if (program=="-1") {
				alert("Nama Program belum ditentukan");
				$('#detail-program').select2('open');
			}
			else if (kegiatan=="-1") {
				alert("Nama Kegiatan belum ditentukan");
				$('#detail-kegiatan').select2('open');
			}
			else if (output=="-1") {
				alert("Nama Output belum ditentukan");
				$('#detail-kdoutput').select2('open');
			}
			else {
				$.ajax({
                    url:"<?php echo site_url(); ?>analisis/kegiatan/get_list_rincian/"+tahun+"/"+program+"/"+kegiatan+"/"+output,
                        success:function(result) {
                            table_body = $('#detail-tbl tbody');
                            table_body.empty().html(result);        
                            $('#box-result').removeClass("hide");
                        }
                });  
			}
		});
    });
    </script>
    <!--js-->