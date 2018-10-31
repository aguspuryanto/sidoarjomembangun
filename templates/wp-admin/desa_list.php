<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
	  
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12 text-center">
						<h4>BUKU INDUK<br>KODE DAN DATA WILAYAH ADMINISTRASI PEMERINTAHAN PER PROVINSI, KABUPATEN/KOTA DAN KECAMATAN</h4>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 text-center">
						<?php
						$tipe	= isset($tipe) ? $tipe : '';
						$id		= isset($id) ? $id : '';
						//echo ("TIPE: ".$tipe.", KODE: ".$id)."<br>";
						$provinsi = desa_list($tipe,$id);
						?>
						
						<div class="table-responsive"><table class="table table-bordered">
							<thead>
								<tr>
									<th width="54" rowspan="2"><div align="center">KODE</div></th>
									<th width="350" rowspan="2"><div align="center">NAMA <?php if($tipe) echo strtoupper(get_tipe($tipe)); else echo 'PROVINSI / KABUPATEN / KOTA'; ?></div></th>
									<th colspan="5"><div align="center">NAMA / JUMLAH</div></th>
									<th width="202" rowspan="2"><div align="center">LUAS WILAYAH (KM2)</div></th>
									<th width="239" rowspan="2"><div align="center">JUMLAH PENDUDUK (Jiwa)</div></th>
								</tr>
								<tr>
									<th width="69"><div align="center">KABUPATEN</div></th>
									<th width="69"><div align="center">KOTA</div></th>
									<th width="69"><div align="center">KECAMATAN</div></th>
									<th width="86"><div align="center">KELURAHAN</div></th>
									<th width="86"><div align="center">DESA</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($provinsi as $prov){
									if($prov['kode']=="35" || $prov['kode']=="35.15" || preg_match("/35.15/i", $prov['parent'])){
										echo '<tr id="'.$prov['id'].'" class="edit_tr">
											<td><div class="text-left">'.$prov['kode'].'</div></td>
											<td><div align="left">'.strtoupper($prov['nama']).'</div></td>
											<td>'.$prov['kab'].'</td>
											<td>'.$prov['kota'].'</td>
											<td>'.$prov['kec'].'</td>
											<td>'.$prov['kel'].'</td>
											<td>'.$prov['desa'].'</td>
											<td class="edit_td">
												<span id="luas_wilayah_'.$prov['id'].'" class="text" style="display: inline; ">'.$prov['luas_wilayah'].'</span>
												<input type="text" value="'.$prov['luas_wilayah'].'" class="editbox" id="luas_wilayah_input_'.$prov['id'].'" style="display: none; ">
											</td>
											<td class="edit_td">
												<span id="jml_penduduk_'.$prov['id'].'" class="text" style="display: inline; ">'.$prov['jml_penduduk'].'</span>
												<input type="text" value="'.$prov['jml_penduduk'].'" class="editbox" id="jml_penduduk_input_'.$prov['id'].'" style="display: none; ">
											</td>
										</tr>';
										
										$kabupaten = desa_list(strtolower($prov['tipe']),$prov['kode']);
										foreach($kabupaten as $kab){
											if($kab['kode']=="35.15"){
												echo '<tr id="'.$kab['id'].'" class="edit_tr">
													<td><div class="text-left">'.$kab['kode'].'</div></td>
													<td><div align="left">'.strtoupper($kab['nama']).'</div></td>
													<td>'.$kab['kab'].'</td>
													<td>'.$kab['kota'].'</td>
													<td>'.$kab['kec'].'</td>
													<td>'.$kab['kel'].'</td>
													<td>'.$kab['desa'].'</td>
													<td class="edit_td">
														<span id="luas_wilayah_'.$kab['id'].'" class="text" style="display: inline; ">'.$kab['luas_wilayah'].'</span>
														<input type="text" value="'.$kab['luas_wilayah'].'" class="editbox" id="luas_wilayah_input_'.$kab['id'].'" style="display: none; ">
													</td>
													<td class="edit_td">
														<span id="jml_penduduk_'.$kab['id'].'" class="text" style="display: inline; ">'.$kab['jml_penduduk'].'</span>
														<input type="text" value="'.$kab['jml_penduduk'].'" class="editbox" id="jml_penduduk_input_'.$kab['id'].'" style="display: none; ">
													</td>
												</tr>';
												
												$kecamatan = desa_list(strtolower($kab['tipe']),$kab['kode']);
												foreach($kecamatan as $kec){
													echo '<tr id="'.$kec['id'].'" class="edit_tr">
														<td><div class="text-left">'.$kec['kode'].'</div></td>
														<td><div align="left"><a href="'.$site_url.'/wp-admin/list-desa/'.strtolower($kec['tipe']).'/'.$kec['kode'].'">'.strtoupper($kec['nama']).'</a></div></td>
														<td>'.$kec['kec'].'</td>
														<td>'.$kec['kota'].'</td>
														<td>'.$kec['kec'].'</td>
														<td>'.$kec['kel'].'</td>
														<td>'.$kec['desa'].'</td>
														<td class="edit_td">
															<span id="luas_wilayah_'.$kec['id'].'" class="text" style="display: inline; ">'.$kec['luas_wilayah'].'</span>
															<input type="text" value="'.$kec['luas_wilayah'].'" class="editbox" id="luas_wilayah_input_'.$kec['id'].'" style="display: none; ">
														</td>
														<td class="edit_td">
															<span id="jml_penduduk_'.$kec['id'].'" class="text" style="display: inline; ">'.$kec['jml_penduduk'].'</span>
															<input type="text" value="'.$kec['jml_penduduk'].'" class="editbox" id="jml_penduduk_input_'.$kec['id'].'" style="display: none; ">
														</td>
													</tr>';
												}
											}
										}
									}
								}
								?>
							</tbody>
						</table></div>
					</div>
					
					<script type="text/javascript">
					$(document).ready(function(){
						
						$(".edit_tr").click(function(){
							var id = $(this).attr('id');
							$("#luas_wilayah_"+id).hide();
							$("#luas_wilayah_input_"+id).show();
							
							$("#jml_penduduk_"+id).hide();
							$("#jml_penduduk_input_"+id).show();
						}).change(function(){
							var id = $(this).attr('id');
							var luas_wilayah = $("#luas_wilayah_input_"+id).val();
							var jml_penduduk = $("#jml_penduduk_input_"+id).val();
							
							var dataString = 'id='+id+'&luas_wilayah='+luas_wilayah+'&jml_penduduk='+jml_penduduk;
							
							$.ajax({
								type: "POST",
								url: "<?php echo $site_url;?>/wp-admin/tableedit",
								data: dataString,
								cache: false,
								success: function(html){
									console.log(html);
									$("#luas_wilayah_"+id).html(luas_wilayah);
									$("#jml_penduduk_"+id).html(jml_penduduk);
								}
							});
						});
						
						// Edit input box click action
						$(".editbox").mouseup(function() {
							return false
						});

						// Outside click action
						$(document).mouseup(function() {
							$(".editbox").hide();
							$(".text").show();
						});

					});
					</script>
					
				</div><!--/.row-->
			</section>
		</section>
	  
<?php include ('footer.php'); ?>
