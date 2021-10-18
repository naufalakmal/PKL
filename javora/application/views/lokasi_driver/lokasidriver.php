<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css')?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
	$(function(){
		$('#from').datepicker();
		$('#to').datepicker();
	});
</script>
<div class="content-wrapper master">
	<section class="content-header">
	  <h1>
		<?php echo $title?>
	  </h1>
	</section>
	<?php
		 $msg_err = $this->session->flashdata('admin_save_error');
		 $msg_succes = $this->session->flashdata('admin_save_success');
	?>
	<?php if(!empty($msg_err)): ?>
	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Error!</strong> <?php echo $msg_err;?>
	</div>
	<?php endif; ?>
	<?php if(!empty($msg_succes)): ?>
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Succes!</strong> <?php echo $msg_succes;?>
	</div>
	<?php endif; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">



	
		<div class="panel panel-container">
			<div class="row">



			</div><!--/.row-->
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Lokasi Motor Terkini
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
						<div class="panel-body">
							<div class="canvas-wrapper">
								<div id="map"></div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuqp6YJymNF8Et7Xvd6SO3sBYqu2Bkc88&libraries=places&callback=initMap"></script>
		<script type="text/javascript">
			function initialize() {
				<?php
				$dao = new Dao();
				$marker = $dao->getLokasi();
				echo 'var markers = '.json_encode($marker).';';
				?>
				var mapCanvas = document.getElementById('map');
				var mapOptions = {
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: {lat: -7.782894799999976, lng: 110.36702461349182},
					zoom: 13
				}
				var map = new google.maps.Map(mapCanvas, mapOptions)

				var infowindow = new google.maps.InfoWindow({maxWidth: 400}), marker, i;
				var bounds = new google.maps.LatLngBounds();
				for (i = 0; i < markers.length; i++) {
					pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(pos);
					marker = new google.maps.Marker({
						position: pos,
						map: map,
						animation: google.maps.Animation.BOUNCE
					});
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow.setContent(markers[i][0]);
							infowindow.open(map, marker);
						}
					})(marker, i));
					map.fitBounds(bounds);
				}
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</body>
	</html>
