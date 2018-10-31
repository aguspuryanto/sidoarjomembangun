<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Pejabat Desa</h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-lg-12">
					<?php
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');
					$kode_desa	= 0;
						
					if($user_role < 4){
						$kode_desa	= get_user_meta($get_id, 'kode_desa');
						$nama_desa	= get_desa($kode_desa);
					}
					
					if(isset($_POST['csrf_value'])){
						$data = array(
							'desa_kode' => $_POST['desa2'],'nama_pejabat' => $_POST['nama_pejabat'],'jabatan' => $_POST['jabatan'],'pangkat' => $_POST['pangkat'],'ruang' => $_POST['ruang'],'tempat_lhr' => $_POST['tempat_lhr'],'tgl_lahir' => date("Y-m-d", strtotime($_POST['tgl_lahir'])),'edu' => $_POST['edu'],'alamat' => $_POST['alamat'],'telp' => $_POST['telp'],'hp' => $_POST['hp'],'email' => $_POST['email']
						);
							
						if($_POST['edit']==0){
							$result = save_pejabat($data);
							header("Location: pejabat");
						}else{
							$result = update_pejabat($data, $_POST['pejabat_id']);
							header("Location: pejabat");
						}
						if($result) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					?>					
					</div>
					
					<?php if(isset($_GET['act'])){
						// GET KECAMATAN
						$kecamatan	= list_bykecamatan();
						
						$res = null;
						$edit = '0';
						$pejabat_id	= isset($_GET['id']) ? $_GET['id'] : '';
						if($pejabat_id){
							$edit	= '1';
							$res = get_pejabat($pejabat_id);
							//print_r ($res);
						}
					?>
					
					<div class="col-lg-6">
						<form class="form-horizontal" method="post">
							
							<div class="form-group">
								<label class="col-sm-4 text-left">NAMA KECAMATAN</label>
								<div class="col-sm-8">
									<select id="kec2" name="kec" class="form-control" <?php if($user_role<4) echo 'disabled';?>>
									<?php if(get_user_meta($get_id, 'kode_kec')){ ?>
										<option value="<?=get_user_meta($get_id, 'kode_kec');?>"><?=get_kecamatan( get_user_meta($get_id, 'kode_kec') );?></option>
									<?php }else{ ?>
										<option></option>
										<?php foreach($kecamatan as $kec){
											echo '<option value="'.$kec['kode'].'">'.$kec['nama'].'</option>';
										}
									}?>
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
								<label class="col-sm-4 text-left">Nama Lengkap</label>
								<div class="col-sm-8">
									<input type="text" name="nama_pejabat" value="<?php echo $res['nama_pejabat'];?>" class="form-control" placeholder="Nama Lengkap">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Jabatan</label>
								<div class="col-sm-8">
									<input type="text" name="jabatan" value="<?php echo $res['jabatan'];?>" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Pangkat & Ruang</label>
								<div class="col-sm-4">
									<input type="text" name="pangkat" value="<?php echo $res['pangkat'];?>" class="form-control">
								</div>
								<div class="col-sm-4">
									<input type="text" name="ruang" value="<?php echo $res['ruang'];?>" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Tempat & Tgl. Lahir</label>
								<div class="col-sm-4">
									<input type="text" name="tempat_lhr" value="<?php echo $res['tempat_lhr'];?>" class="form-control">
								</div>
								<div class="col-sm-4">
									<input type="text" name="tgl_lahir" value="<?php echo $res['tgl_lahir'];?>" class="form-control datepicker">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Pendidikan</label>
								<div class="col-sm-8">
									<input type="text" name="edu" value="<?php echo $res['edu'];?>" class="form-control" placeholder="Misal;S3 - Institut Pertanian Bogor">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Alamat Lengkap</label>
								<div class="col-sm-8">
									<textarea cols="5" name="alamat" value="<?php echo $res['alamat'];?>" class="form-control"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">No. Telp</label>
								<div class="col-sm-8">
									<input type="text" name="telp" value="<?php echo $res['telp'];?>" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">No. Mobile</label>
								<div class="col-sm-8">
									<input type="text" name="hp" value="<?php echo $res['hp'];?>" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 text-left">Email</label>
								<div class="col-sm-8">
									<input type="email" name="email" value="<?=$res['email'];?>" class="form-control">
								</div>
							</div>
							
							<button type="submit" class="btn btn-warning btn-lg">Simpan</button>
							<input type="hidden" name="edit" value="<?php echo $edit;?>">
							<input type="hidden" name="pejabat_id" value="<?php echo $pejabat_id;?>">
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
						//$provinsi = desa_education($tipe,$id);
						
						if($user_role < 4){
							$kode_desa	= get_user_meta($get_id, 'kode_desa');							
							$nama_desa	= get_desa($kode_desa);							
							/*echo 'Level: '.$user_role;
							echo ', Desa: '.$nama_desa;
							echo ', Kode: '.$desaid['kode'];
							echo ', Parent: '.$desaid['parent'];*/
						}
						
						//$list_pejabat	= list_pejabat();
						?>
						
						<p>
							<a class="btn btn-primary" href="?act=new"><i class="glyphicon glyphicon-plus"></i> Tambah Pejabat</a>
						</p>
						<div class="table-responsive">
						<table id="dataTables" class="table table-bordered">
							<thead>
								<tr>
									<th width="10"><div align="center">NO</div></th>
									<th><div align="center">NAMA</div></th>
									<th><div align="center">JABATAN</div></th>
									<th><div align="center">PANGKAT</div></th>
									<th><div align="center">PENDIDIKAN</div></th>
									<th><div align="center">ALAMAT</div></th>
									<th><div align="center">TELP</div></th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$list_pejabat	= list_pejabat();
								if($list_pejabat){
									$i=1;
									foreach($list_pejabat as $pejabat){
										$nama_desa	= get_desa($pejabat['desa_kode']);
										echo '<tr>
											<td>'.$i.'</td>
											<td>'.$pejabat['nama_pejabat'].'</td>
											<td>'.$pejabat['jabatan'].', '.$nama_desa.'</td>
											<td>'.$pejabat['pangkat'].'</td>
											<td>'.$pejabat['edu'].'</td>
											<td>'.$pejabat['alamat'].'</td>
											<td>'.$pejabat['telp'] . $pejabat['hp'].'</td>
											<td><a class="btn btn-default" href="?act=edit&id='.$pejabat['pejabat_id'].'">Edit</a> | <a data-id="'.$pejabat['pejabat_id'].'" class="btn btn-danger delete" href="#">Hapus</a></td>
										</tr>';
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
		
		<script>
		$(function() {
			$(".datepicker").datepicker({
				changeYear:true,
				yearRange: "1950:2010",
				dateFormat: "yy-mm-dd"
			});
			
			$('.delete').on('click', function() {
				var id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: '<?php echo $site_url;?>/wp-admin/pejabat/'+id,
						type: 'DELETE',
						success: function(res) {
							// Do something with the result
						}
					});
					
					$(this).parent().parent().css("background-color","#FF3700");
					$(this).fadeOut(400, function(){
						$(this).parent().parent().remove();
					});
				}
				return false;
			});
			
			$('#dataTables').DataTable();
		});
		</script>
		<script src="<?php echo $template_url;?>/wp-admin/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $template_url;?>/wp-admin/js/dataTables.bootstrap.min.js"></script>
	  
<?php include ('footer.php'); ?>