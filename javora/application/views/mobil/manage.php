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
					<form class="form-horizontal" method="post" action="<?php echo site_url("mobil/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_mobil; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id_mobil" class="col-sm-2 control-label">ID Mobil</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_mobil" name="id_mobil" value="<?php echo $data->id_mobil == "" ? $data->autocode : $data->id_mobil; ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nama" name="nama" placeholder="input nama" value="<?php echo $data->nama; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="id_merk" class="col-sm-2 control-label">Merk</label>
								<div class="col-sm-3">
									<select class="form-control" name="id_merk">
										<?php foreach ($merk as $kt) : ?>
											<option value="<?php echo $kt['id_merk']; ?>" <?php echo $data->id_merk == $kt['id_merk'] ? ' selected' : ''; ?>><?php echo $kt['nama_merk'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="del_no" class="col-sm-2 control-label">No Polisi</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="no_polisi" name="no_polisi" placeholder="input no polisi" value="<?php echo $data->no_polisi; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="warna" class="col-sm-2 control-label">Warna</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="warna" name="warna" placeholder="input warna" value="<?php echo $data->warna; ?>">
								</div>
							</div>
						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("mobil") ?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>