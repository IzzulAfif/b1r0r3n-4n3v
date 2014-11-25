<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Program Eselon I</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_program-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_program-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_program-content">
		<!--main content start-->
				
				
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="program-tbl">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Kode</th>
						<th>Nama Program</th>
					   
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="eperform_program-content">
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
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_program-tbl">
					 <thead>
						<tr>
							<th>Unit Kerja</th>
							<th>Kode</th>
							<th>Nama Program</th>
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
					 { "mData": "kode_program" , "sWidth": "100px"},
					  { "mData": "nama_program"  }
					]
			load_ajax_datatable2("program-tbl", '<?=base_url()?>admin/ekstrak_program/getdata_program/<?=$periode_renstra?>',columsDef,1,"desc");
			
		$('#eperform_program-tbl').dataTable({
			"bServerSide": true,
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
					//alert(jsonString);
					jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":"); 	
					var json =  jQuery.parseJSON(jsonString);
					json.draw = 1;
					json.iTotalDisplayRecords = json.iTotalRecords;
					delete json.lastNo;
					for(var key in json.rows){
					//	alert(key);
						delete json.rows[key]['no'];						
						delete json.rows[key].kode_e1;
					}
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "nama_e1" },
				{ "mData": "kode_program" },
				{ "mData": "nama_program" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
			
		$("#eperformance-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					{ "mData": "tahun" , "sWidth": "100px"},	
					 { "mData": "kode_program" , "sWidth": "100px"},
					  { "mData": "nama_program"  }
					]
			load_ajax_datatable2("program-tbl", '<?=base_url()?>admin/ekstrak_program/getdata_program/',columsDef,1,"desc");
		});
	});
</script>	   
   