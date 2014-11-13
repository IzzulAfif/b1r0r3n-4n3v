
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
					  { "mData": "tahun" , "sWidth": "100px"},
					  { "mData": "kode_iku_e1" , "sWidth": "100px"},
					  { "mData": "deskripsi"  },
					  { "mData": "satuan"  }
					]
			load_ajax_datatable2("iku_e1-tbl", '<?=base_url()?>admin/ekstrak_iku_e1/getdata_iku_e1/',columsDef,1,"desc");
		});
	});
</script>	   
   