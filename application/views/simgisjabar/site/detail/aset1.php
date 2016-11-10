<div class='detail'>
<div class='r-btn'><i class="icon-cancel fg-red on-left" onclick="getDetail1('hide')"></i> Kembali</div>
<div class='title'>Detail Asetddd</div>
<div class='dtable'>
	<table class="table detail">
	<tbody>	
		<tr><td width="250px">No. Register</td><td width="5px">:</td><td><?=$aset->no_reg;?></td></tr>
		<tr><td width="250px">Kode Barang</td><td width="5px">:</td><td><?=$aset->kd_brg;?></td></tr>
		<tr><td>Nama Barang</td><td>:</td><td><?=$aset->nm_brg;?></td></tr>
		<tr><td>Unit SKPD</td><td>:</td><td><?=$aset->nm_uskpd;?></td></tr>
		<tr><td>No. Dokumen</td><td>:</td><td><?=$aset->no_dokumen;?></td></tr>
		<tr><td>Keterangan</td><td>:</td><td><?=$aset->keterangan;?></td></tr>
		<tr><td>Foto</td><td>:</td><td>
			<img src="<?=base_url().'assets/upload/'.$aset->foto;?>" width="80px" height="80px"/>
		</td></tr>
	</tbody>
	</table>
</div>
</div>