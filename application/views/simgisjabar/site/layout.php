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

  <!--   <script src="<?=base_url().'assets/'?>js/bootstrap-select.js"></script>-->
    <link rel="stylesheet" href="<?=base_url().'assets/'?>css/bootstrap-select.css"> 

    <!-- Load JavaScript Libraries -->
     <script src="<?=base_url().'assets/'?>js/jquery/jquery.min.js"></script> 
    <script src="<?=base_url().'assets/'?>js/jquery/jquery.widget.min.js"></script>
    <script src="<?=base_url().'assets/'?>js/jquery/jquery.mousewheel.js"></script>
    <script src="<?=base_url().'assets/'?>js/prettify/prettify.js"></script>


    <!-- Metro UI CSS JavaScript plugins -->
    <script>var base_url = "<?=base_url();?>";</script>
    <script src="<?=base_url().'assets/'?>js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="<?=base_url().'assets/'?>js/docs.js"></script>
    <script src="<?=base_url().'assets/'?>js/github.info.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/GeoJSON.js" type="text/javascript"></script>

	<!-- Latest compiled and minified CSS -->


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->



    <title>SIMGIS JABAR | Sistem Informasi Geografis Pertanian Propinsi Jawa Barat</title>
	
<!-- 	<?php  
		$BandungProv = file_get_contents(base_url()."assets/peta/map.geojson");
		$BandungDistrik = file_get_contents(base_url()."assets/peta/map.geojson");  
	?>
	<script type="text/javascript">
		BandungProv = <?php  $BandungProv=str_replace(array("\r", "\n"), '', $BandungProv); echo($BandungProv); ?>;
		BandungDistrik = <?php  $BandungDistrik=str_replace(array("\r", "\n"), '', $BandungDistrik); echo($BandungDistrik); ?>;
	</script> -->
</head>
<body class="metro">
	<!-- Keperluan Map -->
	<script type="text/javascript">
		// var lat = -7.0909;
		// var lon = 107.6689;
		//location center
		var lat = -6.9273;
		var lon = 107.6049;
	</script>

<!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrofgcDdgKW6i2w06DEaLn5hiQjaWTs18&callback=initMap"></script> -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	<script src="<?=base_url().'assets/'?>js/map/maps.js" type="text/javascript"></script>
	<script src="<?=base_url().'assets/'?>js/map/script.js" type="text/javascript"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/highcharts.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/modules/data.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/highcharts/modules/drilldown.js"></script>
	<script src="<?=base_url().'assets/'?>js/map/datatable.js"></script>
    <script>
    	window.onload = function() {
		    if (window.google) {  
		        // GMaps Loaded  
		        //alert("Yeah!");
		    } else {
		        // GMaps not loaded
		        //alert("Doesn't Work");
				 $.Notify({
					caption: "Warning",
					content: "Google Map Tidak Dapat Dimuat<br/>Mohon Cek Koneksi Anda",
					style:{background: 'red', color: 'white'}
				});
		    }
		}
    </script>
	
	<header class="bg-dark" data-load="<?=base_url().'index.php/site/'?>layout_header"></header>
	<div id="pencarian" class="sidebar-container">
		<nav class="sidebar light">
			<ul>
				<li class="title">Filter Pertanian</li>
				<li>
				<div style='overflow: hidden;'>


				<div class="input-control select" id="filter_gol_cont">


					 <?php
					//mysql_connect("localhost", "root","") or die(mysql_error());
					//mysql_select_db("db_simgis_jabar") or die(mysql_error());

					$query = "SELECT kd_wilayah,nm_wilayah FROM mwilayah ORDER BY kd_wilayah DESC LIMIT  0,6";
					$result = mysql_query($query) or die(mysql_error()."[".$query."]");
					?>
			
					<select name="categories" id="filter_wil"  data-live-search="true" >
					<option value="nol">-- Wilayah  --</option>
					<?php 
					while ($row = mysql_fetch_array($result))
					{
					   
					echo "<option value='" . $row['kd_wilayah'] . "'>" . $row['nm_wilayah'] . "</option>";
					}
					?>        
					</select>





				</div>
				<div id="filter_bid_cont" class="input-control select">
					<select id="filter_bid" onchange="getFilKelompok()">
						<option value="nol">-- Komoditas  --</option>
					</select>
				</div>
				<button class="search-btn" onclick="getFilter()"><i class="icon-search on-left"></i>Cari</button>
				</div>
				</li>
				<li class="title">Hasil Pencarian</li>
				<li class="result">
				<div id="search_result">
				</div>
				</li>
			</ul>
		</nav>
	</div>
	<!-- mengambil dari table mbidangs-->
	<div id="tematik" class="sidebar-container">
		<nav class="sidebar light">
			<ul>
				<li class="title">Komoditas</li>
				<li class="stick bg-green">
					<a class="dropdown-toggle bg-hover-green" href="#"><i class="icon-layers"></i>Tanaman Pangan</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[1]->result() as $bid){?>
							<li><a href="#" onclick="ShowTematik(1,'<?php echo $bid->bidang?>')"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li>
 				<li class="stick bg-blue">
					<a class="dropdown-toggle" href="#"><i class="icon-dashboard"></i>Hortikultura</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[2]->result() as $bid){?>
							<li><a href="#" onclick="ShowUnits(1,'<?php echo $bid->bidang?>')"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li>
<!-- 				<li class="stick bg-orange">
					<a class="dropdown-toggle bg-hover-orange" href="#"><i class="icon-home"></i>Peternakan</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[3]->result() as $bid){?>
							<li><a href="#" onclick="ShowTematik(1,'<?php echo $bid->bidang?>')"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li> -->
<!-- 				<li class="stick bg-yellow">
					<a class="dropdown-toggle bg-hover-yellow" href="#"><i class="icon-dashboard"></i>Perkebunan</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[4]->result() as $bid){?>
							<li><a href="#"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li> -->
<!-- 				<li class="stick bg-amber">
					<a class="dropdown-toggle bg-hover-amber" href="#"><i class="icon-stats"></i>Aset Tetap Lainnya</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[5]->result() as $bid){?>
							<li><a href="#"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li>
				<li class="stick bg-red">
					<a class="dropdown-toggle bg-hover-orange" href="#"><i class="icon-cone"></i>Konstruksi Dalam Pengerjaan</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<?php foreach($bidang[6]->result() as $bid){?>
							<li><a href="#"><?php echo $bid->nm_bidang;?></a></li>
						<?}?>
					</ul>
				</li> -->
			</ul>
		</nav>
	</div>
	<div id="detail" class="detail-sides">
		
	</div>
	<div id="detail1" class="detail-sides">
		
	</div>
	<div class="fluid-sides">
	<nav id="legends">
		<ul class="side-menu">
			<li class="title">Legend</li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010101.png" style="width:16px;height:16px;margin-right:5px">Padi</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010102.png" style="width:16px;height:16px;margin-right:5px">Jagung</a></li>
<!-- 			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010104.png" style="width:16px;height:16px;margin-right:5px">Pisang</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Jeruk Garut</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Durian</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Krisan</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Anggrek</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Polyscias</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Bawang Merah</a></li>	
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Cabai Merah</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Kapulaga</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Kubis</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Ubi Jalas</a></li>
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Kacang Tanah</a></li>	
			<li><a href="#"><img src="<?=base_url().'assets/'?>markers/010103.png" style="width:16px;height:16px;margin-right:5px">Kacang Hijau</a></li>					 -->
		</ul>
	</nav>
	</div>
	<a href="#" id="fluid-button" class="fluid-button"><i class="icon-compass-3"></i></a>
	<!--<div id="sub-head"></div>-->
	<div id="map-area">
	</div>
</body>
</html>