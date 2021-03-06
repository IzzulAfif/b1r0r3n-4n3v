<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Sasaran Program</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_sasarane1-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_sasarane1-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_sasarane1-content">
		<!--main content start-->
				
				
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="sasarane1-tbl">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Kode Eselon I</th>
						<th>Kode Sasaran Strategis</th>
						<th>Kode Sasaran Program</th>
						<th>Deskripsi</th>
					   
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="eperform_sasarane1-content">
					<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="eperform-sasarane1-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_sasarane1-tbl">
					 <thead>
						<tr>
						<th>Tahun</th>
						<th>Kode Eselon I</th>
						<th>Kode Sasaran Strategis</th>
						<th>Kode Sasaran Program</th>
						<th>Deskripsi</th>
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
					 { "mData": "kode_e1" , "sWidth": "100px"},
					 { "mData": "kode_ss_kl" , "sWidth": "100px"},
					 { "mData": "kode_sp_e1" , "sWidth": "100px"},
					  { "mData": "deskripsi"  }
					]
			load_ajax_datatable2("sasarane1-tbl", '<?=base_url()?>admin/ekstrak_sasaran_e1/getdata_sasaran/<?=$periode_renstra?>/<?=$tahun?>',columsDef,1,"desc");
			
		$('#eperform_sasarane1-tbl').dataTable({
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
				{ "mData": "kode_e1" },				
				{ "mData": "kode_sasaran_kl" },
				{ "mData": "kode_sasaran_e1" },
				{ "mData": "deskripsi" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
			
		$("#eperform-sasarane1-btn").click(function(){
			//alert("Data telah diekstrak");
			var oTable = $('#eperform_sasarane1-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_sasaran_e1/ekstrak_data/<?=$tahun?>',
				cache: false,
				dataType: 'json',
				data:{dataTable: oTable.fnGetData()},
				success: function(data){
					if (data=="1") alert("Data telah diekstrak");
					else alert("Data gagal diekstrak");
				}
			});
			//updateDatabase(oTable.fnGetData());
		});			
			
	});
</script>	   
   