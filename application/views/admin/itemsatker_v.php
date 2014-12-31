<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Item Satker</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_itemsatker-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#emon_itemsatker-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Monitoring
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_itemsatker-content">
	<!--main content start-->    			
			<div class="adv-table">
			<table class="display table table-bordered table-striped" id="itemsatker-tbl">
			<thead>
				<tr>		
					<th>Tahun</th>
					<th>Kode Satker</th>
					<th>Unit Kerja</th>
					<th>Kode Program</th>
					<th>Kode Kegiatan</th>
					<th>Kode Output</th>
					<th>Kode Sub Ouput</th>
					<th>Kode Komponen</th>
					<th>Kode Sub Komponen</th>
					<th>Kode Lokasi</th>
					<th>Kode Kab/Kota</th>
					<th>No.Item</th>
					<th>Nama Item</th>
					<th>Vol.Kegiatan</th>
					<th>Sat.Kegiatan</th>
					<th>Harga Satuan</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
			</div>	
		<!--main content end-->
		</div>
				<div class="tab-pane fade" id="emon_itemsatker-content">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-left">
								  <button type="button" class="btn btn-info" id="emon-itemsatker-btn" style="margin-left:15px;">
										<i class="fa fa-gear"></i> Ekstrak
									</button>
							 </div>
						</div>
					</div>
					<br />
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="emon_itemsatker-tbl">
					 <thead>
						<tr>
							<th>Tahun</th>
							<th>Kode Satker</th>
							<th>Unit Kerja</th>
							<th>Kode Program</th>
							<th>Kode Kegiatan</th>
							<th>Kode Output</th>
							<th>Kode Sub Ouput</th>
							<th>Kode Komponen</th>
							<th>Kode Sub Komponen</th>
							<th>Kode Lokasi</th>
							<th>Kode Kab/Kota</th>
							<th>No.Item</th>
							<th>Nama Item</th>
							<th>Vol.Kegiatan</th>
							<th>Sat.Kegiatan</th>
							<th>Harga Satuan</th>
							<th>Jumlah</th>
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
					  { "mData": "tahun", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "kode_e1" , "sWidth": "70px"},
					  { "mData": "kode_program" , "sWidth": "70px"},
					  { "mData": "kode_kegiatan" , "sWidth": "70px"},
					  { "mData": "kdoutput" , "sWidth": "70px"},
					  { "mData": "kdsoutput" , "sWidth": "70px"},
					  { "mData": "kdkmpnen" , "sWidth": "70px"},
					  { "mData": "kdskmpnen" , "sWidth": "70px"},					  
					  { "mData": "kdlokasi" , "sWidth": "70px"},
					  { "mData": "kdkabkota" , "sWidth": "70px"},
					  { "mData": "noitem" , "sWidth": "70px"},
					  { "mData": "nmitem"  },
					  { "mData": "volkeg", "sWidth": "70px" },
					  { "mData": "satkeg", "sWidth": "60px" },
					  { "mData": "hargasat", "sWidth": "60px" },
					  { "mData": "jumlah", "sWidth": "60px" }
					  
					];
			alert('here');		
			load_ajax_datatable2("itemsatker-tbl", '<?=base_url()?>admin/ekstrak_itemsatker/getdata_itemsatker/<?=$tahun_renstra?>/<?=$tahun?>',columsDef,1,"desc");
			
			
		$('#emon_itemsatker-tbl').dataTable({
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
				{ "mData": "THANG" },
				{ "mData": "KDSATKER" },
				{ "mData": "KODE_E1" },
				{ "mData": "KODE_PROGRAM" },
				{ "mData": "KODE_KEGIATAN" },
				{ "mData": "KDOUTPUT" },
				{ "mData": "KDSOUTPUT" },
				{ "mData": "KDKMPNEN" },
				{ "mData": "KDSKMPNEN" },
				{ "mData": "KDLOKASI" },
				{ "mData": "KDKABKOTA" },
				{ "mData": "NOITEM" },
				{ "mData": "NMITEM" },
				{ "mData": "VOLKEG" },
				{ "mData": "SATKEG" },
				{ "mData": "HARGASAT" },
				{ "mData": "JUMLAH" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		
		
		$("#emon-itemsatker-btn").click(function(){
			var oTable = $('#emon_itemsatker-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_itemsatker/ekstrak_data/<?=$tahun_renstra?>',
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
   