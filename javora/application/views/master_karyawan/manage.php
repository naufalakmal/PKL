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
					<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url("master_karyawan/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id" class="col-sm-2 control-label">NIK</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nik" name="nik" placeholder="nik" value="<?php echo $data->nik;  ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nama" name="nama" placeholder="nama" value="<?php echo $data->nama; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">Hp</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="hp" name="hp" placeholder="hp" value="<?php echo $data->hp; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">Alamat</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="alamat" name="alamat" placeholder="alamat" value="<?php echo $data->alamat; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">SIM A</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="sim_a" name="sim_a" placeholder="sim_a" value="<?php echo $data->sim_a; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="fotosima" class="col-sm-2 control-label">Photo SIM A</label>
								<div class="col-sm-4">
									<input type="file" class="form-control" required="required" id="fotosima" name="fotosima" value="<?php echo $data->photo_sim_a; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="sim_c" class="col-sm-2 control-label">SIM C</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="sim_c" name="sim_c" placeholder="sim_c" value="<?php echo $data->sim_c; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="fotosimc" class="col-sm-2 control-label">Photo SIM C</label>
								<div class="col-sm-4">
									<input type="file" class="form-control" required="required" id="fotosimc" name="fotosimc" value="<?php echo $data->photo_sim_c; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="email" name="email" placeholder="email" value="<?php echo $data->email; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="foto" class="col-sm-2 control-label">foto</label>
								<div class="col-sm-4">
									<input type="file" class="form-control" required="required" id="foto" name="foto" value="<?php echo $data->foto; ?>">
								</div>
							</div>

						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("master_karyawan") ?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>