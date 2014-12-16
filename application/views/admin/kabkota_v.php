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
			
			<div class="adv-table">
			<table class="display table table-bordered table-striped" id="kabkota-tbl">
			<thead>
				<tr>
					<th>Kode Lokasi</th>
					<th>Kode Kab/Kota</th>
					<th>Nama Kab/Kota</th>
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
								  <button type="button" class="btn btn-info" id="emon-kabkota-btn" style="margin-left:15px;">
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
							<th>Kode Lokasi</th>
							<th>Kode Kab/Kota</th>
							<th>Nama Kab/Kota</th>
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
		
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kdlokasi" , "sWidth": "100px"},
					  { "mData": "kdkabkota" , "sWidth": "100px"},
					  { "mData": "nama_kabkota"  } 
					]
			load_ajax_datatable2("kabkota-tbl", '<?=base_url()?>admin/ekstrak_kabkota/getdata_kabkota/',columsDef,1,"desc");
		
		
		$('#emon_kabkota-tbl').dataTable({
			"bServerSide": false,
			"sAjaxSource": '<?=$webservice_url?>',
			"sAjaxDataProp": "rows",
			"bProcessing": true,
			"bDestroy": true,
			
			"fnServerData": function (sSource, aoData, fnCallback) {
			  $.ajax({
				"dataType": 'json',
			//	"contentType": "application/json; charset=utf-8",
				"type": "GET",
				"url": sSource,
				"data": aoData,
				"success": function (msg) {
					var jsonString = JSON.stringify(msg, null, 4);		
					//lert(jsonString);
					jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":"); 	
					var json =  jQuery.parseJSON(jsonString);
					json.draw = 1;
					json.iTotalDisplayRecords = json.iTotalRecords;
					delete json.lastNo;
					// for(var key in json.rows){
						//alert(key);
						// delete json.rows[key]['no'];
						// delete json.rows[key]['singkatan'];
						// delete json.rows[key].nama_direktur;
					// }
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "kdlokasi" },
				{ "mData": "kdkabkot" },
				{ "mData": "nmkabkota" }
			],
			"sDom": 'rt<"top"lpi>'
		});	


		$("#emon-kabkota-btn").click(function(){
			//alert("Data telah diekstrak");
			var oTable = $('#emon_kabkota-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_kabkota/ekstrak_data/',
				cache: false,
				dataType: 'json',
				data:{dataTable: oTable.fnGetData()},
				success: function(data){
					if (data=="1") alert("Data telah diekstrak");
					else alert("Data gagal diekstrak");
				}
			});
		});		
		
	});
</script>	   
   