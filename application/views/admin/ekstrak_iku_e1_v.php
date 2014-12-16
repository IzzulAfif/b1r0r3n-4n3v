<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data IKU Eselon I</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_ikue1-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_ikue1-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_ikue1-content">
	<!--main content start-->
		
			<div class="adv-table">
			<table class="display table table-bordered table-striped" id="iku_e1-tbl">
			<thead>
				<tr>
					<th>Tahun</th>
					<th>Kode Unit Kerja</th>
					<th>Kode IKU Kementerian</th>
					<th>Kode IKU Eselon I</th>
					<th>Deskripsi</th>
					<th>Satuan</th>
					<th>Kode Sasaran Program</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
			</div>
		<!--main content end-->
		</div>
				<div class="tab-pane fade" id="eperform_ikue1-content">
					<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="eperform-ikue1-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_ikue1-tbl">
					 <thead>
						<tr>
							<th>Tahun</th>
							<th>Kode Unit Kerja</th>
							<th>Kode IKU Kementerian</th>
							<th>Kode IKU Eselon I</th>
							<th>Deskripsi</th>
							<th>Satuan</th>
							<th>Kode Sasaran Program</th>
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
					  { "mData": "kode_iku_kl" , "sWidth": "100px"},
					  { "mData": "kode_iku_e1" , "sWidth": "100px"},
					  { "mData": "deskripsi"  },
					  { "mData": "satuan"  },
					  { "mData": "kode_sp_e1" , "sWidth": "100px"}
					]
			load_ajax_datatable2("iku_e1-tbl", '<?=base_url()?>admin/ekstrak_iku_e1/getdata_iku_e1/<?=$periode_renstra?>/<?=$tahun?>',columsDef,1,"desc");
			
		$('#eperform_ikue1-tbl').dataTable({
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
						//delete json.rows[key].kode_e2;
					}
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "tahun" },				
				{ "mData": "kode_e1" },				
				{ "mData": "kode_iku_kl" },
				{ "mData": "kode_iku_e1" },				
				{ "mData": "deskripsi" },
				{ "mData": "satuan" },
				{ "mData": "kode_sasaran_e1" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		$("#eperform-ikue1-btn").click(function(){		
			var oTable = $('#eperform_ikue1-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_iku_e1/ekstrak_data/<?=$periode_renstra?>/<?=$tahun?>',
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
   