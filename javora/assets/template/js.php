	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script>
		if(window.location.href.indexOf('index') != -1){
			$('#menu-dashboard').addClass("active");
		}
		else if(window.location.href.indexOf('maps') != -1){
			$('#menu-maps').addClass("active");
		}
		else if(window.location.href.indexOf('history') != -1){
			$('#menu-history').addClass("active");
		}
		else if(window.location.href.indexOf('user') != -1){
			$('#menu-user').addClass("active");
		}
		else{
			$('#menu-alat').addClass("active");
		}
	</script>

