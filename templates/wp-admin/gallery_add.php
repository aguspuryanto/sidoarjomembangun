<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-file-image-o"></i> Gallery</h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-md-12">
						<?php
						if(isset($_POST['submit'])){
							$file_name 		= $_FILES['files']['name'];
							$file_tmp 		= $_FILES['files']['tmp_name'];
							$file_type 		= $_FILES['files']['type'];
							$file_size		= $_FILES['files']['size'];
							
							$valid_file 	= false;
							$allowedExts 	= array("jpg", "png", "gif");
							$temp 			= explode(".", $file_name);
							$extension 		= end($temp);							
							$uploaded 		= __DIR__ . "/uploads/" . basename($file_name);
							
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
						}
						?>
						
						<h4>Select files from your computer</h4>
						<form action="#" method="post" enctype="multipart/form-data">
							<div class="input-group">
								<input class="form-control" type="file" name="files">
								<span class="input-group-btn">
									<button type="submit" name="submit" class="btn btn-default">Upload</button>
								</span>
							</div>
						</form>
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
			$('.pop').on('click', function() {
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});
			
			$('.delete').on('click', function() {
				var status = confirm("Are you sure you want to delete ?");  
				if(status==true){
					$(this).parent().parent().remove();					
					var id	= $(this).data('value');
					$.post('gallery/delete', {post_id:id}, function(data) {
						console.log(data);
					});
				}
				
				return false;
			});
		});
		</script>
	  
<?php include ('footer.php'); ?>