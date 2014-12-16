<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Kegiatan Eselon II</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_kegiatan-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_kegiatan-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_kegiatan-content">
		<!--main content start-->							
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="kegiatan-tbl">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Kode Eselon II</th>
						<th>Kode Program</th>
						<th>Kode Kegiatan</th>
						<th>Nama Kegiatan</th>					   
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>             
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="eperform_kegiatan-content">
					<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="eperform-kegiatan-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
					<div class="adv-table">
						<table class="display table table-bordered table-striped" id="eperform_kegiatan-tbl">
						 <thead>
							<tr>
								<th>Tahun</th>
								<th>Kode Eselon II</th>
								<th>Kode Program</th>
								<th>Kode Kegiatan</th>
								<th>Nama Kegiatan</th>
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
		$("#eperform-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },			
					{ "mData": "tahun" , "sWidth": "100px"},		
					  { "mData": "kode_e2" , "sWidth": "100px"},
					  { "mData": "kode_program" , "sWidth": "100px"},
					  { "mData": "kode_kegiatan" , "sWidth": "100px"},
					  { "mData": "nama_kegiatan"  }
					]
			load_ajax_datatable2("kegiatan-tbl", '<?=base_url()?>admin/ekstrak_kegiatan/getdata_kegiatan/<?=$periode_renstra?>/<?=$tahun?>',columsDef,1,"desc");
		
		$('#eperform_kegiatan-tbl').dataTable({
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
				"success": function (msg) {
					var jsonString = JSON.stringify(msg, null, 4);		
					//alert(jsonString);
					jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":"); 	
					var json =  jQuery.parseJSON(jsonString);
					json.draw = 1;
					json.iTotalDisplayRecords = json.iTotalRecords;
					delete json.lastNo;
					for(var key in json.rows){
					//	alert(key);
						delete json.rows[key]['no'];						
						//delete json.rows[key].kode_e1;
					}
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "tahun" },				
				{ "mData": "kode_e2" },				
				{ "mData": "kode_program" },				
				{ "mData": "kode_kegiatan" },
				{ "mData": "nama_kegiatan" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		$("#eperform-kegiatan-btn").click(function(){		
			var oTable = $('#eperform_kegiatan-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_kegiatan/ekstrak_data/<?=$periode_renstra?>/<?=$tahun?>',
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
   