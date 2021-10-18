<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css') ?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>

<script>
	var selectedmodal = 1;

	$(function() {
		$('button[type="reset"]').click(function(evt) {
			evt.preventDefault();
			$(this).closest('form').get(0).reset();
		});

		$("form[name='save']").on("keyup keypress", function(e) {
			var code = e.keyCode || e.which;
			if (code == 13) {
				e.preventDefault();
				$(this).blur();
				return false;
			}
		});

		$('#ref-table-pelanggan').on('show.bs.modal', function(e) {
			selectedmodal = 2;
			$(".table-ajax-pelanggan").empty();
			getPelanggan(1);
		});

		$(".search-pelanggan").click(function() {
			getPelanggan(1);
		});

		$("body").on('click', '#ref-table-pelanggan .pagination a', function(e) {
			getPelanggan(getUrlVars(e.target.href)['page']);
			return false;
		});

		$('#ref-table-karyawan').on('show.bs.modal', function(e) {
			selectedmodal = 2;
			$(".table-ajax-karyawan").empty();
			getKaryawan(1);
		});

		$(".search-karyawan").click(function() {
			getKaryawan(1);
		});

		$("body").on('click', '#ref-table-karyawan .pagination a', function(e) {
			getKaryawan(getUrlVars(e.target.href)['page']);
			return false;
		});



	});



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

	function getKaryawan(page) {
		$.ajax({
			dataType: "html",
			url: "<?php echo site_url("api/ajax/getTableKaryawan"); ?>",
			data: {
				"keyword": $("#keyword-karyawan").val(),
				'page': page
			},
			success: function(d) {
				$(".table-ajax-karyawan").empty();
				$(".table-ajax-karyawan").html(d);
			}
		});
	}



	function pilih(id, karyawan_id, nama, other, other2, other3) {
		if (selectedmodal == 1) {} else if (selectedmodal == 2) {

			$("input[name='nik']").val(id);
			$("input[name='karyawan_id']").val(karyawan_id);
			$("input[name='nama']").val(nama);
			$("input[name='hp']").val(other);
			$("textarea[name='alamat']").val(other2);
		} else if (selectedmodal == 3) {}
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
					<form name="myform" class="form-horizontal" method="post" action="<?php echo site_url("master_driver/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id; ?>">
						<div class="box-body" id="div_body">


							<hr>

							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">NIK</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="nik" placeholder="pilih karyawan" name="nik" value="<?php echo $data->nik; ?>" readonly />
								</div>
								<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ref-table-karyawan" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="karyawan" class="col-sm-2 control-label">karyawan ID</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="karyawan_id" name="karyawan_id" value="<?php echo $data->id; ?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label for="karyawan" class="col-sm-2 control-label">Nama Karyawan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data->nama; ?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label for="hp" class="col-sm-2 control-label">Hp Karyawan</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" rows="3" id="hp" name="hp" value="<?php echo $data->hp; ?>" readonly></input>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat" class="col-sm-2 control-label">Alamat Karyawan</label>
								<div class="col-sm-7">
									<textarea class="form-control" rows="3" id="alamat" name="alamat" readonly><?php echo $data->alamat; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="spv_id" class="col-sm-2 control-label">Spv</label>
								<div class="col-sm-3">
									<select class="form-control" name="spv_id">
										<?php foreach ($master_spv as $kt) : ?>
											<option value="<?php echo $kt['id']; ?>" <?php echo $data->id == $kt['id'] ? ' selected' : ''; ?>><?php echo $kt['nama'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<hr>
							<?php if (empty($data->id)) : ?>
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">Username</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" rows="3" id="username" name="username" value="<?php echo $data->username; ?>" placeholder="input username"></input>
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-7">
										<input type="password" class="form-control" rows="3" id="password" name="password" value="<?php echo $data->password; ?>" placeholder="input password"></input>
									</div>
								</div>
							<?php endif; ?>



							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
								<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
								<button type="reset" class="btn btn-warning">reset</button>
								<a href="<?php echo site_url("master_driver") ?>" class="btn btn-danger">cancel</a>
							</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>



<div class="modal fade" id="ref-table-karyawan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Karyawan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#">
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-karyawan" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button" class="btn btn-primary btn-sm search-pelanggan">Search</button>
							<a href="<?php echo site_url("master_karyawan/manage") ?>" class="btn btn-success btn-sm">add</a>
						</form>
					</div>
				</div>

				<div class="table-ajax-karyawan">
				</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>