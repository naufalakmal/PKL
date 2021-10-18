<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css') ?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>

<script>
	var selectedmodal = 1;
	var lastbarang = <?php echo $data->barang != "" ? json_encode($data->barang) : '[]' ?>;
	$(function() {
		$('button[type="reset"]').click(function(evt) {
			evt.preventDefault();
			$(this).closest('form').get(0).reset();

			if (lastbarang.length == 0)
				$("table.tblbarang tbody").html("");
			else {
				$("table.tblbarang tbody").html("");
				var rbarang = lastbarang.split("===");

				$(rbarang).each(function(i, d) {
					rb = d.split("|");

					br = "<tr>";
					br += "<td><input type='hidden' name='detail[id_barang][]' value='" + rb[0] + "'>" + rb[0] + "</td>";
					br += "<td>" + rb[1] + "</td>";
					br += "<td>" + rb[2] + "</td>";
					br += "<td>" + rb[4] + "</td>";
					br += "<td><input type='text' class='form-control' name='detail[jumlah][" + rb[0] + "]' value='" + rb[4] + "' size='5' ></td>";
					br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deletebarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
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
			getbarang(1);
		});

		$('#ref-table-pelanggan').on('show.bs.modal', function(e) {
			selectedmodal = 2;
			$(".table-ajax-pelanggan").empty();
			getPelanggan(1);
		});

		$('#ref-table-tujuan').on('show.bs.modal', function(e) {
			selectedmodal = 4;
			$(".table-ajax-tujuan").empty();
			gettujuan(1);
		});

		$('#ref-table-tarif').on('show.bs.modal', function(e) {
			selectedmodal = 3;
			$(".table-ajax-tarif").empty();
			gettarif(1);
		});


		$(".search-barang").click(function() {
			getbarang(1);
		});

		$(".search-pelanggan").click(function(){
			getPelanggan(1);
		});

		$(".search-tujuan").click(function() {
			gettujuan(1);
		});

		$(".search-tarif").click(function() {
			gettarif(1);
		});

		$("body").on('click', '#ref-table-barang .pagination a', function(e) {
			getbarang(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-pelanggan .pagination a', function (e) {
			getPelanggan(getUrlVars(e.target.href)['page']);
			return false;
	    });

		$("body").on('click', '#ref-table-tujuan .pagination a', function(e) {
			gettujuan(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("body").on('click', '#ref-table-tarif .pagination a', function(e) {
			gettarif(getUrlVars(e.target.href)['page']);
			return false;
		});

		$("input[name='tanggal']").datepicker();


		$("form[name='save']").submit(function(event) {

			if($("input[name='id_pelanggan']").val() == "")
			{
					$(".error-wrapper").html("<div class='alert alert-danger'>"
					 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
					 + " <strong>Error!</strong> Pilih pelanggan dahulu"
					 + "</div>");
				return false;
			}

			if ($("input[name='id_tarif']").val() == "") {
				$(".error-wrapper").html("<div class='alert alert-danger'>" +
					"<a href='#' class='close' data-dismiss='alert'>&times;</a>" +
					" <strong>Error!</strong> Pilih tarif dahulu" +
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

	function getbarang(page) {
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
			url: "<?php echo site_url("api/ajax/getTablebarang"); ?>",
			data: dt,
			success: function(d) {
				$(".table-ajax-barang").empty();
				$(".table-ajax-barang").html(d);
			}
		});
	}

	function getPelanggan(page)
	{

		$.ajax({
			  dataType: "html",
			  url: "<?php echo site_url("api/ajax/getTablePelanggan");?>",
			  data:{"keyword":$("#keyword-pelanggan").val(),'page':page},
			  success:function(d){
				  $(".table-ajax-pelanggan").empty();
				  $(".table-ajax-pelanggan").html(d);
				}
		});
	}

	function gettujuan(page) {

		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTabletujuan"); ?>",
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

	function gettarif(page) {
		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTabletarif"); ?>",
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

	function pilih(id, nama, other, other2, other3) {
		if (selectedmodal == 1) {
			$br = "<tr>";
			$br += "<td><input type='hidden' name='detail[id_barang][]' value='" + id + "'>" + id + "</td>";
			$br += "<td>" + nama + "</td>";
			$br += "<td>" + other + "</td>";
			$br += "<td>" + other2 + "</td>";
			$br += "<td><input type='text' class='form-control' name='detail[qty][" + id + "]' value='1' size='5'></td>";
			$br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deletebarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
			$br += "</tr>";
			$("table.tblbarang tbody").append($br);
		} else if(selectedmodal == 2)
		{
			$("input[name='id_pelanggan']").val(id);
			$("input[name='pelanggan']").val(nama);
			$("textarea[name='alamat']").val(other);
		} else if (selectedmodal == 3) {
			$("input[name='kecamatan']").val(nama);
			$("input[name='kota']").val(other);
			$("input[name='provinsi']").val(other);
			$("textarea[name='provinsi']").val(other2);
			$("input[name='tarif']").val(other3);
		} else if (selectedmodal == 4) {
			$("input[name='id_tujuan']").val(id);
			$("input[name='nama_tujuan']").val(nama);
			$("textarea[name='alamat_tujuan']").val(other2);
		}
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

	function deletebarang(a) {
		$(a).closest("tr").remove()
	}


	function hitungOngkosKirim() {
		num1 = parseInt(myform.tarif.value);
		num2 = parseInt(myform.berat_amplop.value);
		result = num1 * num2;
		myform.ongkos_kirim.value = result;
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
					<form name="myform" class="form-horizontal" method="post" action="<?php echo site_url("transaksi_amplop/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_amplop; ?>">
						<div class="box-body" id="div_body">
							<div class="form-group">
								<label for="id_amplop" class="col-sm-2 control-label">No Resi</label>
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
							<hr>

							<div class="form-group">
								<label for="id_pelanggan" class="col-sm-2 control-label">Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="id_pelanggan" placeholder="pilih pelanggan" name="id_pelanggan" value="<?php echo $data->id_pelanggan; ?>" readonly />
								</div>
								<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ref-table-pelanggan" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="pelanggan" class="col-sm-2 control-label">Nama Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="<?php echo $data->nama_pengirim; ?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label for="telepon" class="col-sm-2 control-label">Telepon Pelanggan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" rows="3" id="hp_pengirim" name="hp_pengirim" value="<?php echo $data->hp_pengirim; ?>" readonly></input>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat" class="col-sm-2 control-label">Alamat Pelanggan</label>
								<div class="col-sm-7">
									<textarea class="form-control" rows="3" id="alamat_pengirim" name="alamat_pengirim" readonly><?php echo $data->alamat_pengirim; ?></textarea>
								</div>
							</div>
							<section class="content-header">
								<HR>
								<h1>
									PENERIMA
								</h1>
							</section>



							<hr>

						</div>

						<div class="row">
							<div class="col-sm-5">
								<div class="form-group">
									<label for="tarif" class="col-sm-5 control-label">Nama</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="nama_kirim" name="nama_penerima" value="" />
									</div>
								</div>
								<div class="form-group">
									<label for="telepon_kirim" class="col-sm-5 control-label">Telepon</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" rows="3" id="telepon_kirim" name="hp_penerima" value=""></input>
									</div>
								</div>

								<div class="form-group">
									<label for="alamat_kirim" class="col-sm-5 control-label">Alamat</label>
									<div class="col-sm-7">
										<textarea class="form-control" rows="3" id="alamat_kirim" name="alamat_penerima"></textarea>
									</div>
								</div>
							</div>

							<div class="col-sm-5">

								<div class="form-group">
								<label for="id_tarif" class="col-sm-5 control-label">Kecamatan</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="kecamatan" placeholder="pilih tarif" name="kecamatan" value="<?php echo $data->kecamatan; ?>" readonly  />
								</div>
								<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#ref-table-tarif" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="tarif" class="col-sm-5 control-label">Kota</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="kota"  name="kota" value="<?php echo $data->kota; ?>" readonly  />
								</div>
							</div>
							<div class="form-group">
								<label for="alamat" class="col-sm-5 control-label">Provinsi</label>
								<div class="col-sm-7">
									 <textarea class="form-control"  rows="3" id="provinsi" name="provinsi"  readonly ><?php echo $data->provinsi; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="tarif" class="col-sm-5 control-label">Tarif</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="tarif"  name="tarif" value="<?php echo $data->tarif; ?>" readonly  />
								</div>
							</div>

							</div>







						</div>
						<hr>
						<div class="form-group">
							<label for="jenis_kirim" class="col-sm-2 control-label">Jenis Tujuan</label>
							<div class="col-sm-7">
								<select class="form-control" name="satuan" required="required">
									<option value="Pool" <?php echo $data->jenis_tujuan == "Pool" ? ' selected' : ''; ?>>POOL</option>
									<option value="Toko" <?php echo $data->jenis_tujuan== "Toko" ? ' selected' : ''; ?>>TOKO</option>
									<option value="Ekspedisi" <?php echo $data->jenis_tujuan == "ekspedisi" ? ' selected' : ''; ?>>EKSPEDISI</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="id_tujuan" class="col-sm-2 control-label">Tujuan</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="id_tujuan" placeholder="pilih tujuan" name="id_tujuan" value="<?php echo $data->id_tujuan; ?>" readonly />
							</div>
							<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ref-table-tujuan" href="#"><span class="glyphicon glyphicon-search"></span></a>
						</div>
						<div class="form-group">
							<label for="pelanggan" class="col-sm-2 control-label">Nama</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="nama_tujuan" name="nama_tujuan" value="<?php echo $data->nama_tujuan; ?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="col-sm-2 control-label">Alamat</label>
							<div class="col-sm-7">
								<textarea class="form-control" rows="3" id="alamat_tujuan" name="alamat_tujuan" readonly><?php echo $data->alamat_tujuan; ?></textarea>
							</div>
						</div>
<hr>
						<div class="row">
							<div class="col-sm-5">
								<div class="form-group">
									<label for="berat_amplop" class="col-sm-5 control-label">Qty</label>
									<div class="col-sm-7">
										<input type="number" onChange="hitungOngkosKirim()" class="form-control" required="required" id="berat_amplop" name="berat_amplop" placeholder="input berat" value="<?php echo $data->berat_amplop; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="jenis_kirim" class="col-sm-5 control-label">Satuan</label>
									<div class="col-sm-7">
										<select class="form-control" name="satuan" required="required">
											<option value="Bal" <?php echo $data->satuan == "Bal" ? ' selected' : ''; ?>>BAL</option>
											<option value="Karung" <?php echo $data->satuan== "Karung" ? ' selected' : ''; ?>>KARUNG</option>
											<option value="Dus" <?php echo $data->satuan == "Dus" ? ' selected' : ''; ?>>DUS</option>
											<option value="Kg" <?php echo $data->satuan== "Kg" ? ' selected' : ''; ?>>KG</option>
											<option value="Semple" <?php echo $data->satuan== "Semple" ? ' selected' : ''; ?>>SEMPLE</option>
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

										<input type="text" class="form-control" required="required" id="ongkos_kirim" name="ongkos_kirim" value="<?php echo $data->ongkos_kirim; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label for="ongkos_bongkar" class="col-sm-5 control-label">Biaya Lainnya</label>
									<div class="col-sm-7">
										<input type="number" onChange="calculateTotal()" class="form-control" required="required" id="ongkos_bongkar" name="ongkos_bongkar" placeholder="input ongkos lainnya" value="<?php echo $data->ongkos_bongkar; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="diskon" class="col-sm-5 control-label">Diskon</label>
									<div class="col-sm-7">
										<input type="number" onChange="calculateTotal()" class="form-control" required="required" id="diskon" name="diskon" placeholder="input diskon tanpa %" value="<?php echo $data->diskon; ?>">
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
								<div class="col-sm-5">
									<?php if (!empty($data->id_amplop)) : ?>
										<div class="form-group">
											<label for="id_categ" class="col-sm-5 control-label">Status</label>
											<div class="col-sm-7">
												<select class="form-control input-sm" name="status">
													<option value="1" <?php echo $data->status == "1" ? ' selected' : ''; ?>>Dikirim</option>
													<option value="2" <?php echo $data->status == "2" ? ' selected' : ''; ?>>Diterima</option>
													<option value="3" <?php echo $data->status == "3" ? ' selected' : ''; ?>>Ditolak</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="keterangan" class="col-sm-5 control-label">Keterangan</label>
											<div class="col-sm-7">
												<textarea class="form-control" rows="3" id="keterangan" name="keterangan"><?php echo $data->keterangan; ?></textarea>
											</div>
										</div>
									<?php endif;	?>
								</div>

							</div>


						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("transaksi_amplop") ?>" class="btn btn-danger">cancel</a>
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
				<h4 class="modal-title" id="myModalLabel">Pilih barang</h4>
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
							<a href="<?php echo site_url("master_pelanggan/manage") ?>" class="btn btn-success btn-sm">add</a>
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

<div class="modal fade" id="ref-table-tujuan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih tujuan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-tujuan" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-tujuan">Search</button>
							<a href="<?php echo site_url("master_tujuan/manage") ?>" class="btn btn-success btn-sm">add</a>
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

<div class="modal fade" id="ref-table-tarif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih tarif</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-tarif" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-tarif">Search</button>
							<a href="<?php echo site_url("master_tarif/manage") ?>" class="btn btn-success btn-sm">add</a>
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

	$(document).ready(function() {
		$("#id_kota").change(function() {
			$("#div1").load("http://localhost/javora/index.php/transaksi_amplop/ajaxGetPrice?tujuan=" + $("#id_kota").val(), function(responseTxt, statusTxt, xhr) {});
		});
		$("#id_kecamatan").change(function() {
			$("#div1").load("http://localhost/javora/index.php/transaksi_amplop/ajaxGetPrice?tujuan=" + $("#id_kecamatan").val(), function(responseTxt, statusTxt, xhr) {});
		});

	});

	$(function() {

		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('index.php/master_pelanggan/ambil_data') ?>",
			cache: false,
		});

		$("#id_provinsi").change(function() {

			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kabupaten',
						id: value
					},
					success: function(respond) {
						$("#id_kota").html(respond);
					}
				})
			}

		});


		$("#id_kota").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kecamatan',
						id: value
					},
					success: function(respond) {
						$("#id_kecamatan").html(respond);
					}
				})
			}
		});

		$("#id_kecamatan").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'tarif',
						id: value
					},
					success: function(respond) {
						$("#tarif").html(respond);
					}
				})
			}
		});



	})
</script>
