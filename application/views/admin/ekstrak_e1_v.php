<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Unit Kerja Eselon I</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_e1-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_e1-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_e1-content">
				<!--main content start-->
					
						<div class="adv-table">
						<table class="display table table-bordered table-striped" id="e1-tbl">
						<thead>
							<tr>
								<th>Kode</th>
								<th>Nama Unit Kerja</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
						</table>
						</div>
					                
					<!--main content end-->
				</div>
				<div class="tab-pane fade" id="eperform_e1-content">
					<div class="row">
							<div class="col-sm-12">
								<div class="pull-left">
									  <button type="button" class="btn btn-info" id="ekstrak-e1-btn" style="margin-left:15px;">
											<i class="fa fa-gear"></i> Ekstrak
										</button>
								 </div>
							</div>
						</div>
						<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_e1-tbl">
					 <thead>
						<tr>
							<th>Kode</th>
							<th>Nama Unit Kerja</th>
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
					  { "mData": "kode_e1" , "sWidth": "100px"},
					  { "mData": "nama_e1"  }
					];
		
		load_ajax_datatable2("e1-tbl", '<?=base_url()?>admin/ekstrak_e1/getdata_e1/<?=$periode_renstra?>',columsDef,1,"desc");
		
		$('#eperform_e1-tbl').dataTable({
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
						delete json.rows[key]['singkatan'];
						delete json.rows[key].nama_dirjen;
					}
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "kode_e1" },
				{ "mData": "nama_e1" }
			],
			"sDom": 'rt<"top"lpi>'
		});
					  
					  
		$("#ekstrak-e1-btn").click(function(){
			//alert("Data telah diekstrak");
			var oTable = $('#eperform_e1-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_e1/ekstrak_data/<?=$periode_renstra?>',
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
   