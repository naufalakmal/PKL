<link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datepicker/datepicker3.css')?>">
<script src="<?php echo base_url('assets/template/plugins/datepicker/bootstrap-datepicker.js')?>"></script>

<script>
var selectedmodal = 1;
var lastAmplop = <?php echo $data->barang != "" ? json_encode($data->barang) : '[]'?>;
$(function(){
	$('button[type="reset"]').click(function(evt) {
	    evt.preventDefault();
	    $(this).closest('form').get(0).reset();

		if(lastAmplop.length == 0)
			$("table.tblbarang tbody").html("");
		else
		{
				$("table.tblbarang tbody").html("");
				var ramplop = lastAmplop.split("===");
				$(ramplop).each(function(i,d) {
					rb =  d.split("|");
					br = "<tr>";
					br += "<td><input type='hidden' name='detail[id_amplop][]' value='"+rb[0]+"'>"+rb[0]+"</td>";
					br += "<td>"+rb[1]+"</td>";
					br += "<td>"+rb[2]+"</td>";
					br += "<td>"+rb[4]+"</td>";
					br += "<td><input type='text' class='form-control' name='detail[jumlah]["+rb[0]+"]' value='"+rb[4]+"' size='5' ></td>";
					br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deleteBarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
					br += "</tr>";
					$("table.tblbarang tbody").append(br);
				});
		}
	});

	$("form[name='save']").on("keyup keypress", function(e) {
	  var code = e.keyCode || e.which;
	  if (code  == 13) {
		e.preventDefault();
		$(this).blur();
		return false;
	  }
	});

	$('#ref-table-barang').on('show.bs.modal', function(e) {
		selectedmodal = 1;
		$(".table-ajax-barang").empty();
		getBarang(1);
	});

	$('#ref-table-pool').on('show.bs.modal', function(e) {
		selectedmodal = 2;
		$(".table-ajax-pool").empty();
		getpool(1);
	});

	$('#ref-table-driver').on('show.bs.modal', function(e) {
		selectedmodal = 3;
		$(".table-ajax-driver").empty();
		getdriver(1);
	});


	$(".search-barang").click(function(){
		getBarang(1);
	});

	$(".search-pool").click(function(){
		getpool(1);
	});

	$(".search-driver").click(function(){
		getdriver(1);
	});

	$("body").on('click', '#ref-table-barang .pagination a', function (e) {
		getBarang(getUrlVars(e.target.href)['page']);
		return false;
    });

	$("body").on('click', '#ref-table-pool .pagination a', function (e) {
		getpool(getUrlVars(e.target.href)['page']);
		return false;
	   });

	$("body").on('click', '#ref-table-driver .pagination a', function (e) {
		getdriver(getUrlVars(e.target.href)['page']);
		return false;
    });

	$("input[name='tanggal']").datepicker();


	$("form[name='save']").submit(function( event ) {

		if($("input[name='id_']").val() == "")
		{
				$(".error-wrapper").html("<div class='alert alert-danger'>"
				 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
				 + " <strong>Error!</strong> Pilih  dahulu"
				 + "</div>");
			return false;
		}

		if($("input[name='id_driver']").val() == "")
		{
				$(".error-wrapper").html("<div class='alert alert-danger'>"
				 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
				 + " <strong>Error!</strong> Pilih driver dahulu"
				 + "</div>");
			return false;
		}


		var kode = $("table.tblbarang tbody input[name='detail[id_amplop][]']");
		if(kode.length > 0 )
		{
			hasError = false;
			hasLessZero = false;
			$(kode).each(function(i,d) {
				var jumlah = $("table.tblbarang tbody input[name='detail[qty]["+$(d).val()+"]']").val();
				if(isNaN(jumlah))
						hasError = true;
					else
					{
						if(jumlah <= 0 )
							hasLessZero = true;
					}
			});

			if(hasError)
			{
				$(".error-wrapper").html("<div class='alert alert-danger'>"
				 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
				 + " <strong>Error!</strong> format qty tidak benar"
				 + "</div>");

				  return false;
			}
			else if(hasLessZero)
			{
				$(".error-wrapper").html("<div class='alert alert-danger'>"
				 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
				 + " <strong>Error!</strong> jumlah tidak boleh kurang dari 1"
				 + "</div>");
			}
			else
				return;
		}
		else
		{
			$(".error-wrapper").html("<div class='alert alert-danger'>"
				 + "<a href='#' class='close' data-dismiss='alert'>&times;</a>"
				 + " <strong>Error!</strong> pilih ttb dahulu"
				 + "</div>");

				 return false;
		}
		 return false;
	 });

});

function getBarang(page)
{
	dt = {"keyword":$("#keyword-barang").val(),'page':page};
	var kode = $("table.tblbarang tbody input[type='hidden']");
	if(kode.length > 0 )
	{
		$kc = [];
		$(kode).each(function(i,d) {
			$kc[i] = $(this).val();
		});

		dt = {"keyword":$("#keyword-barang").val(),'page':page,barang:$kc};
	}
	$.ajax({
		  dataType: "html",
		  url: "<?php echo site_url("api/ajax/getTablebarangamplop");?>",
		  data:dt,
		  success:function(d){
			  $(".table-ajax-barang").empty();
			  $(".table-ajax-barang").html(d);
			}
	});
}

function getpool(page)
{

	$.ajax({
		  dataType: "html",
		  url: "<?php echo site_url("api/ajax/getTablepool");?>",
		  data:{"keyword":$("#keyword-pool").val(),'page':page},
		  success:function(d){
			  $(".table-ajax-pool").empty();
			  $(".table-ajax-pool").html(d);
			}
	});
}

function getdriver(page)
{
	$.ajax({
		  dataType: "html",
		  url: "<?php echo site_url("api/ajax/getTabledriver");?>",
		  data:{"keyword":$("#keyword-driver").val(),'page':page},
		  success:function(d){
			  $(".table-ajax-driver").empty();
			  $(".table-ajax-driver").html(d);
			}
	});
}

function pilih(id,nama,other,other2,other3,other4)
{
	if(selectedmodal == 1)
	{

		$br = "<tr>";
		$br += "<td><input type='hidden' name='detail[id_amplop][]' value='"+id+"'>"+id+"</td>";
		$br += "<td>"+nama+"</td>";
		$br += "<td>"+other+"</td>";
		$br += "<td><input type='text' class='form-control' name='detail[qty]["+other2+"]' value='1' size='5' readonly></td>";
		$br += "<td>"+other3+"</td>";
		$br += "<td><input type='text' readonly name='detail[id_pool]["+id+"]' value='"+other4+"'></td>";
		$br += "<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deleteBarang(this)'><span class='glyphicon glyphicon-remove'></span></a></td>";
		$br += "</tr>";
		$("table.tblbarang tbody").append($br);
	}
	else if(selectedmodal == 2)
	{
		$("input[name='id_pool']").val(id);
		$("input[name='pool']").val(nama);
		$("textarea[name='alamat']").val(other);
	}
	else if(selectedmodal == 3)
	{
		$("input[name='id_driver']").val(id);
		$("input[name='driver']").val(nama);
	}
}

function getUrlVars(url) {
        var vars = [], hash;
        var hashes = url.slice(url.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
}
function deleteBarang(a)
{
	$(a).closest("tr").remove()
}
</script>

<div class="content-wrapper master">
	<section class="content-header">
	  <h1>
		<?php echo $title?>
	  </h1>
	</section>
	<div class="error-wrapper">
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
	</div>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<form  class="form-horizontal" method="post" action="<?php echo site_url("pengiriman/save")?>"  >
						<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data->id_surat_jalan; ?>" >
						<div class="box-body">
							<div class="form-group">
								<label for="id_kendaraan" class="col-sm-2 control-label">Kendaraan</label>
								<div class="col-sm-3">
								   <select class="form-control" name="id_kendaraan">
									  <?php foreach ($kendaraan as $kt):?>
									  <option value="<?php echo $kt['id'];?>" <?php echo $data->id == $kt['id'] ? ' selected' : '';?> ><?php echo $kt['nopol']?></option>
									  <?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="id_pengiriman" class="col-sm-2 control-label">ID Pengiriman</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="id_surat_jalan"  name="id_surat_jalan" value="<?php echo $data->id_surat_jalan == "" ? $data->autocode : $data->id_surat_jalan; ?>"  readonly   >
								</div>
							</div>
							<div class="form-group">
								<label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
								<div class="col-sm-4">
								  <input type="text" required="required" class="form-control datepicker" id="tanggal" data-date-format="dd/mm/yyyy" placeholder="select tanggal" name="tanggal" value="<?php echo $data->tanggal != "" ? date("d/m/Y",strtotime($data->tanggal)) : date("d/m/Y"); ?>" >
								</div>
							</div>


							<div class="form-group">
								<label for="id_driver" class="col-sm-2 control-label">driver</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="id_driver" placeholder="pilih driver" name="id_driver" value="<?php echo $data->id_driver; ?>" readonly  />
								</div>
								<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#ref-table-driver" href="#"><span class="glyphicon glyphicon-search"></span></a>
							</div>
							<div class="form-group">
								<label for="driver" class="col-sm-2 control-label">Nama driver</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="driver"  name="driver" value="<?php echo $data->driver; ?>" readonly  />
								</div>
							</div>


							<?php if(!empty($data->id_pengiriman)): ?>
							<div class="form-group">
								<label for="id_categ" class="col-sm-2 control-label">Status</label>
								<div class="col-sm-7">
								   <select class="form-control input-sm" name="status">
									  <option value="1" <?php echo $data->status == "1" ? ' selected' : '';?> >Dikirim</option>
									  <option value="2" <?php echo $data->status == "2" ? ' selected' : '';?> >Diterima</option>
									  <option value="3" <?php echo $data->status == "3" ? ' selected' : '';?> >Ditolak</option>
									  <option value="4" <?php echo $data->status == "4" ? ' selected' : '';?> >Diterima sebagian</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="penerima" class="col-sm-2 control-label">Penerima</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="penerima"  name="penerima" value="<?php echo $data->penerima; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
								<div class="col-sm-7">
									 <textarea class="form-control"  rows="3" id="keterangan" name="keterangan"><?php echo $data->keterangan; ?></textarea>
								</div>
							</div>
							<?php endif;	?>

						</div>

						<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default form-master">
							<div class="panel-heading">
								Info Ttb
							</div>
							<div class="panel-body">
								<button type="button" class="btn btn-success  pull-right btnpilih" name="btnpilih" data-toggle="modal" data-target="#ref-table-barang" href="#" >pilih ttb</button>
								<table class="table table-striped table-small tblbarang">
									<thead>
										<tr>
										<th>No ttb</th>
										<th>Nama pengirim</th>
										<th>Nama Penerima</th>
										<th>Qty</th>
										<th>Satuan</th>
										<th>Pool</th>
										<th>Action</th>
									  </tr>
									</thead>
									<tbody>
										<?php if($data->id_surat_jalan !="" && $data->barang != null): ?>
										<?php $barang = explode("===",$data->barang); ?>

										<?php foreach($barang as $br): ?>
										<?php $b = explode("|",$br) ?>
										<tr>
											<td><input type='hidden' name='detail[id_amplop][]' value="<?php echo $b[0]; ?>"><?php echo $b[0]; ?></td>
											<td><?php echo $b[1]; ?></td>
											<td><?php echo $b[2]; ?></td>
											<td><?php echo $b[3]; ?></td>
											<td><?php echo $b[5]; ?></td>
											<td><input type='hidden' class="form-control" name='detail[qty][<?php echo $b[0]; ?>]' value='<?php echo $b[4]; ?>' size='5'  ></td>
											<td><a class='btn btn-danger btn-xs delete' href='javascript://' onclick='deleteBarang(this)'><span class='glyphicon glyphicon-remove' ></span></a></td>
											<td></td>
										</tr>
										<?php endforeach ?>

										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="action" value="save">save</button>
							<button type="submit" class="btn btn-success" name="action" value="saveexit">save & exit</button>
							<button type="reset" class="btn btn-warning">reset</button>
							<a  href="<?php echo site_url("pengiriman")?>" class="btn btn-danger">cancel</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="ref-table-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih Amplop</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#" >
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-barang" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button"  class="btn btn-primary btn-sm search-barang">Search</button>
						</form>
					</div>
				</div>

					<div class="table-ajax-barang">
					</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="ref-table-driver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ajax-modal" style="margin-top:100px;">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pilih driver</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-filter-modal">
						<form class="form-inline" method="get" action="#" >
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="keyword-driver" placeholder="Keyword" name="keyword" value="">
							</div>
							<button type="button"  class="btn btn-primary btn-sm search-driver">Search</button>
						</form>
					</div>
				</div>

					<div class="table-ajax-driver">
					</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-danger danger delete" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>
