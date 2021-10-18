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
					<div class="box-header">
						<div class="filter-wrapper box-tools pull-right">
							<form class="form-inline" method="get" action="<?php echo site_url("master_kendaraan") ?>">
								<div class="form-group">
									<input type="text" class="form-control input-sm" id="keyword" placeholder="Keyword" name="keyword" value="<?php echo $this->input->get('keyword'); ?>">
								</div>
								<button type="submit" class="btn btn-primary btn-sm glyphicon glyphicon-search"></button>
								<a href="<?php echo site_url("master_kendaraan/manage") ?>" class="btn btn-success btn-sm">add</a>
							</form>
						</div>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>ID </th>
									<th>NOPOL</th>
									<th>NOMOR MESIN</th>
									<th>MERK </th>
									<th>CC</th>
									<th>TAHUN KENDARAAN</th>
									<th>PHOTO KENDARAAN</th>

									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data as $dt) : ?>
									<tr>
										<td><?php echo $dt['id']; ?></td>
										<td><?php echo $dt['nopol']; ?></td>
										<td><?php echo $dt['nomesin']; ?></td>
										<td><?php echo $dt['merk']; ?></td>
										<td><?php echo $dt['cc']; ?></td>
										<td><?php echo $dt['tahun_kendaraan']; ?></td>
										<td>photo</td>
									
										<th>
											<a class="btn btn-warning btn-xs" href="<?php echo site_url("master_kendaraan/manage") . "/" . $dt['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
											<a class="btn btn-danger btn-xs" data-href="<?php echo site_url("master_kendaraan/delete") . "/" . $dt['id']; ?>" data-toggle="modal" data-target="#confirm-delete" href="#"><span class="glyphicon glyphicon-remove"></span></a>
										</th>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<?php echo $this->pagination->create_links(); ?>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
			</div>

			<div class="modal-body">
				<p>Yakin ingin hapus?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a href="#" class="btn btn-danger danger delete">Delete</a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.delete').attr('href', $(e.relatedTarget).data('href'));
	});
</script>
