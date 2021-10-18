<div class="content-wrapper master">
	<section class="content-header">
	  <h1>
		<?php echo $title?>
	  </h1>
	</section>
	<?php
		 $msg_err = $this->session->flashdata('admin_save_error');
		 $msg_succes = $this->session->flashdata('admin_save_success');
	?>
	<?php if(!empty($msg_err)): ?>
	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Error!</strong> <?php echo $msg_err;?>
	</div>
	<?php endif; ?>
	<?php if(!empty($msg_succes)): ?>
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Succes!</strong> <?php echo $msg_succes;?>
	</div>
	<?php endif; ?>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header">
						<div class="filter-wrapper box-tools pull-right">
								<form class="form-inline" method="get" action="<?php echo site_url("transaksi_order")?>" >
									 <div class="form-group">
										<input type="text" class="form-control input-sm" id="keyword" placeholder="Keyword" name="keyword" value="<?php echo $this->input->get('keyword');?>">
								  </div>
									 <button type="submit" class="btn btn-primary btn-sm glyphicon glyphicon-search"></button>
									 <a href="<?php echo site_url("transaksi_order/manage")?>" class="btn btn-success btn-sm">add</a>
								</form>
						</div>
					</div>
						<div class="box-body no-padding">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>NO TTB</th>
										<th>TANGGAL</th>
										<th>PENGIRIM</th>
										<th>PENERIMA</th>
										<th>ALAMAT</th>
										<th>BIAYA TTB</th>
										<th>JENIS TTB</th>
										<th>STATUS</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data as $dt) : ?>
										<tr>
											<td><?php echo $dt['id_amplop']; ?></td>
											<td><?php echo date("d-m-Y", strtotime($dt['tanggal'])); ?></td>
											<td><?php echo $dt['nama_pengirim']; ?></td>
											<td><?php echo $dt['nama_penerima']; ?></td>
											<td><?php echo $dt['alamat_penerima']; ?></td>
											<td><?php echo $dt['ongkos_bersih']; ?></td>
											<td><?php echo $dt['jenis_kirim']; ?></td>
											<?php

											$status = "<span class='label label-warning'>Order</span>";
											if ($dt['status'] == '1')
												$status = "<span class='label label-warning'>Diterima Oleh STB</span>";
											else if ($dt['status'] == '2')
												$status = "<span class='label label-info'>Dikirim</span>";
											else if ($dt['status'] == '3')
												$status = "<span class='label label-success'>Diterima Oleh Penerima</span>";
											else if ($dt['status'] == '4')
												$status = "<span class='label label-danger'>Retur</span>";
											?>
											<td><?php echo $status; ?></td>
											<th>
												<a class="btn btn-primary btn-xs" target="blank" href="<?php echo site_url("transaksi_order/validasi") . "/" . $dt['id_amplop']; ?>"><span class="glyphicon glyphicon-check">Validasi</span></a>
												<a class="btn btn-warning btn-xs" href="<?php echo site_url("transaksi_order/manage") . "/" . $dt['id_amplop']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
												<a class="btn btn-danger btn-xs" data-href="<?php echo site_url("transaksi_order/delete") . "/" . $dt['id_amplop']; ?>" data-toggle="modal" data-target="#confirm-delete" href="#"><span class="glyphicon glyphicon-remove"></span></a>
											</th>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
					<?php echo $this->pagination->create_links();?>
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
