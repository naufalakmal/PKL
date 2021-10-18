<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<?php echo $title ?>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total Truk</span>
						<span class="info-box-number">
                        <?php echo $total_kendaraan ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total Driver</span>
						<span class="info-box-number">
						    <?php echo $total_driver ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<!-- fix for small devices only -->
			<div class="clearfix visible-sm-block"></div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total Order</span>
						<span class="info-box-number">
						    <?php echo $total_order ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total TTB</span>
						<span class="info-box-number">
						    <?php echo $total_ttb ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total Dikirim</span>
						<span class="info-box-number">
						    <?php echo $total_dikirim ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

	</section>
</div>
