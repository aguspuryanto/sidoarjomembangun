<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="container wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-file-image-o"></i> New Album</h3>
					</div>
				
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
						?>
							
						<div id="loading" style="display:none;">Loading</div>
						<div id="message"></div>
							
						<form id="gallery" method="post" enctype="multipart/form-data" role="form">
							<div class="col-md-4">
								<div id="image_preview">
									<img id="previewing" src="https://placehold.it/350x230" />
								</div>
							</div>
							<div class="col-md-8">
								<input type="hidden" name="kode_desa" value="<?=$kode_desa;?>">
								<input type="hidden" name="album_id" value="<?=$album_id;?>">
								<div class="input-group">
									<input class="form-control" id="file" type="file" name="gallery_files">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary">Upload</button>
									</span>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
					</div>
					
					<hr>
					<div class="col-md-12">
						<?php
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
									<div class="panel-heading">
										<a href="#" class="delete" data-value="templates/wp-admin/uploads/<?=$file['files_name'];?>" >&times;</a>
									</div>
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
						?>
					</div>
					
				</div>				
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
					url: "upload",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function(data){
						console.log(data);
						
						$('#loading').hide();
						$('#image_preview').hide();
						$("#message").html(data);
					}
				});
			}));
			
			$(function() {
				$("#file").change(function() {
					var file = this.files[0];
					var imagefile = file.type;
					var match= ["image/jpeg","image/png","image/jpg"];
					if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
					{
						$('#previewing').attr('src','noimage.png');
						$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
						return false;
					}
					else
					{
						var reader = new FileReader();
						reader.onload = imageIsLoaded;
						reader.readAsDataURL(this.files[0]);
					}
				});
			});
			
			function imageIsLoaded(e) {
				$("#file").css("color","green");
				$('#image_preview').addClass("thumbnail");
				//$('#image_preview').css("display", "block");
				$('#previewing').attr('src', e.target.result);
				$('#previewing').attr('width', '350px');
				$('#previewing').attr('height', '230px');
			};
			
			$('.pop').on('click', function() {
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});
			
			$('.delete').on('click', function() {
				var status = confirm("Are you sure you want to delete ?");  
				if(status==true){
					$(this).parent().parent().remove();					
					var filename	= $(this).data('value');
					$.post('/delete', {filename:filename}, function(data) {
						console.log(data);
					});
				}				
				return false;
			});
		});
		</script>
	  
<?php include ('footer.php'); ?>