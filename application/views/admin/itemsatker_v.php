
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
        <table class="display table table-bordered table-striped" id="satker-tbl">
        <thead>
            <tr>
		
				<th>Tahun</th>
                <th>Kode Satker</th>
                <th>Unit Kerja</th>
                <th>Kode Program</th>
                <th>Kode Kegiatan</th>
                <th>Kode Lokasi</th>
                <th>Kode Kab/Kota</th>
                <th>No.Item</th>
                <th>Nama Item</th>
                <th>Vol.Kegiatan</th>
                <th>Sat.Kegiatan</th>
                <th>Status</th>
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
			var tahun = $('#emon-tahun').val();
			var kode = $('#emon-kode_e1').val();
			
			var columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
					  { "mData": "tahun", "sWidth": "65px" },
					  { "mData": "kode_satker" , "sWidth": "70px"},
					  { "mData": "kode_e1" , "sWidth": "70px"},
					  { "mData": "kode_program" , "sWidth": "70px"},
					  { "mData": "kode_kegiatan" , "sWidth": "70px"},
					  { "mData": "kdlokasi" , "sWidth": "70px"},
					  { "mData": "kdkabkota" , "sWidth": "70px"},
					  { "mData": "noitem" , "sWidth": "70px"},
					  { "mData": "nmitem"  },
					  { "mData": "volkeg", "sWidth": "70px" },
					  { "mData": "satkeg", "sWidth": "60px" },
					  { "mData": "kode_status", "sWidth": "60px" }
					]
			load_ajax_datatable2("satker-tbl", '<?=base_url()?>admin/ekstrak_itemsatker/getdata_itemsatker/'+tahun+'/'+kode,columsDef,1,"desc");
		});
		
		
		
		
		   
		
	});
</script>	   
   