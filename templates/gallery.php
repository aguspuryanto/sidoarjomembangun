<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <img class="img-responsive" src="<?php echo $site_url;?>/source/upload/posterantikorupsi.gif" width="100%">
      </div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<div class="row">
			
			<?php
			//$album_id = isset($album_id) ? $album_id : '';
			
			if(!$album_id){
				$albums = list_album();
				
				echo '<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading"><i class="fa fa-file-image-o"></i> Gallery</div>
						<div class="panel-body">';
						
						foreach($albums as $album){
							echo '<div class="col-md-3 col-xs-6 thumb">
								<a href="'.$site_url.'/gallery/'.$album['album_id'].'">
									<div class="thumbnail mybox text-center">
										<h1><span class="glyphicon glyphicon-folder-close"></span></h1>
										<small> '.$album['nama_album'].'</small>
									</div>
								</a>
							</div>';
						}
						
						echo '</div>
					</div>
				</div>';
				
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
				
				if($files):
				
				echo '<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Nama Album: '.$files['nama_album'].'</div>
						<div class="panel-body">
							<blockquote>'.$files['desc_album'].'</blockquote><div class="row">';
							
							foreach ($files['data'] as $file) {
							?>
							<div class="col-md-4 col-xs-6 thumb">
								<a class="thumbnail" href="#">
									<img src="<?=$site_url.'/templates/wp-admin/uploads/'.$file['files_name'];?>" alt="<?=$file['files_name'];?>">
								</a>
							</div>
							<?php
								if ($i%3 == 0) echo '</div><div class="row">';
								$i++;
							}
							
						echo '</div></div>
					</div>
				</div>';
				
				else:
				
				echo '<div class="col-md-12  text-center">
					<div class="alert alert-danger">
						<h1><i class="glyphicon glyphicon-bullhorn"></i> Album Tidak Memiliki Foto</h1>
					</div>
				</div>';
				
				endif;				
			}
			?>
		</div>
    </div> <!-- /container -->
	
	
		<script>
		$(function() {
			$('a.thumbnail').on('click', function() {
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});
		});
		</script>
		
		<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Thumbnail Gallery</h4>
					</div>
					<div class="modal-body">
						<img src="" class="imagepreview" style="width: 100%;" >
					</div>
				</div>
			</div>
		</div>

<?php include ('footer.php'); ?>
