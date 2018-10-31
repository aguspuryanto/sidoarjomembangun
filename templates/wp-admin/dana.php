<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Dana Desa <small>Info: http://kawaldesa.org/p/35.15</small></h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-lg-12">
					<?php
					if(isset($_POST['csrf_value'])){
						//print_r ($_POST);
						//Array ( [kec] => 35.15.11 [desa2] => 35.15.11.2019 [sumber_dana] => 7 [jmldana_desa] => 255.507.403 [thndana_desa] => 2015 [csrf_value] => 2002223120452421 )
						
						$data = array(
							'kode_desa' => $_POST['desa2'],'sumber_dana' => $_POST['sumber_dana'],'jumlah_dana' => get_numerics(str_replace(".","",$_POST['jmldana_desa'])),'tahun_dana' => $_POST['thndana_desa']
						);						
						$result = save_danadesa($data);
						if($result) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					if(isset($_POST['tambah_sumberdana'])){
						$sql = "insert into wp_danadesa_cat (`name`) VALUES ('".$_POST['sumberdana']."')";
						$result	= $db->query($sql);
						if($result) echo '<div class="alert alert-warning">Sumber Dana Desa Telah Tersimpan</div>';
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
					
					<div class="col-lg-8">
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
									<label class="col-sm-4 text-left">Sumber Dana Desa</label>
									<div class="col-sm-8">
										<select id="kec2" name="sumber_dana" class="form-control">
											<option></option>
											<?php foreach($sumber_dana as $dana){
												echo '<option value="'.$dana['danacat_id'].'">'.$dana['name'].'</option>';
											} ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Jumlah Dana Desa</label>
									<div class="col-sm-8">
										<input type="text" name="jmldana_desa" class="form-control" id="currency">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 text-left">Tahun Penerimaan</label>
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
								<?php if($user_role==4){ ?>
								<form id="add_sumberdana" method="post" class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-8">
											<input type="text" class="form-control" name="sumberdana" placeholder="Sumber Dana Desa">
										</div>
										<label class="col-sm-4">
											<button type="submit" name="tambah_sumberdana" class="btn btn-primary">Simpan</button>
										</label>
									</div>
								</form>
								<div class="result_sumberdana"></div>
								<?php } ?>
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
							echo ', Kode: '.$nama_desa;
							echo ', Parent: '.$kode_desa;*/
						}
						?>
						
						<p>
							<a class="btn btn-primary" href="?act=new"><i class="glyphicon glyphicon-plus"></i> Tambah Dana Desa</a>
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
							if($tipe=="kecamatan"){
								//$provinsi = desa_listdanadesa($nama_desa);
								foreach($provinsi as $prov){
									//if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
									if($prov['kode']=="35" || $prov['kode']=="35.15" || $prov['kode']==$desa['kode']){
										
										$sql = $db->query("SELECT * FROM  `wp_danadesa` WHERE  `kode_desa` LIKE  '".$prov['kode']."'");
										while($row=$sql->fetch_array()){
											echo '<tr>
												<td>'.$prov['kode'].'</td>
												<td>'.strtoupper($prov['nama']).'</td>
												<td>'.get_desa_cat($row['sumber_dana']).'</td>
												<td align="right">Rp. '.toIDR($row['jumlah_dana']).'</td>
												<td>'.$row['tahun_dana'].'</td>
											</tr>';
										}
									}
								}
							}else{
								foreach($provinsi as $prov){
									//if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
									if($prov['kode']=="35" || $prov['kode']=="35.15" || $prov['kode']==$desa['kode']){
										echo '<tr>
											<td>'.$prov['kode'].'</td>
											<td>'.strtoupper($prov['nama']).'</td>
											<td>'.get_danadesa('sumber_dana',$prov['kode']).'</td>
											<td align="right">Rp. '.toIDR(get_danadesa('jumlah_dana',$prov['kode'])).'</td>
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
													<td align="right">Rp. '.toIDR(get_danadesa('jumlah_dana',$kab['kode'])).'</td>
													<td>'.get_danadesa('tahun_dana',$kab['kode']).'</td>
												</tr>';
												
												//KECAMATAN
												$kecamatan = desa_list(strtolower($kab['tipe']),$kab['kode']);
												//if($user_role<4) $kecamatan = desa_list(strtolower($kab['tipe']),$kode_desa);
												foreach($kecamatan as $kec){
													if($user_role<4) {
														if($kec['kode']==$desa['parent']){
															echo '<tr>
																<td>'.$kec['kode'].'</td>
																<td><a href="'.$site_url.'/wp-admin/dana/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
																<td>'.get_danadesa('sumber_dana',$kec['kode']).'</td>
																<td align="right">Rp. '.toIDR(get_danadesa('jumlah_dana',$kec['kode'])).'</td>
																<td>'.get_danadesa('tahun_dana',$kec['kode']).'</td>
															</tr>';
														}
													}else{
														echo '<tr>
															<td>'.$kec['kode'].'</td>
															<td><a href="'.$site_url.'/wp-admin/dana/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
															<td>'.get_danadesa('sumber_dana',$kec['kode']).'</td>
															<td>'.get_danadesa('jumlah_dana',$kec['kode']).'</td>
															<td>'.get_danadesa('tahun_dana',$kec['kode']).'</td>
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
			/*$('form#add_sumberdana').on("submit", function(e) {
				//e.preventDefault();
				$(".result_sumberdana").html('Loading...');
				$.ajax({
					type: "POST",
					url: "tambahdana",
					data: $(this).serialize(),
					success: function(hasil) {
						$(".result_sumberdana").html(hasil);
					}
				});
				return false;
			});*/
		});
		</script>
	  
<?php include ('footer.php'); ?>