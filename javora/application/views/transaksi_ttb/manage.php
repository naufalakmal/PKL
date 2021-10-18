<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css') ?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript">
	function CheckNo(sender) {
		if (!isNaN(sender.value)) {
			if (sender.value > 100)
				sender.value = 100;
			if (sender.value < 0)
				sender.value = 0;
		} else {
			sender.value = 0;
		}
	}
</script>

<script>
	var selectedmodal = 1;
	var lastBarang = <?php echo $data->barang != "" ? json_encode($data->barang) : '[]' ?>;
	$(function() {
		$('button[type="reset"]').click(function(evt) {
			evt.preventDefault();
			$(this).closest('form').get(0).reset();

			if (lastBarang.length == 0)
				$("table.tblbarang tbody").html("");
			else {
				$("table.tblbarang tbody").html("");
				var rbarang = lastBarang.split("===");

				$(rbarang).each(function(i, d) {
					rb = d.split("|");

					br = "<tr>";
					br += "<td><input type='hidden' name='detail[id_barang][]' value='" + rb[0] + "'>" + rb[0] + "</td>";
					br += "<td>" + rb[1] + "</td>";
					br += "<td>" + rb[2] + "</td>";
					br += "<td>" + rb[4] + "</td>";
					br += "<td><input type='text' class='form-control' name='detail[jumlah][" + rb[0] + "]' value='" + rb[4] + "' size='5' ></td>";
					br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deleteBarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
					br += "</tr>";
					$("table.tblbarang tbody").append(br);
				});
			}
		});

		$("form[name='save']").on("keyup keypress", function(e) {
			var code = e.keyCode || e.which;
			if (code == 13) {
				e.preventDefault();
				$(this).blur();
				return false;
			}
		});

		$('#ref-table-barang').on('show.bs.modal', function(e) {
			selectedmodal = 1;
			$(".table-ajax-barang").empty();
			getBarang(1);
		});

		$('#ref-table-pelanggan').on('show.bs.modal', function(e) {
			selectedmodal = 2;
			$(".table-ajax-pelanggan").empty();
			getPelanggan(1);
		});

		$('#ref-table-tarif').on('show.bs.modal', function(e) {
			selectedmodal = 3;
			$(".table-ajax-tarif").empty();
			getTarif(1);
		});

		$('#ref-table-tujuan').on('show.bs.modal', function(e) {
			selectedmodal = 4;
			$(".table-ajax-tujuan").empty();
			getTujuan(1);
		});

		$('#ref-table-viapool').on('show.bs.modal', function(e) {
			selectedmodal = 5;
			$(".table-ajax-viapool").empty();
			getViapool(1);
		});




		$(".search-barang").click(function() {
			getBarang(1);
		});

		$(".search-pelanggan").click(function() {
			getPelanggan(1);
		});

		$(".search-tarif").click(function() {
			getTarif(1);
		});

		$(".search-tujuan").click(function() {
			getTujuan(1);
		});

		$(".search-viapool").click(function() {
			getViapool(1);
		});



		$("body").on('click', '#ref-table-barang .pagination a', function(e) {
			getBarang(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-pelanggan .pagination a', function(e) {
			getPelanggan(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-tarif .pagination a', function(e) {
			getTarif(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-tujuan .pagination a', function(e) {
			getTujuan(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-viapool .pagination a', function(e) {
			getViapool(getUrlVars(e.target.href)['page']);
			return false;
		});



		$("input[name='tanggal']").datepicker();


		$("form[name='save']").submit(function(event) {

			if ($("input[name='id_pelanggan']").val() == "") {
				$(".error-wrapper").html("<div class='alert alert-danger'>" +
					"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
					" <strong>Error!</strong> Pilih pelanggan dahulu" +
					"</div>");
				return false;
			}

			if ($("input[name='id_tarif']").val() == "") {
				$(".error-wrapper").html("<div class='alert alert-danger'>" +
					"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
					" <strong>Error!</strong> Pilih tarif dahulu" +
					"</div>");
				return false;
			}

			if ($("input[name='id_tujuan']").val() == "") {
				$(".error-wrapper").html("<div class='alert alert-danger'>" +
					"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
					" <strong>Error!</strong> Pilih tujuan dahulu" +
					"</div>");
				return false;
			}




			var kode = $("table.tblbarang tbody input[name='detail[id_barang][]']");
			if (kode.length > 0) {
				hasError = false;
				hasLessZero = false;
				$(kode).each(function(i, d) {
					var jumlah = $("table.tblbarang tbody input[name='detail[qty][" + $(d).val() + "]']").val();
					if (isNaN(jumlah))
						hasError = true;
					else {
						if (jumlah <= 0)
							hasLessZero = true;
					}
				});

				if (hasError) {
					$(".error-wrapper").html("<div class='alert alert-danger'>" +
						"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
						" <strong>Error!</strong> format qty tidak benar" +
						"</div>");

					return false;
				} else if (hasLessZero) {
					$(".error-wrapper").html("<div class='alert alert-danger'>" +
						"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
						" <strong>Error!</strong> jumlah tidak boleh kurang dari 1" +
						"</div>");
				} else
					return;
			} else {
				$(".error-wrapper").html("<div class='alert alert-danger'>" +
					"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
					" <strong>Error!</strong> pilih barang dahulu" +
					"</div>");

				return false;
			}
			return false;
		});

	});

	function getBarang(page) {
		dt = {
			"keyword": $("#keyword-barang").val(),
			'page': page
		};
		var kode = $("table.tblbarang tbody input[type='hidden']");
		if (kode.length > 0) {
			$kc = [];
			$(kode).each(function(i, d) {
				$kc[i] = $(this).val();
			});

			dt = {
				"keyword": $("#keyword-barang").val(),
				'page': page,
				barang: $kc
			};
		}
		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTableBarang"); ?>",
			data: dt,
			success: function(d) {
				$(".table-ajax-barang").empty();
				$(".table-ajax-barang").html(d);
			}
		});
	}

	function getPelanggan(page) {

		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTablePelanggan"); ?>",
			data: {
				"keyword": $("#keyword-pelanggan").val(),
				'page': page
			},
			success: function(d) {
				$(".table-ajax-pelanggan").empty();
				$(".table-ajax-pelanggan").html(d);
			}
		});
	}

	function getTarif(page) {

		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTableTarif"); ?>",
			data: {
				"keyword": $("#keyword-tarif").val(),
				'page': page
			},
			success: function(d) {
				$(".table-ajax-tarif").empty();
				$(".table-ajax-tarif").html(d);
			}
		});
	}

	function getTujuan(page) {

		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTableTujuan"); ?>",
			data: {
				"keyword": $("#keyword-tujuan").val(),
				'page': page
			},
			success: function(d) {
				$(".table-ajax-tujuan").empty();
				$(".table-ajax-tujuan").html(d);
			}
		});
	}

	function getViapool(page) {

		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTableViapool"); ?>",
			data: {
				"keyword": $("#keyword-viapool").val(),
				'page': page
			},
			success: function(d) {
				$(".table-ajax-viapool").empty();
				$(".table-ajax-viapool").html(d);
			}
		});
	}



	function pilih(id, nama, other, other2, other3) {
		if (selectedmodal == 1) {
			$br = "<tr>";
			$br += "<td><input type='hidden' name='detail[id_barang][]' value='" + id + "'>" + id + "</td>";
			$br += "<td>" + nama + "</td>";
			$br += "<td>" + other + "</td>";
			$br += "<td>" + other2 + "</td>";
			$br += "<td><input type='text' class='form-control' name='detail[qty][" + id + "]' value='1' size='5'></td>";
			$br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deleteBarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
			$br += "</tr>";
			$("table.tblbarang tbody").append($br);
		} else if (selectedmodal == 2) {
			$("input[name='id_pelanggan']").val(id);
			$("input[name='nama_pengirim']").val(nama);
			$("textarea[name='alamat_pengirim']").val(other);
			$("input[name='hp_pengirim']").val(other2);
			$("input[name='hutang']").val(other3);
		} else if (selectedmodal == 3) {
			$("input[name='kecamatan']").val(nama);
			$("input[name='kota']").val(other);
			$("textarea[name='provinsi']").val(other2);
			$("textarea[name='tarif']").val(other3);
		} else if (selectedmodal == 4) {
			diskon = 0;
			ongkos_bongkar = 0;
			bayar = 0;
			qty = 1;

			ongkos_kirim = qty * other;
			sub_biaya = ongkos_kirim + ongkos_bongkar;

			total_biaya = sub_biaya - diskon;
			kembalian = bayar - total_biaya;

			$("input[name='id_tujuan']").val(id);
			$("input[name='nama_tujuan']").val(nama);
			$("input[name='tarif']").val(other);
			$("input[name='id_via_tujuan']").val(id);
			$("input[name='nama_via_tujuan']").val(nama);
			$("input[name='tarif_deal']").val(other);
			$("input[name='diskon']").val(diskon);
			$("input[name='ongkos_bongkar']").val(ongkos_bongkar);
			$("input[name='berat_amplop']").val(qty);
			$("input[name='ongkos_kirim']").val(ongkos_kirim);
			$("input[name='ongkos_bersih']").val(total_biaya);
			$("input[name='bayar_amplop']").val(bayar);
			$("input[name='kembalian_amplop']").val(kembalian);

		} else if (selectedmodal == 5) {
			$("input[name='id_via_tujuan']").val(id);
			$("input[name='nama_via_tujuan']").val(nama);

		}

	}

	function hitungTotalBiaya() {
		qty = parseInt(myform.berat_amplop.value);
		tarif_deal = parseInt(myform.tarif_deal.value);

		ongkos_bongkar = parseInt(myform.ongkos_bongkar.value);
		diskon = parseInt(myform.diskon.value);
		bayar = parseInt(myform.bayar_amplop.value);



		ongkos_kirim = qty * tarif_deal;
		diskon1 = (diskon / 100) * ongkos_kirim;
		sub_biaya = ongkos_kirim + ongkos_bongkar;

		total_biaya = sub_biaya - diskon1;
		kembalian = bayar - total_biaya;

		myform.ongkos_kirim.value = ongkos_kirim;
		myform.ongkos_bersih.value = total_biaya;
		myform.kembalian_amplop.value = kembalian;

	}

	function getUrlVars(url) {
		var vars = [],
			hash;
		var hashes = url.slice(url.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	function deleteBarang(a) {
		$(a).closest("tr").remove()
	}

	function hitungOngkosKirim() {
		num1 = parseInt(myform.tarif.value);
		num2 = parseInt(myform.berat_amplop.value);
		num3 = parseInt(myform.tarif_opsi.value);
		if (num3 > 0) {
			result = num3 * num2;
			myform.ongkos_kirim.value = result;
		} else {
			result = num1 * num2;
			myform.ongkos_kirim.value = result;
		}

	}

	function hitungOngkosBersih() {
		num1 = parseInt(myform.ongkos_kirim.value);
		num2 = parseInt(myform.ongkos_bongkar.value);
		num3 = parseInt(myform.diskon.value);
		result1 = num1 + num2;
		diskon = (num3 / 100) * result1;
		result2 = result1 - diskon;
		myform.ongkos_bersih.value = result2;
	}

	function hitungKembalianAmplop() {
		num1 = parseInt(myform.bayar_amplop.value);
		num2 = parseInt(myform.ongkos_bersih.value);
		result = num1 - num2;
		myform.kembalian_amplop.value = result;
	}
</script>

<div class="content-wrapper master">
	<section class="content-header">
		<h1>
			<?php echo $title ?>
		</h1>
	</section>
	<div class="error-wrapper">
		<?php
		$msg_err = $this->session->flashdata('admin_save_error');
		$msg_succes = $this->session->flashdata('admin_save_success');
		?>
		<?php if (!empty($msg_err)) : ?>
			<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Error!</strong> <?php echo $msg_err; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($msg_succes)) : ?>
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Succes!</strong> <?php echo $msg_succes; ?>
			</div>
		<?php endif; ?>
	</div>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<form name="myform" class="form-horizontal" method="post" action="<?php echo site_url("transaksi_ttb/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_amplop; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id_amplop" class="col-sm-2 control-label">ID Transaksi_ttb</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_amplop" name="id_amplop" value="<?php echo $data->id_amplop == "" ? $data->autocode : $data->id_amplop; ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
								<div class="col-sm-4">
									<input type="text" required="required" class="form-control datepicker" id="tanggal" data-date-format="dd/mm/yyyy" placeholder="select tanggal" name="tanggal" value="<?php echo $data->tanggal != "" ? date("d/m/Y", strtotime($data->tanggal)) : date("d/m/Y"); ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="id_pelanggan" class="col-sm-2 control-label">Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="id_pelanggan" placeholder="pilih pelanggan" name="id_pelanggan" value="<?php echo $data->id_pelanggan; ?>" readonly />
								</div>
								<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#ref-table-pelanggan" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="pelanggan" class="col-sm-2 control-label">Nama Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="pelanggan" name="nama_pengirim" value="<?php echo $data->pelanggan; ?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label for="alamat" class="col-sm-2 control-label">Alamat</label>
								<div class="col-sm-7">
									<textarea class="form-control" rows="3" id="alamat" name="alamat_pengirim" readonly><?php echo $data->alamat; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="telepon" class="col-sm-2 control-label">Telepon Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" rows="3" id="hp_pengirim" name="hp_pengirim" value="<?php echo $data->hp_pengirim; ?>" readonly></input>
								</div>
							</div>

							<div class="form-group">
								<label for="telepon" class="col-sm-2 control-label">Hutang</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" rows="3" id="hutang" name="hutang" value="<?php echo $data->hutang; ?>" readonly></input>
								</div>
							</div>

							<div class="form-group">
								<label for="tarif" class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="nama_kirim" name="nama_penerima" value="<?php echo $data->nama_penerima; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="telepon_kirim" class="col-sm-2 control-label">Telepon</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" rows="3" id="telepon_kirim" name="hp_penerima" value="<?php echo $data->hp_penerima; ?>"></input>
								</div>
							</div>

							<div class="form-group">
								<label for="alamat_kirim" class="col-sm-2 control-label">Alamat</label>
								<div class="col-sm-7">
									<textarea class="form-control" rows="3" id="alamat_kirim" name="alamat_penerima"><?php echo $data->alamat_penerima; ?></textarea>
								</div>
							</div>



							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label">Tujuan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="kecamatan" placeholder="pilih tujuan" name="id_tujuan" value="<?php echo $data->id_tujuan; ?>" readonly />
								</div>
								<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#ref-table-tujuan" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="kota" name="nama_tujuan" value="<?php echo $data->nama_tujuan; ?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label">Tarif</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="tarif" name="tarif" value="<?php echo $data->tarif_awal; ?>" readonly />
								</div>
							</div>

							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label">Via Pool</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="kecamatan" placeholder="pilih pool" name="nama_via_tujuan" value="<?php echo $data->nama_via_tujuan; ?>" readonly />
								</div>
								<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#ref-table-viapool" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>

							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label"></label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="kota" name="id_via_tujuan" value="<?php echo $data->id_via_tujuan; ?>" hidden />
								</div>
							</div>

							<div class="form-group">
								<label for="tujuan" class="col-sm-2 control-label">Tarif Deal</label>
								<div class="col-sm-7">
									<input type="number" onChange="hitungTotalBiaya()" class="form-control" id="tarif_deal" name="tarif_deal" value="<?php echo $data->tarif; ?>" />
								</div>
							</div>


							<div class="col-sm-5">
								<div class="form-group">
									<label for="berat_amplop" class="col-sm-5 control-label">Qty</label>
									<div class="col-sm-7">
										<input type="number" onChange="hitungTotalBiaya()" class="form-control" required="required" id="berat_amplop" name="berat_amplop" placeholder="input berat" value="<?php echo $data->berat_amplop; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="jenis_kirim" class="col-sm-5 control-label">Satuan</label>
									<div class="col-sm-7">
										<select class="form-control" name="satuan" required="required">
											<option value="Bal" <?php echo $data->satuan == "Bal" ? ' selected' : ''; ?>>BAL</option>
											<option value="Karung" <?php echo $data->satuan == "Karung" ? ' selected' : ''; ?>>KARUNG</option>
											<option value="Dus" <?php echo $data->satuan == "Dus" ? ' selected' : ''; ?>>DUS</option>
											<option value="Kg" <?php echo $data->satuan == "Kg" ? ' selected' : ''; ?>>KG</option>
											<option value="Semple" <?php echo $data->satuan == "Semple" ? ' selected' : ''; ?>>SEMPLE</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="jenis_kirim" class="col-sm-5 control-label">Jenis Amplop</label>
									<div class="col-sm-7">
										<select class="form-control" name="jenis_kirim" required="required">
											<option value="COD" <?php echo $data->jenis_kirim == "COD" ? ' selected' : ''; ?>>COD</option>
											<option value="REGULER" <?php echo $data->jenis_kirim == "REGULER" ? ' selected' : ''; ?>>REGULER</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="jenis_bayar" class="col-sm-5 control-label">Jenis Pembayaran</label>
									<div class="col-sm-7">
										<select class="form-control" name="jenis_bayar" required="required">
											<option value="CASH" <?php echo $data->jenis_bayar == "CASH" ? ' selected' : ''; ?>>CASH</option>
											<option value="KREDIT" <?php echo $data->jenis_bayar == "KREDIT" ? ' selected' : ''; ?>>KREDIT</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="ongkos_kirim" class="col-sm-5 control-label">Biaya Kirim</label>
									<div class="col-sm-7">

										<input type="number" onChange="hitungTotalBiaya()" class="form-control" required="required" id="ongkos_kirim" name="ongkos_kirim" value="<?php echo $data->ongkos_kirim; ?>" readonly>
									</div>
								</div>
							</div>

							<div class="col-sm-5">
								<div class="form-group">
									<label for="ongkos_bongkar" class="col-sm-5 control-label">Biaya Lainnya</label>
									<div class="col-sm-7">
										<input type="number" onChange="hitungTotalBiaya()" class="form-control" required="required" id="ongkos_bongkar" name="ongkos_bongkar" placeholder="input ongkos lainnya" value="<?php echo $data->ongkos_bongkar; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="diskon" class="col-sm-5 control-label">Diskon</label>
									<div class="col-sm-7">
										<input type="number" min="0" max="100" onblur="CheckNo(this)" onChange="hitungTotalBiaya()" class="form-control" required="required" id="diskon" name="diskon" value="<?php echo $data->diskon; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="ongkos_bersih" class="col-sm-5 control-label">Total Ongkos</label>
									<div class="col-sm-7">

										<input type="text" class="form-control" required="required" id="ongkos_bersih" name="ongkos_bersih" value="<?php echo $data->ongkos_bersih; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="bayar_amplop" class="col-sm-5 control-label">Bayar</label>
									<div class="col-sm-7">
										<input type="number" onChange="hitungKembalianAmplop()" class="form-control" required="required" id="bayar_amplop" name="bayar_amplop" placeholder="input bayar" value="<?php echo $data->bayar_amplop; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="kembalian_amplop" class="col-sm-5 control-label">Kembalian</label>
									<div class="col-sm-7">

										<input type="text" class="form-control" required="required" id="kembalian_amplop" name="kembalian_amplop" value="<?php echo $data->kembalian_amplop; ?>" readonly>
									</div>
								</div>
								<hr>
							</div>


							<div class="row">

							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
								<button type="submit" class="btn btn-success" name="action" value="saveexit" onclick="downlaod()">save & exit</button>
								<button type="reset" class="btn btn-warning">reset</button>
								<a href="<?php echo site_url("transaksi_ttb") ?>" class="btn btn-danger">cancel</a>
							</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="ref-table-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Barang</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-barang" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-barang">Search</button>
						</form>
					</div>
				</div>

				<div class="table-ajax-barang">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ref-table-pelanggan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Pelanggan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-pelanggan" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-pelanggan">Search</button>
						</form>
					</div>
				</div>

				<div class="table-ajax-pelanggan">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ref-table-tarif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Tarif</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-tarif" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-tarif">Search</button>
						</form>
					</div>
				</div>

				<div class="table-ajax-tarif">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ref-table-tujuan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Tarif</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-tujuan" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-tujuan">Search</button>
						</form>
					</div>
				</div>

				<div class="table-ajax-tujuan">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ref-table-viapool" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Pool</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-viapool" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-viapool">Search</button>
						</form>
					</div>
				</div>

				<div class="table-ajax-viapool">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function fillPrice() {
		var str = $("#jenis_tarif").val()
		str = str.split(",");
		//alert(str[1]);
		$("#ongkos_kirim").val(str[1] * $("#berat_amplop").val());
	}

	function calculateTotal() {
		var ongkir = parseInt($("#ongkos_kirim").val());
		var ongkar = parseInt($("#ongkos_bongkar").val());
		var diskon = (100 - parseFloat($("#diskon").val())) / 100;
		$("#ongkos_bersih").val((ongkir + ongkar) * diskon);
	}

	function calculateChange() {
		var total = parseInt($("#ongkos_bersih").val());
		var nayar = parseInt($("#bayar_amplop").val());
		$("#kembalian_amplop").val(bayar - total);
	}
</script>