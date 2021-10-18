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
					<form class="form-horizontal" method="post" action="<?php echo site_url("master_tujuan/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_tujuan; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id_tujuan" class="col-sm-2 control-label">ID master_tujuan</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_tujuan" name="id_tujuan" value="<?php echo $data->id_tujuan == "" ? $data->autocode : $data->id_tujuan; ?>" readonly>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="jenis_kirim" class="col-sm-2 control-label">Jenis Tujuan</label>
								<div class="col-sm-7">
									<select class="form-control" name="jenis_tujuan" required="required">
										<option value="Pool" <?php echo $data->jenis_tujuan == "Pool" ? ' selected' : ''; ?>>POOL</option>
										<option value="Toko" <?php echo $data->jenis_tujuan== "Toko" ? ' selected' : ''; ?>>TOKO</option>
										<option value="Ekspedisi" <?php echo $data->jenis_tujuan == "ekspedisi" ? ' selected' : ''; ?>>EKSPEDISI</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="nama_master_tujuan" class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nama_tujuan" name="nama_tujuan" placeholder="input nama" value="<?php echo $data->nama_tujuan; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="telepon_master_tujuan" class="col-sm-2 control-label">Telepon</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="telepon_tujuan" name="telepon_tujuan" placeholder="input telepon" value="<?php echo $data->telepon_tujuan; ?>">
								</div>
							</div>
							<div class='form-group'>
								<label for="provinsi" class="col-sm-2 control-label">Provinsi</label>
								<div class="col-sm-3">
									<select class='form-control' id='id_provinsi' name="id_provinsi">
										<?php foreach ($provinsi as $prov) : ?>
											<option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $data->id_provinsi == $prov['id_provinsi'] ? ' selected' : ''; ?>><?php echo $prov['nama_provinsi'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>




							<div class='form-group'>
								<label for="kabupaten" class="col-sm-2 control-label">Kabupaten/kota</label>
								<div class="col-sm-3">
									<select class='form-control' id='id_kota' name="id_kota">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>


							<div class='form-group'>
								<label for="kecamatan" class="col-sm-2 control-label">Kecamatan</label>
								<div class="col-sm-3">
									<select class='form-control' id='id_kecamatan' name="id_kecamatan">
										<option value='0'>--pilih--</option>
									</select>
								</div>
							</div>



							<div class="form-group">
								<label for="alamat_master_tujuan" class="col-sm-2 control-label">Alamat</label>
								<div class="col-sm-4">
									<textarea class="form-control" rows="3" id="alamat_tujuan" name="alamat_tujuan" placeholder="Nama Jalan, Gedung, No. Rumah/Unit" required="required"><?php echo $data->alamat_tujuan; ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="telepon_master_tujuan" class="col-sm-2 control-label">Tarif</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="tarif" name="tarif" placeholder="tarif" value="<?php echo $data->tarif; ?>">
								</div>
							</div>

						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("master_tujuan") ?>" class="btn btn-danger">cancel</a>
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
			url: "<?php echo base_url('index.php/master_tujuan/ambil_data') ?>",
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



	})
</script>
