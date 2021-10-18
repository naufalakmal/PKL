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




</div>

<script>
	$(function() {
		window.print();
	});
</script>
<html>
<head>
	<title>Print kwitansi {{kwitansiNo}}</title>
	<style type="text/css">
			.lead {
				font-family: "Verdana";
				font-weight: bold;
			}
			.value {
				font-family: "Verdana";
			}
			.value-big {
				font-family: "Verdana";
				font-weight: bold;
				font-size: large;
			}
			.td {
				valign : "top";
			}

			/* @page { size: with x height */
			/*@page { size: 20cm 10cm; margin: 0px; }*/
			@page {
				size: A4;
				margin : 0px;
			}
	/*		@media print {
			  html, body {
			  	width: 210mm;
			  }
			}*/
			/*body { border: 2px solid #000000;  }*/
	</style>
	<script type="text/javascript">
		var beforePrint = function() {
		};

		var afterPrint = function() {

			redirect("transaksi_pembayaran_amplop");
		};

		if (window.matchMedia) {
			var mediaQueryList = window.matchMedia('print');
			mediaQueryList.addListener(function(mql) {
				if (mql.matches) {
					beforePrint();
				} else {
					afterPrint();
				}
			});
		}

		window.onbeforeprint = beforePrint;
		window.onafterprint = afterPrint;
    </script>
</head>
<body>

	<?php

	// FUNGSI TERBILANG OLEH : MALASNGODING.COM
	// WEBSITE : WWW.MALASNGODING.COM
	// AUTHOR : https://www.malasngoding.com/author/admin


	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}



	?>

	<table border="1px">
		<tr>

			<td width="80px"><img src="<?php echo base_url("assets/images") . "/logo.png"; ?>" width="80px" /></td>
			<td>
				<table cellpadding="4">
					<tr>
						<td width="200px"><div class="lead">No kwitansi:</td>
						<td><div class="value"><?php echo $data->no_bayar_amplop; ?></div></td>
					</tr>
					<tr>
						<td><div class="lead">Telah terima dari:</div></td>
						<td><div class="value"><?php echo $data->id_pelanggan; ?></div></td>
					</tr>
					<tr>
						<td><div class="lead">Untuk Pembayaran:</div></td>
						<td><div class="value"><?php echo $data->id_amplop; ?></div></td>
					</tr>
					<tr>
						<td><div class="lead">Tanggal:</div></td>
						<td><div class="value"><?php echo $data->tanggal_bayar_amplop; ?></div></td>
					</tr>
					<tr>
						<td><div class="lead">Rupiah:</div></td>
						<td><div class="value-big">Rp. <?php echo $data->terbayar; ?></div></td>
					</tr>
					<tr>
						<td><div class="lead">Uang Sejumlah:</div></td>
						<td><div class="value"><?php echo terbilang($data->terbayar); ?> rupiah</div></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td><div class="lead">Kasir:</div></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>____________________________________________________</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><div class="value">a.n Kasir</div></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<hr>


	<script src="/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			window.print();
		});
	</script>
</body>
</html>
