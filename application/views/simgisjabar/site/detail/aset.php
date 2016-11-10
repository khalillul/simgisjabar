<div class='detail'>
<div class='r-btn'><i class="icon-cancel fg-red on-left" onclick="getDetail('hide')"></i> Kembali</div>
<div class='title'>Komoditas</div>
<div class='dtable'>
	<table class="table detail">
	<tbody>	
<!-- 		<tr><td width="250px">No. Register</td><td width="5px">:</td><td><?=$aset->no_reg;?></td></tr>
		<tr><td width="250px">Kode Barang</td><td width="5px">:</td><td><?=$aset->kd_brg;?></td></tr> -->
		<tr><td>Pertanian Unggulan</td><td>:</td><td><?=$aset->nm_brg;?></td></tr>
		<tr><td>Wilayah</td><td>:</td><td><?=$aset->alamat1.' '.$aset->alamat2;?></td></tr>
		<tr><td>Lokasi Map</td><td>:</td><td><i class="icon-target-2" style="font-size:12px;cursor:pointer;" onclick="showRespondenMap(<?=$aset->no_reg;?>)"></i> (lat: <?=$aset->data_map_latitude;?>, lon: <?=$aset->data_map_longitude;?>)</td></tr>
		<tr><td>No. Dokumen</td><td>:</td><td><?=$aset->no_dokumen;?></td></tr>
		<!--tr><td>No. Sertifikat</td><td>:</td><td><?=$aset->no_sertifikat;?></td></tr>
		<tr><td>Tgl. sertifikat</td><td>:</td><td><?=$aset->tgl_sertifikat;?></td></tr-->
		<tr><td>Foto</td><td>:</td><td>
			<img src="<?=base_url().'assets/upload/'.$aset->foto1;?>" width="80px" height="80px"/>
			<img src="<?=base_url().'assets/upload/'.$aset->foto2;?>" width="80px" height="80px"/>
			<img src="<?=base_url().'assets/upload/'.$aset->foto3;?>" width="80px" height="80px"/>
		</td>
		</tr>
	</tbody>
	</table>
	<br>
	<table class="table detail">
		<tr>
			<td colspan="4"><h4><center>PRODUKSI PERTANIAN KECAMATAN</center></h4></td>
		</tr>
		<tr>
			<td width="20px"><center>No</center></td>
			<td width="20px">Komoditas</td>
			<td width="20px">Produksi(TON)</td>
			<td width="20px"><center>Tahun</center></td>
			<td width="20px"><center>Keterangan</center></td>
		</tr>
		<tr>
			<td width="20px"><center>1</center></td>
			<td width="20px">Jagung</td>
			<td width="20px">8,00</td>
			<td width="20px"><center>2016</center></td>
			<td width="20px"><center>-</center></td>
		</tr>
		<tr>
			<td width="20px"><center>1</center></td>
			<td width="20px">Padi</td>
			<td width="20px">7,29</td>
			<td width="20px"><center>2015</center></td>
			<td width="20px"><center>-</center></td>
		</tr>
		<tr>
			<td width="20px"><center>1</center></td>
			<td width="20px">Jagung Hibrida</td>
			<td width="20px">7,25</td>
			<td width="20px"><center>2014</center></td>
			<td width="20px"><center>-</center></td>
		</tr>
	</table>
</div>
</div>