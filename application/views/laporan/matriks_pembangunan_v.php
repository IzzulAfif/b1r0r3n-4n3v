<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
                <section class="panel">
                    <header class="panel-heading tab-bg-light tab-right ">
                        <p class="pull-left"><b>Matriks Pembangunan Bidang Transportasi</b></p>
                        <span class="pull-right">
                            <!--<a href="<?=base_url()?>unit_kerja/eselon1/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>-->
                         </span>
                    </header>
                    <div class="panel-body">
						<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">									
										<?=form_dropdown('periode_renstra',$renstra,'0','id="periode_renstra" class="populate"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Rentang Tahun</label>
									<div class="col-sm-2">									
										<?=form_dropdown('rentang_awal',array(),'','id="rentang_awal"  class="populate"')?>
										
									</div>
									<label class="col-sm-1 control-label" style="text-align:center;width:10px;margin-left:-20px">s.d.</label>
								
									<div class="col-sm-2">																			
										<?=form_dropdown('rentang_akhir',array(),'','id="rentang_akhir"  class="populate"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Kementerian</label>
									<div class="col-sm-3">									
										<?=form_dropdown('kl',array("0"=>"Pilih Kementrian","022"=>"Kementerian Perhubungan"),'0','id="kodekl" class="populate"')?>
									</div>
								</div>
								<div class="form-group">
									 <div class="col-sm-offset-2 col-sm-3">
									 
										<button type="button" id="btnLoad"  class="btn btn-info">
											<i class="fa fa-play"></i> Tampilkan Data
										</button>
									</div>
								</div>
							</div>	
							</div>
        </section>
    </div>
						<div class="feed-box" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                                        	<form  method="post" id="matriks_form" name="matriks_form" action="<?=base_url()?>laporan/matriks_pembangunan/save" >
                                            <div id="reportKonten">
                                            </div>
                                            </form>
                                        </div>
                </section>
            </div>
        </section>
    </section>
    <!--main content end-->
	<style type="text/css">
	select {width:100%;}
</style>

<script  type="text/javascript" language="javascript">
$(document).ready(function() {
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	load_profile = function(){
		var tahun = $('#periode_renstra').val();
		var kodekl = $('#kodekl').val();
		var range_awal = $("#rentang_awal").val();
		var range_akhir = $("#rentang_akhir").val();
		
		$("#reportKonten").load("<?=base_url()?>laporan/matriks_pembangunan/get_sasaran/"+tahun+"/"+kodekl+"/"+range_awal+"/"+range_akhir);
		
	}
	
	set_rentang = function(){
		var periode_renstra = $("#periode_renstra");
		var range_awal = $("#rentang_awal");
		var range_akhir = $("#rentang_akhir");
		range_awal.empty();range_akhir.empty();
		
		 if (periode_renstra.val()!=0) {
			year = periode_renstra.val().split('-');
			//alert(year[0]);
			for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
				range_awal.append(new Option(i,i));
				range_akhir.append(new Option(i,i));
			}
		 }
	}
	
	
	clickIku = function(id){
		chk = $("#chk"+id);
		keterangan = $("#keterangan"+id);		
		keterangan.prop("readonly",!chk.is(':checked'));
		
	}
	
	 $("#btnLoad").click(function(){
		load_profile();
	}); 
	
	$("#periode_renstra").change(function(){
		set_rentang();
	}); 
	
	
	$("#klikdisini").click(function(){
		alert('underconstruction');
		return;
		var tahun = $('#tahun').val();
		var kodekl = $('#kodekl').val();
		window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
	}); 
	
	
	$("#matriks_form").submit(function( event ) {
		
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
					//renstra_update();
					//$('#btn-close').click();
					//$("#id-btn").click();
					//alert('kadieu sukses');
					print_matriks();
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
				//	$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
				//	$('#btn-close').click();
				}
			});
			event.preventDefault();
	});
	
	print_matriks = function(){
		var tahun = $('#periode_renstra').val();
		var rentang_awal = $('#rentang_awal').val();
		var rentang_akhir = $('#rentang_akhir').val();
		var kodekl = $('#kodekl').val();
		window.open("<?=base_url()?>laporan/matriks_pembangunan/get_detail/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/"+kodekl);
	}
});
</script>