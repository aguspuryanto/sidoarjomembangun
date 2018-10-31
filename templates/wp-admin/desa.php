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
				
				<hr>
				<div class="row">					
					<div class="col-lg-6">
						<?php
						if(isset($_POST['csrf_value'])){
							//var_dump ($_POST);							
							$tipe	= 'DESA';
							$nama	= $_POST['nama'];
							$parent	= $_POST['kabkota'];
							
							if ($_POST['kabkota'] && !preg_match("/^[a-zA-Z]$/", $_POST['kabkota'])) {
								if (preg_match('/KAB/',$_POST['kabkota'])){
									$tipe	= 'KABUPATEN';
								}else{
									$tipe	= 'KOTA';
								}
								$nama	= strtoupper($_POST['kabkota']);
								$parent	= $_POST['prov'];
								
							}
							if ($_POST['kec'] && !preg_match("/^[a-zA-Z]$/", $_POST['kec'])) {
								$tipe	= 'KECAMATAN';
								$nama	= strtoupper($_POST['kec']);
								$parent	= substr($_POST['kode'], 0, -3);
								
							}
							if ($_POST['nama'] && !preg_match("/^[a-zA-Z]$/", $_POST['kec'])) {
								$tipe	= 'DESA';
								$nama	= strtoupper($_POST['nama']);
								$parent	= substr($_POST['kode'], 0, -5);
								
							}else{
								//$nama	= strtoupper($_POST['nama']);
								//$parent	= strtoupper($_POST['kec']);
								
							}
							
							$data = array(
								'kode' => $_POST['kode'],
								'tipe' => $tipe,
								'nama' => $nama,
								'parent' => $parent,
							);
							//print_r ($_POST);
							//print_r ($data);
							
							$hasil = save_wp_bukuinduk($data);							
							if($hasil){
								echo '<div class="text-center"><div class="alert alert-info">
									<h4>DATA TERSIMPAN. KODE BUKU INDUK : ' . $_POST['kode'] . '</h4>
								</div></div>';
							}
						}
						
						$kode_prov = array("Nanggroe Aceh Darussalam" => "11", "Sumatera Utara" => "12", "Sumatera Barat" => "13", "Riau" => "14", "Jambi" => "15", "Sumatera Selatan" => "16", "Bengkulu" => "17", "Lampung" => "18", "Kep. Bangka Belitung" => "19", "Kep. Riau" => "21", "DKI Jakarta" => "31", "Jawa Barat" => "32", "Jawa Tengah" => "33", "DI Yogyakarta" => "34", "Jawa Timur" => "35", "Banten" => "36", "Bali" => "51", "Nusa Tenggara Barat" => "52", "Nusa Tenggara Timur" => "53", "Kalimantan Barat" => "61", "Kalimantan Tengah" => "62", "Kalimantan Selatan" => "63", "Kalimantan Timur" => "64", "Sulawesi Utara" => "71", "Sulawesi Tengah" => "72", "Sulawesi Selatan" => "73", "Sulawesi Tenggara" => "74", "Gorontalo" => "75", "Sulawesi Barat" => "76", "Maluku" => "81", "Maluku Utara" => "82", "Papua" => "91", "Papua Barat" => "92");
						?>
						
						<form class="form-horizontal" method="post">							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA PROVINSI</label>
								<div class="col-sm-8">
									<select class="form-control" name="prov" id="prov" required>
										<option value=""> --- </option>
										<?php
										foreach($kode_prov as $prov => $kode){
											if($kode=='35') echo '<option value="'.$kode.'">'.strtoupper($prov).'</option>';
										}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA KABUPATEN/KOTA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kabkota" id="kabkota" list="kabkota_display" placeholder="KABUPATEN SIDOARJO">
									<datalist id="kabkota_display"></datalist>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kec" id="kec" list="kec_display" placeholder="KECAMATAN TARIK">
									<datalist id="kec_display"></datalist>
								</div>
							</div>
							
							<!-- <div class="form-group">
								<label class="col-sm-4 text-left">NAMA KELURAHAN</label>
								<div class="col-sm-8" class="kel">
									<input type="text" class="form-control" name="kel" id="kel">
								</div>
							</div> -->
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA DESA</label>
								<div class="col-sm-8">
								  <input type="text" name="nama" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">KODE BUKU INDUK</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kode" id="kode" required>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Keterangan</label>
								<div class="col-sm-8">
									<textarea name="keterangan" class="form-control" rows="3"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Luas Wilayah (KM2)</label>
								<div class="col-sm-8">
									<input type="text" name="luas_wilayah" class="form-control">
								</div>
							</div>
								
							<div class="form-group">
								<label class="col-sm-4 text-left">Jumlah Penduduk (Jiwa)</label>
								<div class="col-sm-8">
									<input type="text" name="jml_penduduk" class="form-control">
								</div>
							</div>
							
							<button type="submit" class="btn btn-warning btn-lg">Simpan</button>
							<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
						</form>
					</div>
					
				</div><!--/.row-->
			</section>
		</section>
	  
<?php include ('footer.php'); ?>
