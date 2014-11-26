<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Item Satker</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_itemsatker-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_itemsatker-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_itemsatker-content">
	<!--main content start-->    			
			<div class="adv-table">
			<table class="display table table-bordered table-striped" id="itemsatker-tbl">
			<thead>
				<tr>			
					<th>Tahun</th>
					<th>Kode Satker</th>
					<th>Unit Kerja</th>
					<th>Kode Program</th>
					<th>Kode Kegiatan</th>
					<th>Kode Lokasi</th>
					<th>Kode Kab/Kota</th>
					<th>No.Item</th>
					<th>Nama Item</th>
					<th>Vol.Kegiatan</th>
					<th>Sat.Kegiatan</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
			</div>	
		<!--main content end-->
		</div>
				<div class="tab-pane fade" id="emon_itemsatker-content">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-left">
								  <button type="button" class="btn btn-info" id="emon-ekstrak-btn" style="margin-left:15px;">
										<i class="fa fa-gear"></i> Ekstrak
									</button>
							 </div>
						</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="emon_itemsatker-tbl">
					 <thead>
						<tr>
							<th>Tahun</th>
							<th>Kode Satker</th>
							<th>Unit Kerja</th>
							<th>Kode Program</th>
							<th>Kode Kegiatan</th>
							<th>Kode Lokasi</th>
							<th>Kode Kab/Kota</th>
							<th>No.Item</th>
							<th>Nama Item</th>
							<th>Vol.Kegiatan</th>
							<th>Sat.Kegiatan</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
				</div>		
				</div>
		</div>	
					
	</div>
	
</section>	
 <script>
 
 
	$(document).ready(function(){
		 $("#emon-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		
		
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "kode_e1" , "sWidth": "70px"},
					  { "mData": "kode_program" , "sWidth": "70px"},
					  { "mData": "kode_kegiatan" , "sWidth": "70px"},
					  { "mData": "kdlokasi" , "sWidth": "70px"},
					  { "mData": "kdkabkota" , "sWidth": "70px"},
					  { "mData": "noitem" , "sWidth": "70px"},
					  { "mData": "nmitem"  },
					  { "mData": "volkeg", "sWidth": "70px" },
					  { "mData": "satkeg", "sWidth": "60px" }
					  
					]
			load_ajax_datatable2("itemsatker-tbl", '<?=base_url()?>admin/ekstrak_itemsatker/getdata_itemsatker/<?=$tahun_renstra?>/<?=$eselon1?>',columsDef,1,"desc");
			
			
			
			
		$("#emon-btn").click(function(){
			var tahun = $('#emon-tahun').val();
			var kode = $('#emon-kode_e1').val();
			
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "kode_e1" , "sWidth": "70px"},
					  { "mData": "kode_program" , "sWidth": "70px"},
					  { "mData": "kode_kegiatan" , "sWidth": "70px"},
					  { "mData": "kdlokasi" , "sWidth": "70px"},
					  { "mData": "kdkabkota" , "sWidth": "70px"},
					  { "mData": "noitem" , "sWidth": "70px"},
					  { "mData": "nmitem"  },
					  { "mData": "volkeg", "sWidth": "70px" },
					  { "mData": "satkeg", "sWidth": "60px" }
					  //{ "mData": "kode_status", "sWidth": "60px" }
					]
			load_ajax_datatable2("satker-tbl", '<?=base_url()?>admin/ekstrak_itemsatker/getdata_itemsatker/'+tahun+'/'+kode,columsDef,1,"desc");
		});
		
		
		
		
		   
		
	});
</script>	   
   