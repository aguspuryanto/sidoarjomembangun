<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Report Dana Desa</h3>
					</div>
				</div>
              
				<div class="row">					
					<div class="col-lg-12">
						<?php
						$tipe	= isset($tipe) ? $tipe : '';
						$id		= isset($id) ? $id : '';
						$get_id		= $_SESSION['ID'];
						$user_role	= get_user_meta($get_id, 'user_level');
						$provinsi = desa_list($tipe, $id);
						
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
						
						<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="10"><div align="center">Kode</div></th>
									<th><div align="center">NAMA PROVINSI / KABUPATEN / KOTA / DESA</div></th>
									<th><div align="center">ANGGARAN</div></th>
									<th><div align="center">REALISASI</div></th>
									<th><div align="center">SISA ANGGARAN</div></th>
									<th><div align="center">%</div></th>
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
											<td>--</td>
										</tr>';
									}else{
										$report1 = report_dana($prov['kode']);
										echo '<tr>
											<td>'.$prov['kode'].'</td>
											<td>'.strtoupper($prov['nama']).'</td>
											<td>'.$report1['dana'].'</td>
											<td>'.$report1['real'].'</td>
											<td>'.$report1['sisa'].'</td>
											<td>'.$report1['persen'].'%</td>
										</tr>';
									}
									
									//KABUPATEN
									$kabupaten = desa_list(strtolower($prov['tipe']),$prov['kode']);
									foreach($kabupaten as $kab){
										if($kab['kode']=="35.15" || preg_match("/35.15/i", $kab['parent'])){
											$report2 = report_dana($kab['kode']);
											echo '<tr>
												<td>'.$kab['kode'].'</td>
												<td>'.strtoupper($kab['nama']).'</td>
												<td>'.$report2['dana'].'</td>
												<td>'.$report2['real'].'</td>
												<td>'.$report2['sisa'].'</td>
												<td>'.$report2['persen'].'%</td>
											</tr>';
											
											//KECAMATAN
											$kecamatan = desa_list(strtolower($kab['tipe']),$kab['kode']);
											foreach($kecamatan as $kec){
												//$dana_desa = get_danadesa('jumlah_dana',$kec['kode']);
												//$real_desa = get_realisasi('jumlah_dana',$kec['kode']);
												//$sisa_angg = intval($dana_desa-$real_desa);
												
												$report3 = report_dana($kec['kode']);												
												if($user_role<4) {
													if($kec['kode']==$desa['parent']){
														echo '<tr>
															<td>'.$kec['kode'].'</td>
															<td><a href="'.$site_url.'/wp-admin/report/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
															<td>'.$report3['dana'].'</td>
															<td>'.$report3['real'].'</td>
															<td>'.$report3['sisa'].'</td>
															<td>'.$report3['persen'].'%</td>
														</tr>';
													}
												}else{
													echo '<tr>
														<td>'.$kec['kode'].'</td>
														<td><a href="'.$site_url.'/wp-admin/report/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></td>
														<td>'.$report3['dana'].'</td>
														<td>'.$report3['real'].'</td>
														<td>'.$report3['sisa'].'</td>
														<td>'.$report3['persen'].'%</td>
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