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

	.tbl-amplop {
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
<div class="content-wrapper print amplop">
	<table>
		<tr>
			<td width='450' align="center" valign='top'>
				<img class="img-logo" src="<?php echo base_url("assets/images") . "/logo.png"; ?>" width="100" height="90" />
				<div class='header-pt'>STB</div>
				<div class='header-address'>Jl. MAJALAYA</div>
				<div class='header-address'>BANDUNG - MAJALAYA</div>
				<div class='header-address'>BANDUNG 40000, Indonesia</div>
			</td>
			<td valign='top'>
				<img class="img-qrcode" src="<?php echo base_url("export") . "/" . $data->id_amplop . ".png" ?>" width="90" height="90" />
				<div>
					Majalaya, <?php echo date('d M Y', strtotime($data->tanggal)); ?>
				</div>
				<div class='mt10'>
					KEPADA Yth.
				</div>
				<div>
					<?php echo $data->nama_penerima; ?>
				</div>
				<div class='mt10'>
					<?php echo $data->alamat_penerima; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td rowspan="2">
				<div class='header-pt'>ID amplop No. <?php echo $data->id_amplop; ?></div>
			</td>
		<tr>
	</table>
	<div class='table-wrapper'>
		<table style="width:100%" style="mt10" cellpadding='5' cellspacing='0'>
			<tr>
				<th class="border-bottom border-top " height="10">No</th>
				<th class="border-bottom border-top">No Ttb</th>
				<th class="border-bottom border-top">Pengirim</th>
				<th class="border-bottom border-top">Penerima</th>
				<th class="border-bottom border-top">Biaya Ttb</th>
				<th class="border-bottom border-top">Jenis Ttb</th>
				<th class="border-bottom border-top">Qty</th>
				<th class="border-bottom border-top">Sat</th>
			</tr>
			<tbody>
				<?php if ($data->id_amplop != null) : ?>
					<?php $id_amplop = explode("===", $data->id_amplop); ?>
					<?php $i = 1; ?>
					<?php foreach ($id_amplop as $br) : ?>
						<?php $b = explode("|", $br) ?>
						<tr class="tbl-amplop">
							<td align="center" height="10"><?php echo $i; ?></td>
							<td align="center"><?php echo $b[0]; ?></td>
							<td align="center"><?php echo $data->nama_pengirim; ?></td>
							<td align="center"><?php echo $data->nama_penerima; ?></td>
							<td align="center"><?php echo $data->ongkos_bersih; ?></td>
							<td align="center"><?php echo  $data->jenis_kirim; ?></td>
							<td align="center"><?php echo $data->berat_amplop; ?></td>
							<td align="center"><?php echo $data->satuan; ?></td>
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
