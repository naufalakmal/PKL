<style>
	@media print {
		@page {
			size: 8.267in 5.5in;
			margin: 0;
		}

		.header-pt {
			font-weight: bold;
		}
	}

	.tbl-resi {
		font-size: 11px;
	}

	.table-wrapper {
		border: 1px solid gray;
		border-top: 4px solid gray;
		height: 180px;
		padding-top: 5px;
	}

	.border-bottom {
		border-bottom: 1px solid gray;
	}

	.border-top {
		border-top: 1px solid gray;
	}

	.border-left {
		border-left: 1px solid gray;
	}

	.img-qrcode {
		position: absolute;
		top: 0;
		right: 0;
	}

	.img-logo {
		position: absolute;
		top: 10px;
		left: 20px;
	}
</style>
<div class="content-wrapper print resi">
	<table>
		<tr>
			<td width='450' align="center" valign='top'>
				<img class="img-logo" src="<?php echo base_url("assets/images") . "/logo.png"; ?>" width="100" height="90" />
				<div class='header-pt'>EXPRESS EKSPEDISI</div>
				<div class='header-address'>Jl. Flamboyan</div>
				<div class='header-address'>TEGALARUM - CANGAKAN</div>
				<div class='header-address'>Karanganyar 57713, Indonesia</div>
			</td>
			<td valign='top'>
				<img class="img-qrcode" src="<?php echo base_url("export") . "/" . $data->id_resi . ".png" ?>" width="90" height="90" />
				<div>
					Karanganyar, <?php echo date('d M Y', strtotime($data->tanggal)); ?>
				</div>
				<div class='mt10'>
					KEPADA Yth.
				</div>
				<div>
					<?php echo $data->penerima; ?>
				</div>
				<div class='mt10'>
					<?php echo $data->alamat_penerima; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td rowspan="2">
				<div class='header-pt'>ID RESI No. <?php echo $data->id_resi; ?></div>
			</td>
		<tr>
	</table>
	<div class='table-wrapper'>
		<table style="width:100%" style="mt10" cellpadding='5' cellspacing='0'>
			<tr>
				<th class="border-bottom border-top " height="10">No</th>
				<th class="border-bottom border-top">ID Resi</th>
				<th class="border-bottom border-top">Pelanggan</th>
				<th class="border-bottom border-top">Alamat Pelanggan</th>
				<th class="border-bottom border-top">Penerima</th>
				<th class="border-bottom border-top">Alamat Penerima</th>
				<th class="border-bottom border-top">Telepon Penerima</th>
			</tr>
			<tbody>
				<?php if ($data->id_resi != null) : ?>
					<?php $id_resi = explode("===", $data->id_resi); ?>
					<?php $i = 1; ?>
					<?php foreach ($id_resi as $br) : ?>
						<?php $b = explode("|", $br) ?>
						<tr class="tbl-resi">
							<td align="center" height="10"><?php echo $i; ?></td>
							<td align="center"><?php echo $b[0]; ?></td>
							<td align="center"><?php echo $data->pelanggan; ?></td>
							<td align="center"><?php echo $data->alamat; ?></td>
							<td align="center"><?php echo $data->penerima; ?></td>
							<td align="center"><?php echo  $data->alamat_penerima; ?></td>
							<td align="center"><?php echo $data->telepon_penerima; ?></td>
						</tr>
						<?php $i++; ?>
					<?php endforeach ?>

				<?php endif ?>
			</tbody>
		</table>
	</div>
	<table style="width:100%">
		<tr>
			<td valign='top' style="width:55%">
				<div class='mt10'>
					Jenis Kirm : <?php echo $data->jenis_kirim; ?>
				</div>
				<div class='mt10'>
					Jenis Bayar : <?php echo $data->jenis_bayar; ?>
				</div>
				<div class='mt10'>
					Ongkos Kirim : <?php echo $data->ongkos_kirim; ?>
				</div>
				<div class='mt10'>
					Ongkos Lainnya : <?php echo $data->ongkos_bongkar; ?>
				</div>
				<div class='mt10'>
					Diskon : <?php echo $data->diskon; ?>
				</div>
				<div class='mt10'>
					Total Ongkos : <?php echo $data->ongkos_bersih; ?>
				</div>
			</td>
			<td valign='top' style="width:30%">
				<div class='mt10'>
					Diterima Oleh:
				</div>
			</td>
			<td valign='top' style="width:15%">
				<div class='mt10'>
					Terima Kasih <br> Hormat Kami
				</div>
			</td>
		</tr>
	</table>

</div>
<script>
	$(function() {
		window.print();
	});
</script>