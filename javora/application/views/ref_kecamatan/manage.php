<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css') ?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>


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
					<form name="myform" class="form-horizontal" method="post" action="<?php echo site_url("ref_kecamatan/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_kota; ?>">
						<div class="box-body" id="div_body">

							<div class="form-group">
								<label for="spv_id" class="col-sm-2 control-label">Provinsi</label>
								<div class="col-sm-3">
									<select class="form-control" name="provinsi_id">
										<?php foreach ($ref_provinsi as $kt) : ?>
											<option value="<?php echo $kt['id_provinsi']; ?>" <?php echo $data->id_kota == $kt['id_provinsi'] ? ' selected' : ''; ?>><?php echo $kt['nama_provinsi'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama Kota / Kabupaten</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nama_kota" name="nama_kota" placeholder="nama_kota" value="<?php echo $data->nama_kota; ?>">
								</div>
							</div>




						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("ref_kecamatan") ?>" class="btn btn-danger">cancel</a>
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
