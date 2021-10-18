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
		<h3>
 	<?php echo $title1;?>
 </h3>
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
								<form class="form-horizontal" method="get" action="<?php echo site_url("laporan_piutang/rekaplanjut/$id")?>" >
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-5  pull-right">
											<div class="form-action pull-right">
												<button type="submit" class="btn btn-success" name="actiondetail" value="exceldetail">Export to Per Customer</button>
											</div>
										</div>
									</div>

								</div>

					</div>

						<div class="box-body no-padding">
						<table class="table table-striped">
						<thead>

						  <tr>
							<th>NO</th>
							<th>TANGGAL</th>
							<th>DESKRIPSI</th>
							<th>NO BUKTI</th>
							<th>DEBET</th>
							<th>KREDIT</th>
							<th>SALDO</th>

						  </tr>
						</thead>
						<tbody>
						<?php
						function rupiah($angka){
							$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
							return $hasil_rupiah;
								}
						$i=0;
						foreach($data as $dt):
							$i++?>
						  <tr>
							<td><?php echo $i;?></td>
							<td><?php echo date("d-m-Y",strtotime($dt['tanggal']));?></td>

							<td><?php echo ($dt['deskripsi']);?></td>
							<td><?php echo ($dt['no_bukti']);?></td>
							<td><?php echo rupiah($dt['debit']);?></td>
							<td><?php echo rupiah($dt['kredit']);?></td>
							<td><?php echo rupiah($dt['saldo']);?></td>

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
