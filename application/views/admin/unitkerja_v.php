
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
        <table class="display table table-bordered table-striped" id="unitkerja-tbl">
        <thead>
            <tr>		
				<th>Tahun Renstra</th>
                <th>Kode unitkerja</th>
                <th>Nama unitkerja</th>
                <th>Lokasi</th>
                <th>Unit Kerja</th>
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
		$("#eperformance-btn").click(function(){
			var id = $('#eperformance-tipe_data').val();
			var kode = $('#eperformance-kode_e1').val();			
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun_renstra", "sWidth": "65px" },
					  { "mData": "kode_unitkerja" , "sWidth": "70px"},
					  { "mData": "nama_unitkerja"  },
					  { "mData": "lokasi_unitkerja", "sWidth": "100px" },
					  { "mData": "kode_e1", "sWidth": "60px" }
					]
			if  ("<?=$webservice_url?>" ==="")
				alert("Alamat Web Service belum tersedia");
			else
				load_ajax_datatable2("unitkerja-tbl", '<?=base_url()?>admin/ekstrak_unitkerja/getdata_unitkerja/'+id,columsDef,1,"desc");
		});		
	});
</script>	   
   