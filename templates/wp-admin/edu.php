<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Tingkat Pendidikan</h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-lg-12">
					<?php
					if(isset($_POST['csrf_value'])){
						$data = array(
							'desa_kode' => $_POST['desa2'],'edu_sd' => $_POST['sd'],'edu_smp' => $_POST['smp'],'edu_sma' => $_POST['sma'],'edu_diploma' => $_POST['diploma'],'edu_sarjana' => $_POST['Sarjana'],'edu_master' => $_POST['s2'],'edu_doctor' => 0
						);						
						$result = save_edu($data);
						if($result) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');
					?>					
					</div>
					
					<?php if(isset($_GET['act'])){					
						// GET KECAMATAN
						$kecamatan	= list_bykecamatan();
					?>
					
					<div class="col-lg-6">
						<form class="form-horizontal" method="post">
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
								<div class="col-sm-8">
									<select id="kec2" name="kec" class="form-control">
										<option></option>
										<?php foreach($kecamatan as $kec){
											echo '<option value="'.$kec['kode'].'">'.$kec['nama'].'</option>';
										} ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA DESA</label>
								<div class="col-sm-8">
									<select id="desa2" name="desa2" class="form-control">
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan SD</label>
								<div class="col-sm-8">
									<input type="text" name="sd" class="form-control" placeholder="Pendidikan SD">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan SMP</label>
								<div class="col-sm-8">
									<input type="text" name="smp" class="form-control" placeholder="Pendidikan SMP">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan SMA/SMK/STM</label>
								<div class="col-sm-8">
									<input type="text" name="sma" class="form-control" placeholder="Pendidikan SMA/SMK/STM">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan Diploma</label>
								<div class="col-sm-8">
									<input type="text" name="diploma" class="form-control" placeholder="Pendidikan Diploma">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan Sarjana</label>
								<div class="col-sm-8">
									<input type="text" name="Sarjana" class="form-control" placeholder="Pendidikan Sarjana">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Lulusan Master</label>
								<div class="col-sm-8">
									<input type="text" name="s2" class="form-control" placeholder="Pendidikan Master">
								</div>
							</div>
							
							<button type="submit" class="btn btn-warning btn-lg">Simpan</button>
							<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
						</form>
					</div>
					
					<div class="col-lg-6"></div>
					
					<?php }else{ ?>
					
					<div class="col-lg-12">
						<?php
						$tipe	= isset($tipe) ? $tipe : '';
						$id		= isset($id) ? $id : '';
						//echo ("TIPE: ".$tipe.", KODE: ".$id)."<br>";
						$provinsi = desa_education($tipe,$id);
						if($user_role < 4){
							$nama_desa	= get_user_meta($get_id, 'nama_desa');							
							$desaid		= get_desaID($nama_desa);							
							/*echo 'Level: '.$user_role;
							echo ', Desa: '.$nama_desa;
							echo ', Kode: '.$desaid['kode'];
							echo ', Parent: '.$desaid['parent'];*/
						}
						?>
						
						<p>
							<a class="btn btn-primary" href="?act=new"><i class="glyphicon glyphicon-plus"></i> Input Pendidikan</a>
						</p>
						<div class="table-responsive"><table class="table table-bordered">
							<thead>
								<tr>
									<th width="54" rowspan="2"><div align="center">KODE</div></th>
									<th width="350" rowspan="2"><div align="center">NAMA <?php if($tipe) echo strtoupper(get_tipe($tipe)); else echo 'PROVINSI / KABUPATEN / KOTA'; ?></div></th>
									<th colspan="5"><div align="center">NAMA / JUMLAH</div></th>
									<th width="54" rowspan="2"><div align="center">JUMLAH</div></th>
								</tr>
								<tr>
									<th width="69"><div align="center">SD</div></th>
									<th width="69"><div align="center">SMP</div></th>
									<th width="69"><div align="center">SMA</div></th>
									<th width="86"><div align="center">DIPLOMA</div></th>
									<th width="86"><div align="center">SARJANA</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($provinsi as $prov){
									$total	= 0;
									//if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
									if($prov['kode']=="35" || $prov['kode']=="35.15" || $prov['kode']==$desaid['kode']){
										echo '<tr id="'.$prov['id'].'" class="edit_tr">
											<td><div class="text-left">'.$prov['kode'].'</div></td>
											<td><div align="left">'.strtoupper($prov['nama']).'</div></td>
											<td>'.$prov['edu_sd'].'</td>
											<td>'.$prov['edu_smp'].'</td>
											<td>'.$prov['edu_sma'].'</td>
											<td>'.$prov['edu_diploma'].'</td>
											<td>'.$prov['edu_sarjana'].'</td>
											<td>--</td>
										</tr>';
										
										$kabupaten = desa_education(strtolower($prov['tipe']),$prov['kode']);
										foreach($kabupaten as $kab){
											if($kab['kode']=="35.15"){
												echo '<tr id="'.$kab['id'].'" class="edit_tr">
													<td><div class="text-left">'.$kab['kode'].'</div></td>
													<td><div align="left">'.strtoupper($kab['nama']).'</div></td>
													<td>'.$kab['edu_sd'].'</td>
													<td>'.$kab['edu_smp'].'</td>
													<td>'.$kab['edu_sma'].'</td>
													<td>'.$kab['edu_diploma'].'</td>
													<td>'.$kab['edu_sarjana'].'</td>
													<td>--</td>
												</tr>';
												
												$kecamatan = desa_education(strtolower($kab['tipe']),$kab['kode']);
												foreach($kecamatan as $kec){
													$total	= sum_edu('edu_sd', $kec['kode'])+sum_edu('edu_smp', $kec['kode'])+sum_edu('edu_sma', $kec['kode'])+sum_edu('edu_diploma', $kec['kode'])+sum_edu('edu_sarjana', $kec['kode']);
													
													if($user_role<4) {
														if($kec['kode']==$desaid['parent']){
															echo '<tr id="'.$kec['id'].'" class="edit_tr">
																<td><div class="text-left">'.$kec['kode'].'</div></td>
																<td><div align="left"><a href="'.$site_url.'/wp-admin/edu/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></div></td>
																<td>'.sum_edu('edu_sd', $kec['kode']).'</td>
																<td>'.sum_edu('edu_smp', $kec['kode']).'</td>
																<td>'.sum_edu('edu_sma', $kec['kode']).'</td>
																<td>'.sum_edu('edu_diploma', $kec['kode']).'</td>
																<td>'.sum_edu('edu_sarjana', $kec['kode']).'</td>
																<td>'.$total.'</td>
															</tr>';
														}
													}else{
														echo '<tr id="'.$kec['id'].'" class="edit_tr">
															<td><div class="text-left">'.$kec['kode'].'</div></td>
															<td><div align="left"><a href="'.$site_url.'/wp-admin/edu/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></div></td>
															<td>'.sum_edu('edu_sd', $kec['kode']).'</td>
															<td>'.sum_edu('edu_smp', $kec['kode']).'</td>
															<td>'.sum_edu('edu_sma', $kec['kode']).'</td>
															<td>'.sum_edu('edu_diploma', $kec['kode']).'</td>
															<td>'.sum_edu('edu_sarjana', $kec['kode']).'</td>
															<td>'.$total.'</td>
														</tr>';
													}
												}
											}
										}
									}
								}
								?>
							</tbody>
						</table></div>
					</div>
					<?php } ?>
					
				</div><!--/.row-->
			</section>
		</section>
		
		<script>
		$(function() {
			
		});
		</script>
	  
<?php include ('footer.php'); ?>