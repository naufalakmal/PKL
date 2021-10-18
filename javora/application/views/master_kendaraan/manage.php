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
					<form class="form-horizontal" method="post" action="<?php echo site_url("master_kendaraan/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->nopol; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id" class="col-sm-2 control-label">NOPOL</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nopol" name="nopol" placeholder="NOPOL" value="<?php echo $data->nopol; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nomor Mesin</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nomesin" name="nomesin" placeholder="nomor mesin" value="<?php echo $data->nomesin; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">Merk</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="merk" name="merk" placeholder="merk" value="<?php echo $data->merk; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">CC</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="cc" name="cc" placeholder="cc" value="<?php echo $data->cc; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="nik" class="col-sm-2 control-label">Tahun Kendaraan</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="tahun_kendaraan" name="tahun_kendaraan" placeholder="tahun_kendaraan" value="<?php echo $data->tahun_kendaraan; ?>">
								</div>
							</div>



						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("master_kendaraan") ?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>
