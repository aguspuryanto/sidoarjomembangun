<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Realiasai Dana Desa </h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-lg-12">
					<?php
					if(isset($_POST['csrf_value'])){
						//print_r ($_POST);
						//Array ( [kec] => 35.15.11 [desa2] => 35.15.11.2019 [sumber_dana] => 7 [jmldana_desa] => 255.507.403 [thndana_desa] => 2015 [csrf_value] => 2002223120452421 )
						
						$data = array(
							'kode_desa' => $_POST['desa2'],'realisasi_dana' => $_POST['realisasi_desa'],'jumlah_dana' => str_replace(".","",int()$_POST['jmldana_desa']),'tahun_dana' => $_POST['thndana_desa']
						);						
						$result = save_realisasidesa($data);
						if($result) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					?>					
					</div>
					
					<?php if(isset($_GET['act'])){					
						// GET KECAMATAN
						$kecamatan	= list_bykecamatan();
						$sumber_dana	= list_sumberdana();
						$get_id		= $_SESSION['ID'];
					?>
					
					<div class="col-lg-8">
						<div class="panel panel-default">
							<div class="panel-body">
							<form class="form-horizontal" method="post">
								
								<div class="form-group">
									<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
									<div class="col-sm-8">
										<select id="kec2" name="kec" class="form-control">
										<?php /*if(get_user_meta($get_id, 'kode_kec')){ ?>
											<option value="<?=get_user_meta($get_id, 'kode_kec');?>"><?=get_kecamatan( get_user_meta($get_id, 'kode_kec') );?></option>
										<?php }else{*/ ?>
											<option></option>
											<?php foreach($kecamatan as $kec){
												echo '<option value="'.$kec['kode'].'">'.$kec['nama'].'</option>';
											}
										//}?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">NAMA DESA</label>
									<div class="col-sm-8">
										<select id="desa2" name="desa2" class="form-control">
											<option value="<?=get_user_meta($get_id, 'kode_desa');?>"><?=get_desa( get_user_meta($get_id, 'kode_desa') );?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Realisasi</label>
									<div class="col-sm-8">
										<input type="text" name="realisasi_desa" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Jumlah Realiasai</label>
									<div class="col-sm-8">
										<input type="text" name="jmldana_desa" class="form-control" id="currency">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Tahun Realiasai</label>
									<div class="col-sm-8">
										<select name="thndana_desa" class="form-control">
										<?php
										$earliest_year	= (int)date('Y') - 5;
										foreach (range(date('Y'), $earliest_year) as $x) {
											echo '<option value="'.$x.'">'.$x.'</option>';
										}
										?>
										</select>
									</div>
								</div>
								
								<button type="submit" class="btn btn-warning btn-lg">Simpan</button>
								<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
							</form>
							</div>
						</div>
					</div>
					
					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">Sumber Dana Desa</div>
							<div class="panel-body">
								
							</div>
						</div>
					</div>
					
					<?php }else{ ?>
					
					<div class="col-lg-12">
						<?php
						$tipe	= isset($tipe) ? $tipe : '';
						$id		= isset($id) ? $id : '';
						//echo ("TIPE: ".$tipe.", KODE: ".$id)."<br>";
						$provinsi = desa_list($tipe, $id);
						//$danadesa = list_danadesa($tipe,$id);
						?>
						
						<p>
							<a class="btn btn-primary" href="?act=new"><i class="glyphicon glyphicon-plus"></i> Input Realiasai Dana Desa</a>
						</p>
						<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="10"><div align="center">Kode</div></th>
									<th><div align="center">NAMA PROVINSI / KABUPATEN / KOTA / DESA</div></th>
									<th><div align="center">SUMBER DANA</div></th>
									<th><div align="center">JUMLAH DANA</div></th>
									<th><div align="center">TAHUN ANGGARAN</div></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							//PROVINSI || DESA
							foreach($provinsi as $prov){
								if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
									echo '<tr>
										<td>'.$prov['kode'].'</td>
										<td>'.strtoupper($prov['nama']).'</td>
										<td>'.get_danadesa('sumber_dana',$prov['kode']).'</td>
										<td>'.get_danadesa('jumlah_dana',$prov['kode']).'</td>
										<td>'.get_danadesa('tahun_dana',$prov['kode']).'</td>
									</tr>';
									
									//KABUPATEN
									$kabupaten = desa_list(strtolower($prov['tipe']),$prov['kode']);
									foreach($kabupaten as $kab){
										if($kab['kode']=="35.15" || preg_match("/35.15/i", $kab['parent'])){
											echo '<tr>
												<td>'.$kab['kode'].'</td>
												<td>'.strtoupper($kab['nama']).'</td>
												<td>'.get_danadesa('sumber_dana',$kab['kode']).'</td>
												<td>'.get_danadesa('jumlah_dana',$kab['kode']).'</td>
												<td>'.get_danadesa('tahun_dana',$kab['kode']).'</td>
											</tr>';
											
											//KECAMATAN
											$kecamatan = desa_list(strtolower($kab['tipe']),$kab['kode']);
											foreach($kecamatan as $kec){
												echo '<tr>
													<td>'.$kec['kode'].'</td>
													<td>KECAMATAN <a href="'.$site_url.'/wp-admin/dana/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
													<td>'.get_danadesa('sumber_dana',$kec['kode']).'</td>
													<td>'.get_danadesa('jumlah_dana',$kec['kode']).'</td>
													<td>'.get_danadesa('tahun_dana',$kec['kode']).'</td>
												</tr>';
											}
										}
									}
									
									/*echo '<tr>
									<td>'.$prov['kode'].'</td>
									<td>'.get_desa($dana['kode_desa']).'</td>
									<td>'.get_desa_cat($dana['sumber_dana']).'</td>
									<td>'.$dana['jumlah_dana'].'</td>
									<td>'.$dana['tahun_dana'].'</td>
									</tr>';*/
								}
								$i++;
							}
							?>
							</tbody>
						</table>
						</div>
					</div>
					<?php } ?>
					
				</div><!--/.row-->
			</section>
		</section>
		
		<script src="<?php echo $template_url;?>/wp-admin/js/jquery.maskMoney.min.js" type="text/javascript"></script>
		<script>
		$(function() {
			//parseInt( number ).toLocaleString();
			$('#currency').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
			
			// process the form
			$('form#add_sumberdana').on("submit", function(e) {
				e.preventDefault();					
				$.ajax({
					type: "POST",
					url: "tambahdana",
					data: $(this).serialize(),
					success: function(respone) {
						$(".result_sumberdana").html(respone);
						//setTimeout(function() { location.reload() },1500);
					}
				});
				return true;
			});
		});
		</script>
	  
<?php include ('footer.php'); ?>