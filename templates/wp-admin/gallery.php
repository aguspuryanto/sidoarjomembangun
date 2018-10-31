<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="container wrapper">            
				<!--overview start-->
				<div class="row-fluid">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-file-image-o"></i> Gallery</h3>
					</div>
				</div>
              
				<div class="row-fluid">					
					<div class="col-md-12">
						<?php
						$get_id 	= $_SESSION['ID'];
						$user_role	= get_user_meta($get_id, 'user_level');
						$kode_desa	= 0;
						
						if($user_role < 4){
							$kode_desa	= get_user_meta($get_id, 'kode_desa');
							$nama_desa	= get_desa($kode_desa);
							$desa		= get_desaID($nama_desa);
						}
						
						$kecamatan	= list_bykecamatan();
				
						if(empty($album_id)){
						?>
							
							<div id="loading" style="display:none;">Loading</div>
							<div id="message"></div>
								
							<form id="gallery" method="post" role="form">
								<div id="image_preview"><img id="previewing" src="" /></div>
								
								<input type="hidden" name="kode_desa" value="<?=$kode_desa;?>">
								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Nama Album</label>
										<input type="text" name="gallery_album" class="form-control">
									</div>
									
									<div class="form-group col-md-12">
										<label class="control-label">Deskripsi Foto</label>
										<textarea class="form-control" name="gallery_desc" rows="5"></textarea>
									</div>
								</div>
								<button type="submit" name="submit" class="btn btn-warning">Simpan Album</button>
							</form>
						
							<hr>
						<?php					
							$albums = list_album();							
							if($albums):
								echo '<table class="table table-striped">
								<thead>
									<tr>
										<th>Nama Album</th>
										<th>Deskripsi</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>';
								foreach($albums as $album){
									echo '<tr>
										<td>
											<a href="gallery/'.$album['album_id'].'">'.$album['nama_album'].'</a>
										</td>
										<td>'.$album['desc_album'].'</td>
										<td><a class="delete_album" href="#" data-value="'.$album['album_id'].'"><i class="glyphicon glyphicon-remove"></i> </a></td>
									</tr>';
								}
								
								echo '</tbody>
								</table>';
							endif;
							
						}else{
							/*$files	= './templates/wp-admin/uploads/*.{jpg,png,gif}';
							$files = glob($files, GLOB_BRACE);
							
							$record_count  = 20;
							$totla_pages   = ceil(count($files)/$record_count);
							$page          = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
							$offset        = ($page-1)*$record_count;
							$files_filter  = array_slice($files, $offset, $record_count);*/
							
							$i=1;
							$files = list_files($album_id);
							//var_dump ($files);
							
							echo '<div class="page-header">
								<h4>Nama Album: '.$files['nama_album'].'</h4>
							</div>';
								
							if($files):
							foreach ($files['data'] as $file) {
							?>
								<div class="col-md-4">
									<div class="panel panel-default thumb">
										<?php if($user_role==4){ ?><div class="panel-heading">
											<a href="#" class="delete" data-value="templates/wp-admin/uploads/<?=$file['files_name'];?>" >&times;</a>
										</div><?php } ?>
										<div class="panel-body">
											<a class="pop" href="#">
												<img class="img-responsive" src="<?=$site_url.'/templates/wp-admin/uploads/'.$file['files_name'];?>" alt="<?=$file['files_name'];?>">
											</a>
										</div>
									</div>
								</div>
								<?php
							}
							endif;
						}
						?>
					</div>
				</div><!--/.row-->
			</section>
		</section>
		
		<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Modal title</h4>
					</div>
					<div class="modal-body">
						<img src="" class="imagepreview" style="width: 100%;" >
					</div>
				</div>
			</div>
		</div>
		
		<script>
		$(function() {
			
			$("#gallery").on('submit',(function(e) {
				e.preventDefault();
				$('#loading').show();
				$.ajax({
					url: "gallery/album",
					type: "POST",
					data: $(this).serialize,
					success: function(data){
						console.log(data);						
						//$('#loading').hide();
						var json = $.parseJSON(data);						
						if(json.result=='success'){
							window.location.href = "newalbum/"+json.id;
						}else{
							var text = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4>' + json.message + '</h4></div>';							
							$("#message").html(text);
						}
					}
				});
			}));
			
			$('.pop').on('click', function() {
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});
			
			$('.delete').on('click', function() {
				var status = confirm("Are you sure you want to delete ?");  
				if(status==true){
					$(this).parent().parent().remove();					
					var filename	= $(this).data('value');
					$.post('delete', {filename:filename}, function(data) {
						console.log(data);
					});
				}				
				return false;
			});
			
			$('.delete_album').on('click', function() {
				var album_id = $(this).data('value');
				var status = confirm("Are you sure you want to delete ?");  
				if(status==true){
					$.get('gallery/delete/'+album_id, function(data) {
						console.log(data);
					});
					$(this).parent().parent().remove();
				}
				return false;
			});
		});
		</script>
	  
<?php include ('footer.php'); ?>