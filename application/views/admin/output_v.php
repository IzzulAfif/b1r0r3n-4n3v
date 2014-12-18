<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Output</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_output-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_output-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_output-content">
		<!--main content start-->    
				
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="output-tbl">
				<thead>
					<tr>				
						<th>Kode Kegiatan</th>
						<th>Kode Output</th>
						<th>Nama Output</th>
						<th>Satuan</th>
					</tr>
				</thead>
				<tbody>
				
					
				
				</tbody>
				</table>
				</div>  
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="emon_output-content">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-left">
								  <button type="button" class="btn btn-info" id="emon-output-btn" style="margin-left:15px;">
										<i class="fa fa-gear"></i> Ekstrak
									</button>
							 </div>
						</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="emon_output-tbl">
					 <thead>
						<tr> 
							<th>Kode Kegiatan</th>
							<th>Kode Output</th>
							<th>Nama Output</th>
							<th>Satuan</th>
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
					  { "mData": "kode_kegiatan", "sWidth": "65px" },
					  { "mData": "kdoutput" , "sWidth": "70px"},
					  { "mData": "nmoutput"  },
					  { "mData": "satuan", "sWidth": "60px" }
					]
			load_ajax_datatable2("output-tbl", '<?=base_url()?>admin/ekstrak_output/getdata_output',columsDef,1,"desc");
			
		
		$('#emon_output-tbl').dataTable({
			"bServerSide": false,
			"sAjaxSource": '<?=$webservice_url?>',
			"sAjaxDataProp": "rows",
			"bProcessing": true,
			"bDestroy": true,
			"fnServerParams": function (aoData) {
				
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
				{ "mData": "KDGIAT" },
				{ "mData": "KDOUTPUT" },
				{ "mData": "NMOUTPUT" },
				{ "mData": "SAT" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		
		$("#emon-output-btn").click(function(){
			var oTable = $('#emon_output-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_output/ekstrak_data/',
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
   