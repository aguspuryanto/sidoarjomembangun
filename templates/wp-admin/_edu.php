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
					<?php
					if(isset($_POST['csrf_value'])){
						echo '<pre>';
						print_r ($_POST);
					}
					
					$res = $db->query("select * from wp_bukuinduk where parent='35.15'");
					while($row = $res->fetch_array()){
						$kecamatan[] = $row;
					}
					//var_dump ($kecamatan);
					?>
					
					<div class="col-lg-6">
						<form class="form-horizontal" method="post">
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
								<div class="col-sm-8">
									<select name="kec" id="kec2" class="form-control">
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
					
				</div><!--/.row-->
			</section>
      </section>
	  
<?php include ('footer.php'); ?>