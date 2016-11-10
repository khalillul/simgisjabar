<div class='detail'>
<div class='r-btn'><i class="icon-cancel fg-red on-left" onclick="getDetail('hide')"></i> Kembali</div>
<div class='title'>Simpan Lokasi Unit SKPD</div>
<div class='dtable' style='overflow:hidden; padding-bottom:0px;'>
	<table class="table detail">
	<tbody>	
		<tr><td width="250px">Kode Unit SKPD</td><td width="5px">:</td><td><?=$unit->kd_uskpd;?></td></tr>
		<tr><td width="250px">Nama Unit SKPD</td><td width="5px">:</td><td><?=$unit->nm_uskpd;?></td></tr>
		<tr><td>Kode Bidang</td><td>:</td><td><?=$unit->kd_bidskpd;?></td></tr>
		<tr><td>Alamat</td><td>:</td><td><?=$unit->alamat;?></td></tr>
		<tr><td>Lokasi Map</td><td>:</td><td><i class="icon-target-2" style="font-size:12px;cursor:pointer;" onclick="showRespondenMap(<?=$unit->kd_uskpd;?>)"></i> (lat: <span class="text-warning"><?=$data_map_latitude;?></span>, lon: <span class="text-warning"><?=$data_map_longitude;?></span>)</td></tr>
		<!--tr><td colspan="3">
			<table class="table bordered hovered">
            <thead>
            <tr>
                <th class="text-left" width="10px">No</th>
                <th class="text-left">No. Reg</th>
                <th class="text-left">Kode Barang</th>
                <th class="text-left">Nama Barang</th>
                <th class="text-left">Merek</th>
                <th class="text-left">No. Dokumen</th>
                <th class="text-left">Detail</th>
            </tr>
            </thead>

            <tbody>
            <tr><td>1</td><td>0:00:01</td><td>0,1 Mb</td><td>0 Mb</td><td>0,1 Mb</td><td>0,1 Mb</td><td><a href="#">Detail</a></td></tr>
            </tbody>

            <tfoot></tfoot>
        	</table>
		</td></tr-->
	</tbody>
	</table>
    <div class='r-btn' style="clear:both; padding-right:0px"><i class="icon-checkmark fg-green on-left" onclick="confSaveUnit('<?=$unit->kd_uskpd;?>')"></i> Simpan</div>
</div>
</div>