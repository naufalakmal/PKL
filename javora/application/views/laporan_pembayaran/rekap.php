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
								<form class="form-horizontal" method="get" action="<?php echo site_url("laporan_pembayaran/rekap")?>" id="filter-form">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-5  pull-right">
											<div class="form-action pull-right">
												<button type="submit" class="btn btn-success" name="action" value="excel">Export ke Excel</button>
											</div>
										</div>
									</div>

								</div>
								<div class="panel-body">
									Periode Lap
									<div class="row">
										<div class="col-md-3">
											<div class="input-group">
											 <div class="input-group-addon">dari</div>
											 <input type="text" class="form-control datepicker" id="from" name="from"  readonly data-date-format="mm/dd/yyyy" value="<?php echo $this->input->get("from") != "" ? date("m/d/Y",strtotime($this->input->get("from"))) : date("m/d/Y",strtotime("-30 days")) ?>">
											  <div class="input-group-addon glyphicon glyphicon-calendar"></div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="input-group">
											 <div class="input-group-addon">sampai</div>
											<input type="text" class="form-control datepicker" id="to" name="to"  readonly data-date-format="mm/dd/yyyy" value="<?php echo $this->input->get("to") != "" ? date("m/d/Y",strtotime($this->input->get("to"))) : date("m/d/Y") ?>">
											  <div class="input-group-addon glyphicon glyphicon-calendar"></div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="input-group">
											 <div class="input-group-addon">Cari</div>
											 <input type="text" class="form-control input-sm" id="status" placeholder="Nama Pelanggan" name="status" value="<?php echo $this->input->get('keyword');?>">

											</div>
										</div>



										<div class="col-md-2">
											<button type="submit" class="btn btn-success" name="cari" value="cari">Tampilkan</button>
										</div>
									</div>
								</form>
						</div>
					</div>
						<div class="box-body no-padding">
						<table class="table table-striped">
						<thead>
						  <tr>
							<th>NO</th>
							<th>TANGGAL</th>
							<th>PELANGGAN</th>
							<th>NAMA PELANGGAN</th>

							<th>KREDIT</th>


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
							<td><?php echo date("d-m-Y",strtotime($dt['tanggal_bayar_amplop']));?></td>
							<td><a href='<?php echo site_url("laporan_pembayaran/rekaplanjut") . "/" . $dt['id_pelanggan']; ?>'><?php echo $dt['id_pelanggan']; ?></a></td>
							<td><?php echo $dt['nama'];?></td>

							<td><?php echo rupiah($dt['totalkredit']);?></td>


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
