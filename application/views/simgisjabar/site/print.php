<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Simple responsive css framework">
    <meta name="author" content="Sergey S. Pimenov, Ukraine, Kiev">
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/login/images/logo.png">

    <link href="<?=base_url().'assets/'?>css/metro-bootstrap.css" rel="stylesheet">
    <link href="<?=base_url().'assets/'?>css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="<?=base_url().'assets/'?>css/docs.css" rel="stylesheet">
    <link href="<?=base_url().'assets/'?>js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="<?=base_url().'assets/'?>js/jquery/jquery.min.js"></script>
    <script src="<?=base_url().'assets/'?>js/jquery/jquery.widget.min.js"></script>
    <script src="<?=base_url().'assets/'?>js/jquery/jquery.mousewheel.js"></script>
    <script src="<?=base_url().'assets/'?>js/prettify/prettify.js"></script>
    <script>
    	window.onload = function() {
		    if (window.google) {  
		        // GMaps Loaded  
		        //alert("Yeah!");
		    } else {
		        // GMaps not loaded
		        //alert("Doesn't Work");
		    }
		}
    </script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script>var base_url = "<?=base_url();?>";</script>
    <script src="<?=base_url().'assets/'?>js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="<?=base_url().'assets/'?>js/docs.js"></script>
    <script src="<?=base_url().'assets/'?>js/github.info.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/GeoJSON.js" type="text/javascript"></script>

    <title>SIMGIS JABAR | Sistem Informasi Geografis Pertanian Propinsi Jawa Barat</title>
	
	<?php  
		$BandungProv = file_get_contents(base_url()."assets/peta/map.geojson");
		$BandungDistrik = file_get_contents(base_url()."assets/peta/map.geojson");  
	?>
	<style>
		.fluid-sides{
			width:100px;
		}
		ul li.lgnd a{
			line-height:13px;
			float:left;
			width:160px;
		}
		ul li.lgnd:hover a{
			color:#000;
		}
		ul li.lgnd a img{
			width:13px;height:13px;margin-right:5px;
		}
		.foot-content{
			position:absolute;
			bottom:0;
			width:320px;
			text-align:center;
			padding:10px;
			font-size:12px;
		}
		.details{
			position:absolute;
			bottom:0;
			height:180px;
			width:100%;
			padding-left:350px;
		}
		.details img{
			width:50px;
			float:left;
			margin-top:7px;
			margin-right:10px;
		}
		.details .moredet{
			margin-top:5px;
		}
		.large{
			float:right;
			margin-right: 10px;
			color:#fff !important;
		}
	</style>
	<script type="text/javascript">
		BandungProv = <?php  $BandungProv=str_replace(array("\r", "\n"), '', $BandungProv); echo($BandungProv); ?>;
		BandungDistrik = <?php  $BandungDistrik=str_replace(array("\r", "\n"), '', $BandungDistrik); echo($BandungDistrik); ?>;
	</script>
</head>
<body class="metro">
	<!-- Keperluan Map -->
	<script type="text/javascript">
		var lat = -6.9273;
		var lon = 107.6049;
	</script>
	<script src="<?=base_url().'assets/'?>js/map/maps.js" type="text/javascript"></script>
	<script src="<?=base_url().'assets/'?>js/map/script.js" type="text/javascript"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/highcharts.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/modules/data.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/modules/drilldown.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/datatable.js"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrofgcDdgKW6i2w06DEaLn5hiQjaWTs18&callback=initMap"></script>
	
	<script>
		$(document).ready(function(){   
			$( ".fluid-sides" ).animate({width: "+=15%"}, 100);
			$("#print-btn").click(function(){
				$("#print-btn").hide();
				window.print();
				$("#print-btn").fadeIn();
			});
			ShowTematik(2,'<?=$category;?>');
		});
	</script>
	
	<div id="detail" class="detail-sides">
		
	</div>
	<div id="detail1" class="detail-sides">
		
	</div>
	<div class="fluid-sides">
	<nav id="legends">
		<ul class="side-menu">
			<li style="text-align:center;margin-top:10px"><img src="<?=base_url().'assets/'?>images/compass.png" width="100px" height="120px"/></li>
			<li class="title">Keterangan</li>
			<li class="lgnd" id="lgnd">
				<a href="#" style="font-size:13px !important;"><img src="<?=base_url().'assets/'?>markers/01.png">Pertanian</a>
				<a href="#" style="font-size:13px !important;"><img src="<?=base_url().'assets/'?>markers/02.png">Perikanan</a>
				<a href="#" style="font-size:13px !important;"><img src="<?=base_url().'assets/'?>markers/03.png">Peternakan</a>
				<a href="#" style="font-size:13px !important;"><img src="<?=base_url().'assets/'?>markers/04.png">Perikanan</a>
			</li>
		</ul>
		<div class="foot-content">Skala Peta 1 : 2.500.000<br/>Tanggal Cetak:<br/><?=date("d-m-Y");?></div>
	</nav>
	</div>
	<div class="details">
		<button id="print-btn" class="large bg-cyan"><i class="icon-printer"></i> Cetak</button>
		<img src="<?php echo base_url();?>assets/login/images/logo.png" alt="logo"/>
		<h4>SIMGIS JABAR | Sistem Informasi Geografis </h4>
		<h4>Pertanian Propinsi Jawa Barat</h4>
		<div class="moredet">
			<table class="table detail">
				<tbody>	
					<tr><td width="120px">Bidang</td><td width="5px">:</td><td id="golPrint"></td></tr>
					<tr><td width="100px">Komoditas</td><td width="5px">:</td><td id="bidPrint"></td></tr>
					<tr><td width="100px">Jumlah</td><td width="5px">:</td><td id="cntPrint"></td></tr>
				</tbody>
			</table>
		</div>
	</div>
	<!--<div id="sub-head"></div>-->
	<div id="map-area" style="height:70%;">
	</div>
</body>
</html>