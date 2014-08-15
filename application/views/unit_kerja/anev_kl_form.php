
    <section id="main-content" class="">
        <section class="wrapper">
        
        	<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Form Kementrian
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?=$url?>">
                <?php if(count($data)!=0): ?>
                	<input type="hidden" name="id" value="<?=$data[0]->kode_kl?>" />
				<?php endif; ?>
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode" value="<?=$data[0]->kode_kl?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Kementerian</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" value="<?=$data[0]->nama_kl?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Singkatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="singkatan" value="<?=$data[0]->singkatan?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                        	<div class="pull-right">
                        		<button type="submit" class="btn btn-default btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
                            	<a href="<?=base_url()?>unit_kerja/anev_kl" class="btn btn-danger"><i class="fa fa-times"></i> Batalkan</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        </div>
        </div>
            
        </section>
    </section>