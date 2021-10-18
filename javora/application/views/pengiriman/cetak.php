<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
<style>
    @page { size: A4 }

    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }

    .table td {
        padding: 3px 3px;
        border:1px solid #000000;
    }

    .text-center {
        text-align: center;
    }
</style>
<style>
	@media print {
		@page {
			size: 21cm 29.7cm;
	 margin: 30mm 45mm 30mm 45mm;
		}
		.header-pt
		{
			font-weight:bold;
		}
	}
	.tbl-resi
	{
		font-size:11px;
	}
	.table-wrapper
	{
		border:1px solid gray;
		border-top:4px solid gray;
		height:180px;
		padding-top:5px;
	}
	.border-bottom
	{
		border-bottom:1px solid gray;
	}
	.border-top
	{
		border-top:1px solid gray;
	}
	.border-left
	{
		border-left:1px solid gray;
	}
	.img-qrcode
	{
		position:absolute;
		top:0;
		right:0;
	}
	.img-logo
	{
		position:absolute;
		top:10px;
		left:20px;
	}
</style>
<div class="content-wrapper print resi">





	<head>
    <meta charset="utf-8">
    <title>SURAT PENGIRIMAN BARANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
</head>
<body class="A4">
    <section class="sheet padding-10mm">
        <h1>SURAT PENGIRIMAN BARANG</h1>
				<table>
					<tr>
						<td width='450' align="center" valign='top'>
							<img class="img-logo" src="<?php echo base_url("assets/images")."/logo.png"; ?>" width="100" height="90" />
							<div class='header-pt'>PT. Setia Trans Budi</div>
							<div class='header-address'>Jl. Sumarecon</div>
							<div class='header-address'>BANDUNG - MAJALAYA</div>
							<div class='header-address'>Bandung 40000, Indonesia</div>
						</td>
						<td valign='top'>
							<img class="img-qrcode" src="<?php echo base_url("export")."/".$data->id_surat_jalan.".PNG"?>" width="90" height="90" />
							<div >
								Depok, <?php echo date('d M Y',strtotime($data->tanggal)); ?>
							</div>
							<div class='mt10'>
								KEPADA Yth.
							</div>
							<div>
								<?php echo $data->tujuan; ?>
							</div>
							<div class='mt10'>
								<?php echo $data->alamat_tujuan; ?>
							</div>
						</td>
					</tr>
					<tr>
						<td rowspan="2">
							<div class='header-pt'>SURAT JALAN No. <?php echo $data->id_surat_jalan; ?></div>
							<div class="mb10">Harap diterima dengan baik amplop2 tsb. Dibawah ini</div>
						</td>
					<tr>
				</table>

        <table class="table">
            <thead>
                <tr>
									<th class="border-bottom border-top " height="10">No</th>
									<th class="border-bottom border-top">No amplop</th>
									<th class="border-bottom border-top">Nama pengirim</th>
									<th class="border-bottom border-top">Nama penerima</th>
									<th class="border-bottom border-top">Berat</th>
									<th class="border-bottom border-top">Sat</th>
									<th class="border-bottom border-top">Pool</th>
                </tr>
            </thead>
						<tbody>
						<?php if($data->amplop != null): ?>
						<?php $amplop = explode("===",$data->amplop); ?>
						<?php $i = 1; ?>
						<?php foreach($amplop as $br): ?>
						<?php $b = explode("|",$br) ?>
						<tr  class="tbl-resi">
							<td align="center" height="10"><?php echo $i; ?></td>
							<td align="center"><?php echo $b[0]; ?></td>
							<td align="center"><?php echo $b[1]; ?></td>
							<td align="center"><?php echo $b[2]; ?></td>
							<td align="center"><?php echo $b[3]; ?></td>
							<td align="center"><?php echo $b[4]; ?></td>
							<td align="center"><?php echo $b[5]; ?></td>
						</tr>
						<?php $i++; ?>
						<?php endforeach ?>

						<?php endif ?>
					</tbody>
        </table>
				<table style="width:100%">
					<tr>
						<td valign='top' style="width:55%" >
							<div class='mt10'>
								Kendaraan No. <?php echo $data->nopol; ?>
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
    </section>

</div>
<script>
	$(function(){
		window.print();
	});
</script>
