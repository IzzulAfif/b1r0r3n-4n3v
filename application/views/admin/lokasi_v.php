
<!--main content start-->
	<div class="" id="konten_es2">
    
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
        <table class="display table table-bordered table-striped" id="lokasi-tbl">
        <thead>
            <tr>
				<th>Kode Lokasi</th>
                <th>Lokasi</th>
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
		$("#emon-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		$("#emon-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kdlokasi" , "sWidth": "100px"},
					  { "mData": "lokasi"  }
					]
			load_ajax_datatable2("lokasi-tbl", '<?=base_url()?>admin/ekstrak_lokasi/getdata_lokasi/',columsDef,1,"desc");
		});
	});
</script>	   
   