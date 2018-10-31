<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Realiasai Dana Desa</h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-lg-12">
					<?php
					if(isset($_POST['csrf_value'])){
						//print_r ($_POST);
						//Array ( [kec] => 35.15.11 [desa2] => 35.15.11.2019 [sumber_dana] => 7 [jmldana_desa] => 255.507.403 [thndana_desa] => 2015 [csrf_value] => 2002223120452421 )
						
						$data = array(
							'kode_desa' => $_POST['desa2'],'sumber_dana' => $_POST['sumber_dana'],'realisasi_dana' => $_POST['realisasi_dana'],'jumlah_dana' => get_numerics(str_replace(".","",$_POST['jmldana_desa'])),'tahun_dana' => $_POST['thndana_desa']
						);						
						$result = save_realisasi($data);
						if($result) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');	
					?>					
					</div>
					
					<?php if(isset($_GET['act'])){					
						// GET KECAMATAN
						$kecamatan	= list_bykecamatan();
						$sumber_dana	= list_sumberdana();
						$get_id		= $_SESSION['ID'];
					?>
					
					<div class="col-lg-7">
						<div class="panel panel-default">
							<div class="panel-body">
							<form class="form-horizontal" method="post">
								
								<div class="form-group">
									<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
									<div class="col-sm-8">
										<select id="kec2" name="kec" class="form-control" <?php if($user_role<4) echo 'disabled';?>>
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
									<label class="col-sm-4 text-left">Jenis Dana Desa</label>
									<div class="col-sm-8">
										<select name="sumber_dana" class="form-control">
											<option></option>
											<?php foreach($sumber_dana as $dana){
												echo '<option value="'.$dana['danacat_id'].'">'.$dana['name'].'</option>';
											} ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Kegunaan </label>
									<div class="col-sm-8">
										<input type="text" name="realisasi_dana" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Nilai </label>
									<div class="col-sm-8">
										<input type="text" name="jmldana_desa" class="form-control" id="currency">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Tahun Realisasi</label>
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
					
					<div class="col-lg-5">
						<div class="panel panel-default">
							<div class="panel-heading">Sumber Dana Desa</div>
							<div class="panel-body">
								<?php
								$kode_desa = get_user_meta($get_id, 'kode_desa');
								$list_dana = get_list_danadesa($kode_desa);
								$jml_dana  = 0;
								?>
								<table class="table">
									<?php
									$i=1;
									if($list_dana):
									foreach($list_dana as $dana){
										//print_r ($dana);
										echo '<tr>
											<td><input type="radio" name="sumber_dana" value="'.$dana['sumber_dana'].'" class="sumber_dana"></td>
											<td>'.$dana['name'].'</td>
											<td>'.toIDR($dana['jumlah_dana']).'</td>
										</tr>';
										$i++;
										$jml_dana += $dana['jumlah_dana'];
									}
									endif;
									?>
									<tr>
										<td colspan="2">Total Dana Desa</td>
										<td><?=toIDR($jml_dana);?></td>
									</tr>
								</table>
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
						
						$kode_desa  = null;
						$nama_desa  = null;
						$desa		= null;
						if($user_role < 4){
							$kode_desa	= get_user_meta($get_id, 'kode_desa');
							$nama_desa	= get_desa($kode_desa);
							$desa		= get_desaID($nama_desa);
							/*echo 'Level: '.$user_role;
							echo ', Desa: '.$nama_desa;
							echo ', Kode: '.$desaid['kode'];
							echo ', Parent: '.$desaid['parent'];*/
						}
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
								//if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
								if($prov['kode']=="35" || $prov['kode']=="35.15" || $prov['kode']==$desa['kode']){
									if(strlen($prov['kode'])==2){
										echo '<tr>
											<td>'.$prov['kode'].'</td>
											<td>'.strtoupper($prov['nama']).'</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
										</tr>';
									}else{
										echo '<tr>
											<td>p'.$prov['kode'].'</td>
											<td>'.strtoupper($prov['nama']).'</td>
											<td>'.get_danadesa('sumber_dana',$prov['kode']).'</td>
											<td>'.toIDR(get_realisasi('jumlah_dana',$prov['kode'])).'</td>
											<td>'.get_realisasi('tahun_dana',$prov['kode']).'</td>
										</tr>';
									}
									
									//KABUPATEN
									$kabupaten = desa_list(strtolower($prov['tipe']),$prov['kode']);
									foreach($kabupaten as $kab){
										if($kab['kode']=="35.15" || preg_match("/35.15/i", $kab['parent'])){
											echo '<tr>
												<td>'.$kab['kode'].'</td>
												<td>'.strtoupper($kab['nama']).'</td>
												<td>--</td>
												<td>--</td>
												<td>--</td>
											</tr>';
											
											//KECAMATAN
											$kecamatan = desa_list(strtolower($kab['tipe']),$kab['kode']);
											foreach($kecamatan as $kec){
												if($user_role<4) {
													if($kec['kode']==$desa['parent']){
														echo '<tr>
															<td>'.$kec['kode'].'</td>
															<td><a href="'.$site_url.'/wp-admin/realisasi/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
															<td>--</td>
															<td>'.toIDR(get_realisasi('jumlah_dana',$kec['kode'])).'</td>
															<td>--</td>
														</tr>';
													}												
												}else{
													echo '<tr>
														<td>'.$kec['kode'].'</td>
														<td><a href="'.$site_url.'/wp-admin/realisasi/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
														<td>--</td>
														<td>'.toIDR(get_realisasi('jumlah_dana',$kec['kode'])).'</td>
														<td>--</td>
													</tr>';
												}
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
			
			$("input[name='sumber_dana']").click(function() {
				var val = $(this).val();
				$("select[name='sumber_dana']").val(val);
			});
			
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