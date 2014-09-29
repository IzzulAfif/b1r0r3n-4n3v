
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
			
            <!--<tr>		
				<th>Tahun Renstra</th>
                <th>Kode </th>
                <th>Nama Unit Kerja</th>
                <th>Lokasi</th>
                <th>Unit Kerja</th>
            </tr>-->
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
					];
			//alert("<?=$webservice_url?>");
			if  ("<?=$webservice_url?>" ==="")
				alert("Alamat Web Service belum tersedia");
			else {
				switch (id) {
					case "1" : //KL
					break;
					case "2" : //eselon1
					break;
					case "3" : //eselon2
						columsDef =  [
					 // { "mData": "row_number", "sWidth": "5px", "bSearchable": false, "bSortable": false  },
						  { "mData": "no", "sWidth": "5px" },
						  { "mData": "kode_e2", "sWidth": "65px" },
						  { "mData": "kode_e1" , "sWidth": "70px"},
						  { "mData": "nama_e1"  },
						  { "mData": "nama_e2"  },
						  { "mData": "singkatan", "sWidth": "100px" },
						  { "mData": "nama_direktur", "sWidth": "100px" },
						  { "mData": "nip", "sWidth": "100px" },
						  { "mData": "pangkat", "sWidth": "100px" },
						  { "mData": "gol", "sWidth": "60px" }
						];
					break;
				}
				
				$.ajax({			
					url: '<?=$webservice_url?>',
					// Success function. the 'data' parameter is an array of objects that can be looped over
					success: function(data, textStatus, jqXHR){
						//alert('Successful AJAX request!'+jqXHR);
						var jsonString = JSON.stringify(data, null, 4);
						jsonString = jsonString.replace("\"rows\":", "\"data\":");
						jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":");
						data = $.parseJSON(jsonString);
						data['draw'] = 1;
						data['iTotalDisplayRecords'] = data['iTotalRecords'];
						//"draw":0,"iTotalRecords":193435,"iTotalDisplayRecords":193435,
						$("#unitkerja-tbl").dataTable
								({
									"iDisplayStart ": 0,
									"iDisplayLength" : 10, //jumlah default data yang ditampilkan
									"aLengthMenu" : [5,10,25,50,100], //isi combo box menampilkan jumlah data
									"aaSorting" : [[1, 'desc']], //index kolom yg akan di-sorting
									"bProcessing" : true, //show tulisan dan loading bar
									'bServerSide' : true, //ajax server side
									
									"sAjaxDataProp": "rows",
									"sServerMethod" : "POST",
									"bDestroy": true,
									 "aoColumns":columsDef,
									 "aaData":data,
									"bJQueryUI":true,	
									"scrollX": true	,
									"sDom": 'rt<"top"lpi>',
									});
						//alert("<pre>" +JSON.stringify(data, null, 4) + "</pre>");
				//	document.write(JSON.stringify(data, null, 4));
					//	document.write("<pre>" +JSON.stringify(data, null, 4) + "</pre>");
									   
						/*var obj = JSON.parse(data)[1];
						obj.data = obj.rows;
						delete obj.rows;

						json = JSON.stringify([obj]);
						*/

					}, 
					// Failed to load request. This could be caused by any number of problems like server issues, bad links, etc. 
					error: function(jqXHR, textStatus, errorThrown){
						alert('Oh no! A problem with the AJAX request!');
					}
				});
				
				//load_ajax_datatable2("unitkerja-tbl",'<?=$webservice_url?>',columsDef,1,"desc");
			}	
		});		
	});
</script>	   
   