<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Kabupaten/Kota</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_kabkota-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_kabkota-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_kabkota-content">
<!--main content start-->
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
			<table class="display table table-bordered table-striped" id="kabkota-tbl">
			<thead>
				<tr>
					<th>Kode Kab/Kota</th>
					<th>Kabupaten/Kota</th>
					<th>Latitude</th>
					<th>Longitude</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
			</div>      
    <!--main content end-->
	</div>
				<div class="tab-pane fade" id="emon_kabkota-content">
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
					<table class="display table table-bordered table-striped" id="emon_kabkota-tbl">
					 <thead>
						<tr>
							<th>Kode Kab/Kota</th>
							<th>Kabupaten/Kota</th>
							<th>Latitude</th>
							<th>Longitude</th>
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
					  { "mData": "kdkabkota" , "sWidth": "100px"},
					  { "mData": "nama_kabkota"  },
					  { "mData": "latitude" , "sWidth": "150px"},
					  { "mData": "longitude" , "sWidth": "150px"}
					]
			load_ajax_datatable2("kabkota-tbl", '<?=base_url()?>admin/ekstrak_kabkota/getdata_kabkota/',columsDef,1,"desc");
		$("#emon-btn").click(function(){		
			
		});
	});
</script>	   
   