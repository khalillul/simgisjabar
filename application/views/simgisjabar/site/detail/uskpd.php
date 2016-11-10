<div class='detail'>
<div class='r-btn'><i class="icon-cancel fg-red on-left" onclick="getDetail('hide')"></i> Kembali</div>
<div class='title'>Detail Unit SKPD</div>
<div class='dtable'>
	<table class="table detail">
	<tbody>	
		<tr><td width="250px">Kode Unit SKPD</td><td width="5px">:</td><td><?=$unit->kd_uskpd;?></td></tr>
		<tr><td width="250px">Nama Unit SKPD</td><td width="5px">:</td><td><?=$unit->nm_uskpd;?></td></tr>
		<tr><td>Kode Bidang</td><td>:</td><td><?=$unit->kd_bidskpd;?></td></tr>
		<tr><td>Alamat</td><td>:</td><td><?=$unit->alamat;?></td></tr>
		<tr><td>Lokasi Map</td><td>:</td><td><i class="icon-target-2" style="font-size:12px;cursor:pointer;" onclick="showRespondenMap(1)"></i> (lat: <?=$unit->data_map_latitude;?>, lon: <?=$unit->data_map_longitude;?>)</td></tr>
		<tr><td colspan="3">
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
				<?php $i=1;foreach($asets->result() as $aset){?>
					<tr><td><?=$i;?></td><td><?=$aset->no_reg;?></td><td><?=$aset->kd_brg;?></td><td><?=$aset->nm_brg;?></td><td><?=$aset->merek;?></td><td><?=$aset->no_dokumen;?></td><td><a href="#" onclick="showAsetDetail1('<?=$aset->no_reg;?>','<?=$aset->kd_brg;?>')">Detail</a></td></tr>
				<?$i++;}?>
			</tbody>

            <tfoot></tfoot>
        	</table>
		</td></tr>
	</tbody>
	</table>
</div>
</div>