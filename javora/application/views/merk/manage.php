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
					<form class="form-horizontal" method="post" action="<?php echo site_url("merk/save") ?>">
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_merk; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="id_merk" class="col-sm-2 control-label">ID Merk</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_merk" name="id_merk" value="<?php echo $data->id_merk == "" ? $data->autocode : $data->id_merk; ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama Merk</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" required="required" id="nama_merk" name="nama_merk" placeholder="input merk" value="<?php echo $data->nama_merk; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
								<div class="col-sm-4">
									<textarea class="form-control" rows="3" id="keterangan" name="keterangan" placeholder="input keterangan" required="required"><?php echo $data->keterangan; ?></textarea>
								</div>
							</div>
						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a href="<?php echo site_url("merk") ?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>