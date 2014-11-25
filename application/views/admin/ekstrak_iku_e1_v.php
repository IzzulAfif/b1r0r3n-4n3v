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
					<th>Kode</th>
					<th>Deskripsi</th>
					<th>Satuan</th>
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
							  <button type="button" class="btn btn-info" id="eperform-ekstrak-btn" style="margin-left:15px;">
									<i class="fa fa-gear"></i> Ekstrak
								</button>
						 </div>
					</div>
					</div>
					<br />
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
					  { "mData": "kode_iku_e1" , "sWidth": "100px"},
					  { "mData": "deskripsi"  },
					  { "mData": "satuan"  }
					]
			load_ajax_datatable2("iku_e1-tbl", '<?=base_url()?>admin/ekstrak_iku_e1/getdata_iku_e1/<?=$periode_renstra?>',columsDef,1,"desc");
		$("#eperformance-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "tahun" , "sWidth": "100px"},
					  { "mData": "kode_iku_e1" , "sWidth": "100px"},
					  { "mData": "deskripsi"  },
					  { "mData": "satuan"  }
					]
			load_ajax_datatable2("iku_e1-tbl", '<?=base_url()?>admin/ekstrak_iku_e1/getdata_iku_e1/',columsDef,1,"desc");
		});
	});
</script>	   
   