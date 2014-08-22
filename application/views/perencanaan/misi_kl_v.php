
                   
                    <div class="panel-body">
                     <header class="panel-heading">
                        Misi Kementerian
                        <span class="pull-right">
                            <a href="<?=base_url()?>unit_kerja/anev_kl/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                   <tr>
                        <th>Tahun Renstra</th>
                        <th>Kementerian</th>
                        <th>Kode Misi</th>
                        <th>Misi</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->tahun_renstra?></td>
                            <td><?=$d->nama_kl?></td>
                            <td><?=$d->kode_misi_kl?></td>
                            <td><?=$d->misi_kl?></td>
                            <td>
                            	<a href="<?=base_url()?>unit_kerja/anev_kl/edit/<?=$d->kode_kl?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?=base_url()?>unit_kerja/anev_kl/hapus/<?=$d->kode_kl?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    
                    </tbody>
                    </table>
                    </div>
                    </div>
               