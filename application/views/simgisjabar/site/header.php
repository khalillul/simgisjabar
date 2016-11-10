<div class="navigation-bar fixed-top dark">
    <div class="navigation-bar-content"> 
        <a href="#" class="element" onclick="loadAsetMenu()"><span class="icon-location"></span> SIMGIS JABAR </a>
        <span class="element-divider"></span>

        <a class="element1 pull-menu" href="#"></a>
        <ul class="element-menu">
<!--             <li><a href="#" onclick="loadAsetMenu()">Peta Tematik</a></li> -->
            <li><a href="#" onclick="loadSearchMenu(false,false)">Pencarian</a></li>
        </ul>
<!-- 
        <input type="hidden" id="category" value=""/>
        <a class="element element-menu" href="#" onclick="loadPrintMenu(getCategory())">Show Wilayah Jawa Barat</a> -->
		<!-- <div class="element"> -->
            <!-- <a class="dropdown-toggle" href="#">Penambahan Titik</a>
            <ul class="dropdown-menu" data-role="dropdown">
                <li><a href="#" onclick="loadSearchMenu(false,true)">Lokasi Aset Pertanian</a></li>
                <!-- <li><a href="#" onclick="loadSearchMenu(true, true)">Lokasi SKPD</a></li> -->
            <!-- </ul> -->
     <!--    //</div> -->
		<input type="hidden" id="category" value=""/>
        <a class="element element-menu" href="#" onclick="loadPrintMenu(getCategory())">Cetak Peta</a>
        <div class="element">
            <a class="dropdown-toggle" href="#">Lihat Data Detail</a>
            <ul class="dropdown-menu" data-role="dropdown">
                <li><a href="#">Per Propinsi</a></li>
                <li><a href="#">Per Wilayah</a></li>
            </ul>
        </div>
<!--         <div class="element no-display">
            <a href="one-page-example.html" class="fg-yellow">Big Example</a>
        </div> -->

<!--         <a class="element place-right" href="<?=base_url().'index.php/auth/logout';?>" title="Log Out"><span class="icon-exit"></span></a>
        <span class="element-divider place-right"></span> -->
<!--         <button class="element image-button image-left place-right">
            Administrator
            <img src="<?=base_url().'assets/'?>images/default.png"/>
        </button> -->
    </div>
</div>
