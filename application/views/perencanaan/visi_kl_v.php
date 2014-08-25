<div class="panel-body">
 <header class="panel-heading">
	Visi Kementerian
	<span class="pull-right">
		<a href="#" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
	 </span>
</header>
<div class="adv-table">
<table  class="display table table-bordered table-striped" id="dynamic-table">
<thead>
<tr>
	<th width="20px">Tahun Renstra</th>
	<th>Kementerian</th>
	<th>Kode Visi</th>
	<th>Visi</th>
	<th width="10%">Aksi</th>
</tr>
</thead>
<tbody>

	

</tbody>
</table>
</div>
</div>

 <script>
		$(document).ready(function(){
			load_ajax_datatable('dynamic-table','<?=base_url()?>perencanaan/rencana_kl/loadvisi_table');
		});
	</script>               