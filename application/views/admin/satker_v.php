<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Satker</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_satker-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_satker-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_satker-content">
		<!--main content start-->    
				
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="satker-tbl">
				<thead>
					<tr>
				
						<th>Tahun Renstra</th>
						<th>Kode Satker</th>
						<th>Nama Satker</th>
						<th>Lokasi</th>
						<th>Unit Kerja</th>
					</tr>
				</thead>
				<tbody>
				
					
				
				</tbody>
				</table>
				</div>  
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="emon_satker-content">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-left">
								  <button type="button" class="btn btn-info" id="emon-satker-btn" style="margin-left:15px;">
										<i class="fa fa-gear"></i> Ekstrak
									</button>
							 </div>
						</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="emon_satker-tbl">
					 <thead>
						<tr> 
						<th>Kode Satker</th>
						<th>Nama Satker</th>
						<th>Unit Kerja</th>
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
		
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun_renstra", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "nama_satker"  },
					  { "mData": "lokasi_satker", "sWidth": "100px" },
					  { "mData": "kode_e1", "sWidth": "60px" }
					]
			load_ajax_datatable2("satker-tbl", '<?=base_url()?>admin/ekstrak_satker/getdata_satker/<?=$tahun_renstra?>/<?=$tahun?>',columsDef,1,"desc");
			
		
		$('#emon_satker-tbl').dataTable({
			"bServerSide": false,
			"sAjaxSource": '<?=$webservice_url?>',
			"sAjaxDataProp": "rows",
			"bProcessing": true,
			"bDestroy": true,
			"fnServerParams": function (aoData) {
				aoData.push({ "name": "tahun", "value": '<?=$tahun?>' });
			},
			"fnServerData": function (sSource, aoData, fnCallback) {
			  $.ajax({
				"dataType": 'json',
			//	"contentType": "application/json; charset=utf-8",
				"type": "GET",
				"url": sSource,
				"data": aoData,
				"error": function(jqXHR,textStatus,errorThrown){
					//alert(jqXHR.responseText);
					//alert(jqXHR.responseText.error);
					
				},
				"success": function (msg) {
					var jsonString = JSON.stringify(msg, null, 4);		
				//	alert(jsonString);
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
				{ "mData": "kode_satker" },
				{ "mData": "uraian_satker" },
				{ "mData": "unit_satker" },
				{ "mData": "lokasi_satker" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		
		$("#emon-satker-btn").click(function(){
			var oTable = $('#emon_satker-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_satker/ekstrak_data/<?=$tahun_renstra?>',
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
   