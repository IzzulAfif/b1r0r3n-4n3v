
                   
                    <div class="panel-body">
                     <header class="panel-heading">
                        Sasaran Kementerian
                        <span class="pull-right">
                            <a href="#" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                   <tr>
                        <th>Tahun Renstra</th>
                        <th>Kementerian</th>
                        <th>Kode Sasaran</th>
                        <th>Sasaran</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->tahun_renstra?></td>
                            <td><?=$d->nama_kl?></td>
                            <td><?=$d->kode_sasaran_kl?></td>
                            <td><?=$d->sasaran_kl?></td>
                            <td>
                            	<a href="#" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    
                    </tbody>
                    </table>
                    </div>
                    </div>
               