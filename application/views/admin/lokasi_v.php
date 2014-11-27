<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Lokasi</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_lokasi-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_lokasi-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_lokasi-content">
<!--main content start-->
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="lokasi-tbl">
				<thead>
					<tr>
						<th>Kode Lokasi</th>
						<th>Lokasi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>
    <!--main content end-->
	</div>
				<div class="tab-pane fade" id="emon_lokasi-content">
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
					<table class="display table table-bordered table-striped" id="emon_lokasi-tbl">
					 <thead>
						<tr>
							<th>Kode Lokasi</th>
							<th>Lokasi</th>
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
					  { "mData": "kdlokasi" , "sWidth": "100px"},
					  { "mData": "lokasi"  }
					]
			load_ajax_datatable2("lokasi-tbl", '<?=base_url()?>admin/ekstrak_lokasi/getdata_lokasi/',columsDef,1,"desc");
		$("#emon-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kdlokasi" , "sWidth": "100px"},
					  { "mData": "lokasi"  }
					]
			load_ajax_datatable2("lokasi-tbl", '<?=base_url()?>admin/ekstrak_lokasi/getdata_lokasi/',columsDef,1,"desc");
		});
	});
</script>	   
   