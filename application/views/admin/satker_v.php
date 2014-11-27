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
								  <button type="button" class="btn btn-info" id="emon-ekstrak-btn" style="margin-left:15px;">
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
				</div>
		</div>	
					
	</div>
	
</section>		
 <script>
 
 
	$(document).ready(function(){
		 
		$("#emon-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		
		
		var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun_renstra", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "nama_satker"  },
					  { "mData": "lokasi_satker", "sWidth": "100px" },
					  { "mData": "kode_e1", "sWidth": "60px" }
					]
			load_ajax_datatable2("satker-tbl", '<?=base_url()?>admin/ekstrak_satker/getdata_satker/<?=$tahun_renstra?>/<?=$eselon1?>',columsDef,1,"desc");
			
			
			
			
		$("#emon-btn").click(function(){
			 var tahun = $('#emon-tahun').val();
			 var kode = $('#emon-kode_e1').val();
			
			  if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#emon-periode').select2('open');
				return;
			 }
			
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun_renstra", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "nama_satker"  },
					  { "mData": "lokasi_satker", "sWidth": "100px" },
					  { "mData": "kode_e1", "sWidth": "60px" }
					]
			load_ajax_datatable2("satker-tbl", '<?=base_url()?>admin/ekstrak_satker/getdata_satker/'+tahun+'/'+kode,columsDef,1,"desc");
		});
		
		$("#satker3-btn").click(function(){
			var oTable = $('#satker-tbl').dataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": '<?=base_url()?>admin/ekstrak_satker/getdata_satker',
				"sAjaxDataProp": "data",
				"bJQueryUI": true,
				"scrollY":        "200px",
				"scrollCollapse": true,
			//	"sPaginationType": "full_numbers",
				"iDisplayStart ": 0,
				"iDisplayLength ": 20,
				"bDestroy": true,
				"fnDrawCallback": function ( oSettings ) {
				/* Need to redo the counters if filtered or sorted */
						/*if ( oSettings.bSorted || oSettings.bFiltered )
						{
							for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
							{
								$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
							}
						}*/
					},
				"oLanguage": {
					"sProcessing": "<img src='<?php echo base_url(); ?>static/js/file-uploader/img/loading.gif'>",
					 "sEmptyTable": "Data tidak ditemukan"
				},
				"fnInitComplete": function () {
					//oTable.fnAdjustColumnSizing();
				},
				/*"sColumns": [
				
					{ "data": "tahun_renstra" },
					{ "data": "kode_satker" },
					{ "data": "nama_satker" },
					{ "data": "lokasi_satker" },
					{ "data": "kode_e1" }
				],*/
				 "aoColumns": [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun_renstra", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "nama_satker"  },
					  { "mData": "lokasi_satker", "sWidth": "100px" },
					  { "mData": "kode_e1", "sWidth": "60px" }
					],
				 "fnServerParams": function ( aoData ) {
					  aoData.push( { "name": "more_data", "value": "my_value" } );
					},
				'fnServerData': function (sSource, aData, fnCallback) {
					$.ajax
					({
						'dataType': 'json',
						'type': 'POST',
						'url': sSource,
						'data': aData,
						'success': fnCallback
					});
				}
			});
		});
		
		$("#satker2-btn").click(function(){
			//table_satker.fnDraw();
			alert('herddde');
			 $('#satker-tbl').dataTable({
                "processing": true,
				"serverSide": true,
				"sAjaxSource":"<?=base_url()?>admin/ekstrak_satker/getdata_satker",
					
				 "bDestroy": true,
				  "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
					oSettings.jqXHR = $.ajax({
						url: sSource,
						type: "GET",
						dataType: "json",
						timeout: 0, // prevent timeout
					//	data: aoData,
						complete:function() {
							// Conditional logic goes here for completion
						},
						success: function (json) {
							/* Do whatever additional processing you want on the callback, then tell DataTables */
						//	fnCallback(json)
						}
					});
				},
				"columns": [
					{ "data": "tahun_renstra" },
					{ "data": "kode_satker" },
					{ "data": "nama_satker" },
					{ "data": "lokasi_satker" },
					{ "data": "kode_e1" }
				]
 
           });
		});
		
		
		
		   
		
	});
</script>	   
   