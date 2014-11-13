
<!--main content start-->
	<div class="" id="konten_es2">
    
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
        <table class="display table table-bordered table-striped" id="kegiatan-tbl">
        <thead>
            <tr>
				<th>Kode</th>
                <th>Nama Kegiatan</th>
               
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
		$("#eperform-ekstrak-btn").click(function(){
			alert("Data telah diekstrak");
		});
		$("#eperformance-btn").click(function(){		
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },					
					  { "mData": "kode_kegiatan" , "sWidth": "100px"},
					  { "mData": "nama_kegiatan"  }
					]
			load_ajax_datatable2("kegiatan-tbl", '<?=base_url()?>admin/ekstrak_kegiatan/getdata_kegiatan/',columsDef,1,"desc");
		});
	});
</script>	   
   