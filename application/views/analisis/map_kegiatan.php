  
    <div class="row">
        <div class="col-sm-12">
            
            <div id="gmap-tabs"></div>
            
        </div>
    </div>
    
    <script type="text/javascript">
		
			$(document).ready(function() {
				
				var LocsA = [
							{
								lat: -6.91486,
								lon: 107.60824,
								title: 'Kegiatan B',
								html: [
									'<h5>Nama Kegiatan B</h5>',
									'<p>Detail kegiatan B</p>'
								].join(''),
								draggable: false,
							},
							{
								lat: -1.68149,
								lon: 113.38235,
								title: 'Kegiatan A',
								html: [
									'<h5>Nama Kegiatan A</h5>',
									'<p>Detail kegiatan A</p>'
								].join(''),
								draggable: false,
							},
							{
								lat: -1.33612,
								lon: 133.17472,
								title: 'Kegiatan C',
								html: [
									'<h5>Nama Kegiatan C</h5>',
									'<p>Detail kegiatan C</p>'
								].join(''),
								draggable: false,
							},
							{
								lat: 3.59154,
								lon: 98.66930,
								title: 'Kegiatan D',
								html: [
									'<h5>Nama Kegiatan D</h5>',
									'<p>Detail kegiatan D</p>'
								].join(''),
								draggable: false,
							}
						];

				new Maplace({
					locations: LocsA,
					map_div: '#gmap-tabs',
					controls_on_map: false,
					show_infowindow: true,
					map_options: {
						//set_center: [-65.1750, 106.8283],
						zoom: 5,
					},
					start: 0,
					afterShow: function(index, location, marker) {
						$('#info').html(location.html);
					}
				}).Load();
			});
				
		</script>