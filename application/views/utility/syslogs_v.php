<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<!-- page start-->
			 <form class="form-horizontal" role="form">  
		
			<!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>System Logs</b></p>
                   
                </header>
				<div class="panel-body ">
					<div class="feed-box">
					<div class="adv-table">
					<table class="display table table-bordered table-striped" id="syslogs-tbl">
					 <thead>
						<tr>
							<th>User</th>
							<th>Login Time</th>
							<th>IP</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
				</div>		
					</div>
				</div>
			</section>	

					
               
                
            </div>
        </section>
    </div>
			  
            <!--tab nav end-->
        </form>
        </section>
    </section>
    <!--main content end-->
	<style type="text/css">
        select {width:100%;}        
    </style>
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {			
			$('#syslogs-tbl').dataTable({
			"bServerSide": true,
			"sAjaxSource": '<?=base_url()?>utility/sys_logs/getdata',
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
					//lert(jsonString);
					jsonString = jsonString.replace("\"total\":", "\"iTotalRecords\":"); 	
					var json =  jQuery.parseJSON(jsonString);
					json.draw = 1;
					json.iTotalDisplayRecords = json.iTotalRecords;
					delete json.lastNo;
					for(var key in json.rows){
					//	alert(key);
						// delete json.rows[key]['no'];
						// delete json.rows[key]['singkatan'];
						// delete json.rows[key].nama_direktur;
					}
					fnCallback(json);
				  //$("#members").show();
				}
			  });
			},
			"aoColumns": [
				{ "mData": "log_user_name" },
				{ "mData": "login_time" },
				{ "mData": "ip" }
			],
			"sDom": 'rt<"top"lpi>'
		});	
		});
	</script>