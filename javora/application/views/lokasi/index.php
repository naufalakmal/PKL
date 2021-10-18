<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<?php echo $title ?>
		</h1>
	</section>

	<section class="content">
		<div id="map" style="height: 500px; width:100%;"</div>
	</section>
	
</div>
<script>
	// Initialize and add the map
	let map;
	let infoObj = [];
	let centerCords = {
		lat: -6.9514391,
		lng: 107.6655465
	};
	const icons = {
		truck: {
			icon: "https://i.ibb.co/x1Tjvpv/truck.png",
		}
	};



	const markersOnMap = [
<?php foreach ($data as $dtT) : ?>
		{
			placeName: "<?php echo $dtT['nama']; ?>",
			keterangan: "Jalan Rancabolang, Jawa Barat 40286, Indonesia",
			LatLng: [{
				lat: <?php echo $dtT['lat']; ?>,
				lng: <?php echo $dtT['long']; ?>
			}],
			type: 'truck'
		},
			<?php endforeach ?>
	]



	function addMarkerInfo() {
		for (let i = 0; i < markersOnMap.length; i++) {
			const contentString =
				'<div id="content">' +
				'<div id="siteNotice">' +
				"</div>" +
				'<b id="firstHeading" class="firstHeading">' + markersOnMap[i].placeName + '</b>' +
				'<div id="bodyContent">' +
				"<small>" + markersOnMap[i].keterangan + "<small>" +
				"</div>" +
				"</div>";

			const marker = new google.maps.Marker({
				position: markersOnMap[i].LatLng[0],
				icon: icons[markersOnMap[i].type].icon,
				label: markersOnMap[i].label,
				map: map,
			});

			const infowindow = new google.maps.InfoWindow({
				content: contentString,
			});
			marker.addListener("click", () => {
				closeOtherInfo();
				infowindow.open({
					anchor: marker,
					map,
					shouldFocus: false,
				});
				infoObj[0] = infowindow;
			});
		}
	}

	function closeOtherInfo() {
		if (infoObj.length > 0) {
			infoObj[0].set("marker", null);
			infoObj[0].close();
			infoObj[0].length = 0;
		}
	}

	function initMap() {
		map = new google.maps.Map(document.getElementById("map"), {
			zoom: 15,
			center: centerCords,
		});
		addMarkerInfo();
	}
</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWHpmBrxgFXImvt81XNvohB1vpGW7w7-g&callback=initMap">
</script>
