<div class='detail'>
<div class='r-btn'><i class="icon-cancel fg-red on-left" onclick="getDetail('hide')"></i> Kembali</div>
<div class='title'>Simpan Lokasi Aset</div>
<div class='dtable' style='overflow:hidden; padding-bottom:0px;'>
	<table class="table detail">
	<tbody>	
		<tr><td width="250px">No. Register</td><td width="5px">:</td><td><?=$aset->no_reg;?></td></tr>
		<tr><td width="250px">Kode Barang</td><td width="5px">:</td><td><?=$aset->kd_brg;?></td></tr>
		<tr><td>Nama Barang</td><td>:</td><td><?=$aset->nm_brg;?></td></tr>
		<tr><td>Alamat</td><td>:</td><td><?=$aset->alamat1.' '.$aset->alamat2;?></td></tr>
		<tr><td>Lokasi Map</td><td>:</td><td><i class="icon-target-2" style="font-size:12px;cursor:pointer;" onclick="showRespondenMap(<?=$aset->no_reg;?>)"></i> (lat: <span class="text-warning"><?=$data_map_latitude;?></span>, lon: <span class="text-warning"><?=$data_map_longitude;?></span>)</td></tr>
		<tr><td>No. Dokumen</td><td>:</td><td><?=$aset->no_dokumen;?></td></tr>
		<!--tr><td>No. Sertifikat</td><td>:</td><td><?=$aset->no_sertifikat;?></td></tr>
		<tr><td>Tgl. sertifikat</td><td>:</td><td><?=$aset->tgl_sertifikat;?></td></tr-->
		<tr><td>Foto</td><td>:</td><td>
			<img src="<?=base_url().'assets/upload/'.$aset->foto1;?>" width="80px" height="80px"/>
			<img src="<?=base_url().'assets/upload/'.$aset->foto2;?>" width="80px" height="80px"/>
			<img src="<?=base_url().'assets/upload/'.$aset->foto3;?>" width="80px" height="80px"/>
		</td></tr>
	</tbody>
	</table>
	<div class='r-btn' style="clear:both; padding-right:0px"><i class="icon-checkmark fg-green on-left" onclick="confSaveAset('<?=$aset->no_reg;?>')"></i> Simpan</div>
</div>
</div>