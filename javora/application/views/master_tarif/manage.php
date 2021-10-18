<div class="content-wrapper master">
	<section class="content-header">
		<h1>
			<?php echo $title ?>
		</h1>
	</section>
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
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<form class="form-horizontal" method="post" action="<?php echo site_url("master_tarif/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_tarif; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id_tarif" class="col-sm-2 control-label">ID master_tarif</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_tarif" name="id_tarif" value="<?php echo $data->id_tarif == "" ? $data->autocode : $data->id_tarif; ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="id_jenis_layanan" class="col-sm-2 control-label">Jenis Layanan</label>
								<div class="col-sm-4">
									<select class="form-control" name="id_jenis_layanan" required="required">
										<option value="COD" <?php echo $data->id_jenis_layanan == "COD" ? ' selected' : ''; ?>>COD</option>
										<option value="REGULER" <?php echo $data->id_jenis_layanan == "REGULER" ? ' selected' : ''; ?>>REGULER</option>
									</select>
								</div>
							</div>
							<hr>

							<div class='form-group'>
								<label for="provinsi_asal" class="col-sm-2 control-label">Provinsi</label>
								<div class="col-sm-3">
									<select class='form-control' id='province_id_asal' name="id_provinsi_asal">
										<?php foreach ($provinsi as $prov) : ?>
											<option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $data->id_provinsi == $prov['id_provinsi'] ? ' selected' : ''; ?>><?php echo $prov['nama_provinsi'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>




							<div class='form-group'>
								<label for="kabupaten_asal" class="col-sm-2 control-label">Kabupaten/kota</label>
								<div class="col-sm-3">
									<select class='form-control' id='city_id_asal' name="id_kota_asal">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>


							<div class='form-group'>
								<label for="kecamatan_asal" class="col-sm-2 control-label">Kecamatan</label>
								<div class="col-sm-3">
									<select class='form-control' id='district_id_asal' name="id_kecamatan_asal">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>


							<hr>


							<div class='form-group'>
								<label for="provinsi_tujuan" class="col-sm-2 control-label">Provinsi</label>
								<div class="col-sm-3">
									<select class='form-control' id='province_id_tujuan' name="id_provinsi_tujuan">
										<?php foreach ($provinsi as $prov) : ?>
											<option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $data->id_provinsi == $prov['id_provinsi'] ? ' selected' : ''; ?>><?php echo $prov['nama_provinsi'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>




							<div class='form-group'>
								<label for="kabupaten_tujuan" class="col-sm-2 control-label">Kabupaten/kota</label>
								<div class="col-sm-3">
									<select class='form-control' id='city_id_tujuan' name="id_kota_tujuan">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>


							<div class='form-group'>
								<label for="kecamatan_tujuan" class="col-sm-2 control-label">Kecamatan</label>
								<div class="col-sm-3">
									<select class='form-control' id='district_id_tujuan' name="id_kecamatan_tujuan">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>


							<hr>

							<div class="form-group">
								<label for="berat_tarif" class="col-sm-2 control-label">Berat</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="berat_tarif" name="berat_tarif" placeholder="input berat" value="<?php echo $data->berat_tarif; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="harga_tarif" class="col-sm-2 control-label">Harga</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="harga_tarif" name="harga_tarif" placeholder="input harga" value="<?php echo $data->harga_tarif; ?>">
								</div>
							</div>

						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("master_tarif") ?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
	$(function() {

		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('index.php/master_tarif/ambil_data') ?>",
			cache: false,
		});

		$("#province_id_asal").change(function() {

			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kabupaten_asal',
						id: value
					},
					success: function(respond) {
						$("#city_id_asal").html(respond);
					}
				})
			}

		});


		$("#city_id_asal").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kecamatan_asal',
						id: value
					},
					success: function(respond) {
						$("#district_id_asal").html(respond);
					}
				})
			}
		});

		$("#district_id_asal").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kelurahan_asal',
						id: value
					},
					success: function(respond) {
						$("#village_id_asal").html(respond);
					}
				})
			}
		});


		$("#province_id_tujuan").change(function() {

			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kabupaten_tujuan',
						id: value
					},
					success: function(respond) {
						$("#city_id_tujuan").html(respond);
					}
				})
			}

		});


		$("#city_id_tujuan").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kecamatan_tujuan',
						id: value
					},
					success: function(respond) {
						$("#district_id_tujuan").html(respond);
					}
				})
			}
		});

		$("#district_id_tujuan").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kelurahan_tujuan',
						id: value
					},
					success: function(respond) {
						$("#village_id_tujuan").html(respond);
					}
				})
			}
		});

	})

	$('#village_id_asal').on('change', function() {
		$('#asal').val($(this).val());
	})

	// init
	$('#village_id_asal').change();


	$('#village_id_tujuan').on('change', function() {
		$('#tujuan').val($(this).val());
	})

	// init
	$('#village_id_tujuan').change();
</script>
