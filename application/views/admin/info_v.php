
<!--main content start-->
	<div class="" id="konten_info">
    
 		<div class="row">
            <div class="col-sm-12">
                    
                    <div class="form">
                        <form action="<?=base_url()?>admin/pengaturan/save_info" class="form-horizontal" method="post">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea class="form-control ckeditor" id="editor1" name="info" rows="6"><?=$info_text?></textarea>
                                </div>
                            </div>
                         	<div class="pull-right">
                            	<button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </form>
                    </div>
                    
            </div>
        </div>
	</div> 
    
    <script type="text/javascript" src="<?=base_url()?>static/js/ckeditor/ckeditor.js"></script>
    <script>
	CKEDITOR.replace( 'editor1', {
	/*toolbar: [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', 'Print', '-', 'Templates' ] },
				['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
				['Undo', 'Redo' ],
				{ name: 'links', items: [ 'Link', 'Unlink'] },
				{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'Maximize'] },
			]*/
	});
</script>