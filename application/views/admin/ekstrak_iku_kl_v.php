<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data IKU Kementerian</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_ikukl-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_ikukl-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_ikukl-content">
		<!--main content start-->
				<div class="adv-table">
				<table class="display table table-bordered table-striped" id="iku_kl-tbl">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Kode Kementerian</th>
						<th>Kode IKU</th>
						<th>Deskripsi</th>
						<th>Satuan</th>
						<th>Kode Sasaran Strategis</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				</div>
			<!--main content end-->
			</div>
				<div class="tab-pane fade" id="eperform_ikukl-content">
					<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="eperform-ikukl-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_ikukl-tbl">
					 <thead>
						<tr>
							<th>Tahun</th>
							<th>Kode Kementerian</th>
							<th>Kode IKU</th>
							<th>Deskripsi</th>
							<th>Satuan</th>
							<th>Kode Sasaran Strategis</th>
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
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false,  
					{	"mData": "tahun" , "sWidth": "100px"},
					  { "mData": "kode_kl" , "sWidth": "100px"},
					  { "mData": "kode_iku_kl" , "sWidth": "100px"},					  
					  { "mData": "deskripsi"  },
					  { "mData": "satuan"  },
					  { "mData": "kode_ss_kl" , "sWidth": "100px"}
					]
			load_ajax_datatable2("iku_kl-tbl", '<?=base_url()?>admin/ekstrak_iku_kl/getdata_iku_kl/<?=$periode_renstra?>/<?=$tahun?>',columsDef,1,"desc");
			
		$('#eperform_ikukl-tbl').dataTable({
			"bServerSide": true,
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
				{ "mData": "kode_kl" },				
				{ "mData": "kode_iku_kl" },				
				{ "mData": "deskripsi" },
				{ "mData": "satuan" },
				{ "mData": "kode_sasaran_kl" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		$("#eperform-ikukl-btn").click(function(){		
			var oTable = $('#eperform_ikukl-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_iku_kl/ekstrak_data/<?=$periode_renstra?>/<?=$tahun?>',
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
   