
<!--main content start-->
	<div class="" id="konten_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-left">
                     <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
        <table class="display table table-bordered table-striped" id="kabkota-tbl">
        <thead>
            <tr>
				<th>Kode Kab/Kota</th>
                <th>Kabupaten/Kota</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>
	</div>                   
    <!--main content end-->
 <script>
	$(document).ready(function(){
		
		$("#emon-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kdkabkota" , "sWidth": "100px"},
					  { "mData": "nama_kabkota"  },
					  { "mData": "latitude" , "sWidth": "150px"},
					  { "mData": "longitude" , "sWidth": "150px"}
					]
			load_ajax_datatable2("kabkota-tbl", '<?=base_url()?>admin/ekstrak_kabkota/getdata_kabkota/',columsDef,1,"desc");
		});
	});
</script>	   
   