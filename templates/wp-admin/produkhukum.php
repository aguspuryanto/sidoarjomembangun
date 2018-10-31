<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->              
				<div class="row">				
					<div class="col-lg-12">
						<div class="page-header">
							<h3>Produk Hukum</h3>
						</div>
					</div>
				</div>
				
				<div class="row">
					<?php
					if(isset($_POST['submit'])){
						
						echo '<div class="col-md-12">';
						// Now Store the file information to a variables for easier access
						$file_name 		= $_FILES['file_peraturan']['name'];
						$file_tmp 		= $_FILES['file_peraturan']['tmp_name'];
						$file_type 		= $_FILES['file_peraturan']['type'];
						$file_size		= $_FILES['file_peraturan']['size'];
						
						$valid_file 	= false;
						$allowedExts 	= array("pdf", "doc", "docx");
						$temp 			= explode(".", $_FILES["file_peraturan"]["name"]);
						$extension 		= end($temp);							
						$uploaded 		= __DIR__ . "/uploads/" . basename($_FILES["file_peraturan"]["name"]);
						
						//can’t be larger than 1 MB
						if($file_size > (1024000)){
							echo '<div class="alert alert-warning"> Oops! Your file\’s size is to large.</div>';
						}elseif(file_exists($uploaded)){
							echo '<div class="alert alert-warning"> '. $file_name . ' already exists. </div>';
						}elseif (($file_size < 1024000) && in_array($extension, $allowedExts)){								
							$res = move_uploaded_file($file_tmp, $uploaded);
							if($res){
								echo '<div class="alert alert-success">
									File is valid, and was successfully uploaded.
								</div>';
							}
						}
						echo '</div>';
						
						$data = array(
							'nomor' => $_POST['nomor'],
							'perihal' => $_POST['perihal'],
							'jenis' => $_POST['category'],
							'tahun' => $_POST['tahun'],
							'ditetapkan' => date('Y-m-d H:i:s', strtotime($_POST['tgl_ditetapkan'])),
							'diundangkan' => date('Y-m-d H:i:s', strtotime($_POST['tgl_diundangkan'])),
							'filename' => $file_name
						);
								
						insert_produkhukum($data);
					}
						
					$earliest_year	= (int)date('Y') - 5;
					$jenis 		= get_produk_cat();//array('Peraturan Daerah', 'Peraturan Bupati', 'Keputusan Bupati', 'Instruksi Bupati', 'Peraturan Daerah lainnya', 'Rancangan Peraturan Daerah');
					?>
					
					<div class="col-md-5 pull-right">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Tambah Kategori</h3>
							</div>
							<div class="panel-body">
								<form id="add_cat" method="post" action="#" class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-8">
											<input type="text" class="form-control" name="cat" placeholder="Tambah Kategori">
										</div>
										<label class="col-sm-4">
											<button type="submit" class="btn btn-primary">Simpan Category</button>
										</label>
									</div>
								</form>
								<div class="cat_result"></div>
							</div>
						</div>
					</div>
					
					<div class="col-md-7 pull-left">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Tambah Produk Hukum</h3>
							</div>							
							<div class="panel-body">
								<form method="post" class="form-horizontal" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-sm-3 control-label">Kategori Peraturan</label>
										<div class="col-sm-9">
											<div class="input-group">
												<select name="category" class="form-control">
													<option value=""> ---- </option>
													<?php foreach($jenis as $cat_id => $cat){
													echo '<option value="'.$cat_id.'">'.$cat.'</option>';
													} ?>
												</select>
												<span class="input-group-addon">
													<a href="#"><i class="glyphicon glyphicon-plus"></i></a>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nomor Peraturan</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="nomor">
										</div>
										<label class="col-sm-3 control-label">Tahun Peraturan</label>
										<div class="col-sm-3">
											<select name="tahun" class="form-control">
											<?php
											foreach (range(date('Y'), $earliest_year) as $x) {
												echo '<option value="'.$x.'">'.$x.'</option>';
											}
											?>
											</select>
										</div>
									</div>
									<div class="form-group hide">
										<label class="col-sm-3 control-label">Tanggal ditetapkan</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="tgl_ditetapkan">
										</div>
										<label class="col-sm-3 control-label">Tanggal diundangkan</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="tgl_diundangkan">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Tentang</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="perihal">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">File Peraturan</label>
										<div class="col-sm-6">
											<input name="file_peraturan" type="file" />
										</div>
										<div class="col-sm-3 text-right">
											<button type="submit" name="submit" class="btn btn-warning">SIMPAN</button>
										</div>
									</div>
								</form>
							</div>
						</div>						
					</div>					
				</div>
				
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive"><table id="dataTables" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Nomor</th>
									<th>Tahun</th>
									<th>Perihal</th>
									<th>Filename</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$list_ph = get_produk_list();
							$r=1;
							if($list_ph):
							foreach($list_ph as $produk){
								echo '<tr>
									<td>'.$r.'.</td>
									<td>'.$produk['nomor'].'</td>
									<td>'.$produk['tahun'].'</td>
									<td>'.$produk['perihal'].'</td>
									<td>'.$produk['filename'].'</td>
								</tr>';
								$r++;
							}
							endif;
							?>
							</tbody>
						</table></div>
						
						<ul class="pagination">
							<?php echo Paging(10, tot_produkhukum());?>
						</ul>
					</div>
				</div>
				
			</section>
		</section>
		
		<script src="<?php echo $template_url;?>/wp-admin/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $template_url;?>/wp-admin/js/dataTables.bootstrap.min.js"></script>
		<script>
		$(document).ready(function() {
			$( "input[name='tgl_ditetapkan'],input[name='tgl_diundangkan']" ).datepicker({
				dateFormat:"dd-mm-yy",
			});
			
			// process the form
			$('form#add_cat').on("submit", function(e) {
				e.preventDefault();					
				$.ajax({
					type: "POST",
					url: "produkhukum/category/add",
					data: $(this).serialize(),
					success: function(respone) {
						$(".cat_result").html(respone)
					}
				});
				return true;
			});
		
			$('#dataTables').DataTable();
		});
		</script>
	  
<?php include ('footer.php'); ?>