
                   
                    <div class="panel-body">
                     <header class="panel-heading">
                        Sasaran Eselon II
                        <span class="pull-right">
                            <a href="<?=base_url()?>unit_kerja/anev_e2/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                   <tr>
                        <th>Tahun Renstra</th>
                        <th>Unit Kerja</th>
                        <th>Kode Sasaran</th>
                        <th>Sasaran</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php if (isset($data)){foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->tahun_renstra?></td>
                            <td><?=$d->nama_e2?></td>
                            <td><?=$d->kode_sasaran_e2?></td>
                            <td><?=$d->sasaran_e2?></td>
                            <td>
                            	<a href="<?=base_url()?>unit_kerja/anev_e2/edit/<?=$d->kode_e2?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?=base_url()?>unit_kerja/anev_e2/hapus/<?=$d->kode_e2?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; } else {?>
						<tr class="gradeX">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
						<?php }?>
                    
                    </tbody>
                    </table>
                    </div>
                    </div>
               