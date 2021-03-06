<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Kinerja Kementerian</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_kinerjakl-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_kinerjakl-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_kinerjakl-content">
		<!--main content start-->
				
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="kinerja_kl-tbl">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Sasaran</th>
						<th>IKU</th>               
						<th>Satuan</th>
						<th>Target</th>
						<th>Realisasi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>  
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="eperform_kinerjakl-content">
					<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="eperform-ekstrak-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
				</div>
		</div>	
					
	</div>
	
</section>
 <script>
	$(document).ready(function(){
		$("#eperform-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "tahun" , "sWidth": "100px"},					  
					  { "mData": "sasaran", "sWidth": "30%"  },
					  { "mData": "iku" , "sWidth": "30%" },
					  { "mData": "satuan"  },
					  { "mData": "target"  },
					  { "mData": "realisasi"  }
					]
			load_ajax_datatable2("kinerja_kl-tbl", '<?=base_url()?>admin/ekstrak_kinerja_kl/getdata_kinerja_kl/<?=$periode_renstra?>',columsDef,1,"desc");
		$("#eperformance-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "tahun" , "sWidth": "100px"},					  
					  { "mData": "sasaran", "sWidth": "30%"  },
					  { "mData": "iku" , "sWidth": "30%" },
					  { "mData": "satuan"  },
					  { "mData": "target"  },
					  { "mData": "realisasi"  }
					]
			load_ajax_datatable2("kinerja_kl-tbl", '<?=base_url()?>admin/ekstrak_kinerja_kl/getdata_kinerja_kl/',columsDef,1,"desc");
		});
	});
</script>	   
   