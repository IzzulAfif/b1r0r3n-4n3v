<section class="panel">
	<header class="panel-heading tab-bg-light tab-right ">
		<p class="pull-left"><b>Data Unit Kerja Kementerian</b></p>
		<ul class="nav nav-tabs pull-right">
			<li class="active">
				<a data-toggle="tab" href="#anev_kl-content">
				   <i class="fa fa-cogs"></i> Data di Anev
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#eperform_kl-content">
					<i class="fa fa-bar-chart-o"></i> Data di E-Performance
				</a>
			</li>
			
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
		   <div class="tab-pane fade active in" id="anev_kl-content">
				<!--main content start-->
				
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="kl-tbl">
					<thead>
						<tr>
							<th>Kode</th>
							<th>Nama Kementerian</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
					</div>
				
					<!--main content end-->
		   </div>
			<div class="tab-pane fade" id="eperform_kl-content">
				<div class="row">
					<div class="col-sm-12">
						<div class="pull-left">
							  <button type="button" class="btn btn-info" id="ekstrak-kl-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
				</div>
						<br />
				<div class="adv-table">
					<table class="display table table-bordered table-striped" id="eperform_kl-tbl">
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
		jQuery.support.cors = true;
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kode_kl" , "sWidth": "100px"},
					  { "mData": "nama_kl"  }
						];
					load_ajax_datatable2("kl-tbl", '<?=base_url()?>admin/ekstrak_kl/getdata_kl/<?=$periode_renstra?>',columsDef,1,"desc");
				//	load_ajax_datatable2("eperform_kl-tbl", '<?=$webservice_url?>',columsDef,1,"desc");
					
					 $('#eperform_kl-tbl').dataTable({
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
						//	jsonString = jsonString.replace("\"rows\":", "\"data\":");
								jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":"); 	
								//alert(jsonString);
								var json =  jQuery.parseJSON(jsonString);
								json.draw = 1;
								json.iTotalDisplayRecords = json.iTotalRecords;
								delete json.lastNo;
								for(var key in json.rows){
								//	alert(key);
									delete json.rows[key]['no'];
									//delete json.rows[key]['singkatan'];
									delete json.rows[key].nama_menteri;
								}
								fnCallback(json);
							  //$("#members").show();
							}
						  });
						},
						"aoColumns": [
										{ "mData": "kode_kl" },
							{ "mData": "nama_kl" }
						],
						"sDom": 'rt<"top"lpi>'
					  });
					
					
					
					//load webservice e-performance KL
				/*	$.ajax({			
						url: '<?=$webservice_url?>',
						crossDomain: true,
						// Success function. the 'data' parameter is an array of objects that can be looped over
						success: function(data, textStatus, jqXHR){
							//alert('Successful AJAX request!'+jqXHR);
							var jsonString = JSON.stringify(data, null, 4);
						//	jsonString = jsonString.replace("\"rows\":", "\"data\":");
							jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":");
							var newData = $.parseJSON(jsonString);
							newData.draw = 1;
							newData.iTotalDisplayRecords = newData.iTotalRecords;
							//alert(newData.rows);
							delete newData.lastNo;
							for(var key in newData.rows){
							//	alert(key);
								delete newData.rows[key]['no'];
								delete newData.rows[key]['singkatan'];
								delete newData.rows[key].nama_menteri;
							}
							// delete newData.data[0]['no'];
							// delete newData.data[0]['singkatan'];
							// delete newData.data[0].nama_menteri;
							//alert(newData.data[0].no);
							//var x=JSON.stringify(newData, null, 4);
								 var dataSet = jQuery.map(newData.rows, function(el, i) {
									  return  [el.kode_kl, el.nama_kl];
									});
									var x=JSON.stringify(dataSet, null, 4);
									
								// var dataSet=[];
								// var o = newData.rows;
								// $.each(o,function(i,k){
									// dataSet.push( $.map(o[i], function(el) { return el; }));
									// dataset[] = []
								// });
							//	alert(x);
								// var Listobj = new Array();
								// Listobj.draw = 1;
								// Listobj[0] = new Array({"kode_kl":"022","nama_kl":"Kementerian"});
								// Listobj[1] = new Array({"kode_kl":"033","nama_kl":"Kementerian x"});
								//alert(dataSet);
							//"draw":0,"iTotalRecords":193435,"iTotalDisplayRecords":193435,
								
								$("#eperform_kl-tblxx").dataTable
									({
										"iDisplayStart ": 1,
										"iDisplayLength" : 10, //jumlah default data yang ditampilkan
										"aLengthMenu" : [5,10,25,50,100], //isi combo box menampilkan jumlah data
										"aaSorting" : [[1, 'desc']], //index kolom yg akan di-sorting
										"bProcessing" : true, //show tulisan dan loading bar
										'bServerSide' : true, //ajax server side
										
										"sAjaxDataProp": "rows",
										"sServerMethod" : "POST",
								//		"bDestroy": true,
									//	"aodata":newData ,//.responseJSON
										// "aodata" : [
											// ['022','Kementerian Perhubungan'],
											// ['023','Kementerian Perhubungan 2']
											// ],
										// "columns": [
											// { "title": "KODE" },	
											// { "title": "NAMA	" }],
										 // "columns":[
											// { "title": "Engine" },
											// { "title": "Browser" }
										// "aoColumnDefs":columsDef,
										"aoColumns":columsDef,
									//	"bJQueryUI":true,	
										"scrollX": true	,
										"sDom": 'rt<"top"lpi>',
										'fnServerData' : function(sSource, aoData, fnCallback)
											{
												alert(sSource);
												$.ajax
												({
													'dataType': 'json',
													'type' : 'POST',
													'url' : sSource,
													'data' : aoData,
													'success' : function(json){
															fnCallback(json);
															$(".pop_over").popover();
													}
												});
											}
										});	
																		

						}, 
						// Failed to load request. This could be caused by any number of problems like server issues, bad links, etc. 
						error: function(jqXHR, textStatus, errorThrown){
							alert(jqXHR+' Oh no! A problem with the AJAX request!');
						}
					});
				*/
				
		$('#eperform_kl-tbl tbody').on( 'click', 'tr', function () {
			//ss	alert('tes');
				$(this).toggleClass('active');
		});	
		
		$("#ekstrak-kl-btn").click(function(){
			//alert("Data telah diekstrak");
			//jQuery.support.cors = true;
			var oTable = $('#eperform_kl-tbl').dataTable();
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/ekstrak_kl/ekstrak_data/<?=$periode_renstra?>',
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
   