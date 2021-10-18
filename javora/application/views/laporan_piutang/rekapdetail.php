<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css')?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
	$(function(){
		$('#from').datepicker();
		$('#to').datepicker();
	});
</script>
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
							

					</div>
						<div class="box-body no-padding">
						<table class="table table-striped">
						<thead>
						  <tr>
							<th>TANGGAL</th>
							<th>NO TTB</th>
							<th>PENERIMA</th>
							<th>BIAYA</th>

						  </tr>
						</thead>
						<tbody>
						<?php foreach($data as $dt): ?>
						  <tr>
							<td><?php echo date("d-m-Y",strtotime($dt['tanggal']));?></td>
							<td><?php echo $dt['id_amplop'];?></td>
							<td><?php echo $dt['nama_penerima'];?></td>
							<td><?php echo $dt['ongkos_bersih'];?></td>

						  </tr>
						<?php endforeach ?>
						</tbody>
					</table>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>
