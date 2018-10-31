<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Pendampingan</h3>
					</div>
				</div>
              
				<div class="row">
					<?php
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');					
					$act		= isset($_GET['act']) ? $_GET['act'] : '';
					
					// POST
					$csrf_value	= isset($_POST['csrf_value']) ? $_POST['csrf_value'] : '';
					$comment_ID	= isset($_POST['comment_ID']) ? $_POST['comment_ID'] : '';
					$comment_reply	= isset($_POST['comment_reply']) ? $_POST['comment_reply'] : 0;
					
					//var_dump ($_POST);
					if($csrf_value){
						if($comment_reply==0){
							$data = array(
								'comment_author' => $_POST['comment_author'],
								'comment_author_email' => $_POST['comment_author_email'],
								'comment_author_hp' => $_POST['comment_author_hp'],
								'comment_subject' => $_POST['comment_subject'],
								'comment_content' => $_POST['comment_content'],
								'comment_type' => $_POST['comment_type'],
								'comment_author_IP' => '120.161.1.2', //current_ip(),
								'comment_agent' => $_SERVER ['HTTP_USER_AGENT'],
								'comment_date' => date('Y-m-d H:i:s'),
								'comment_approved' => 1
							);
							
							$result = update_comment($data, $comment_ID);
							if($result){
								echo '<div class="col-lg-12">
									<div class="alert alert-warning">Update Tersimpan</div>
								</div>';
							}
						}
						
						if($comment_reply==1){
							// { ["comment_subject"]=> string(26) "Produk Hukum Sudah Selesai" ["reply_subject"]=> string(11) "Kerja Bagus" ["reply_content"]=> string(11) "Kerja Bagus" ["file_peraturan"]=> string(0) "" ["csrf_value"]=> string(16) "5796847265732411" ["comment_ID"]=> string(1) "2" ["comment_reply"]=> string(1) "1" }
							
							//print_r ($_FILES);
							$file_name 		= $_FILES['file_peraturan']['name'];
							$file_tmp 		= $_FILES['file_peraturan']['tmp_name'];
							$file_type 		= $_FILES['file_peraturan']['type'];
							$file_size		= $_FILES['file_peraturan']['size'];
							
							$valid_file 	= false;
							$allowedExts 	= array("pdf", "doc", "docx");
							$temp 			= explode(".", $file_name);
							$extension 		= end($temp);							
							$uploaded 		= __DIR__ . "/uploads/" . basename($file_name);
							$err_msg		= "";
							
							//can’t be larger than 1 MB
							if($file_size > (1024000)){
								$err_msg =  ' Oops! Your file\’s size is to large.';
								//return false;
								
							}elseif (($file_size < 1024000) && in_array($extension, $allowedExts)){								
								move_uploaded_file($file_tmp, $uploaded);
							}
							
							if($err_msg==""){
								$replay = array(
									'comment_ID' => $_POST['comment_ID'],
									'reply_subject' => $_POST['reply_subject'],
									'reply_content' => $_POST['reply_content'],
									'file_peraturan' => $file_name
								);
								
								$result = save_reply($replay);
								//if($result){
									echo '<div class="col-lg-12">
										<div class="alert alert-warning">Data Tersimpan</div>
									</div>';
								//}
							}else{
								$new_err_msg = '<h4>DATA TIDAK TERSIMPAN</h4>';
								$new_err_msg .= '<p>'.$err_msg.'</p>';
								
								echo '<div class="col-lg-12">
									<div class="alert alert-warning"> '.$new_err_msg.' </div>
								</div>';
							}
						}
					}
					?>
					
					<?php if($act=="edit"){ ?>
					
					<div class="col-lg-8">
						<?php $comments = get_comments_ID($_GET['id']); ?>
						<form class="form-horizontal" method="post">
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_author" value="<?php echo $comments['comment_author'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="comment_author_email" value="<?php echo $comments['comment_author_email'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Mobile</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_author_hp" value="<?php echo $comments['comment_author_hp'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Subject</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_subject" value="<?php echo $comments['comment_subject'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_type" value="<?php echo $comments['comment_type'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pesan</label>
								<div class="col-sm-10">
									<textarea name="comment_content" class="form-control" rows="4"><?php echo $comments['comment_content'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-warning">Update</button>
									<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
									<input type="hidden" name="comment_ID" value="<?php echo $comments['comment_ID'];?>">
									<input type="hidden" name="comment_reply" value="0">
								</div>
							</div>
						</form>
					</div>
					
					<div class="col-lg-4">
					</div>
					
					<?php }elseif($act=="reply"){ ?>
					
					<div class="col-lg-8">
						
						<?php $comments = get_comments_ID($_GET['id']); ?>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-sm-2 control-label">Subject</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_subject" value="<?php echo $comments['comment_subject'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Perihal</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="reply_subject" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pesan</label>
								<div class="col-sm-10">
									<textarea id="__summernote" name="reply_content" class="form-control" rows="4"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">File Peraturan</label>
								<div class="col-sm-10">
									<input name="file_peraturan" type="file" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-warning">Update</button>
									<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
									<input type="hidden" name="comment_ID" value="<?php echo $comments['comment_ID'];?>">
									<input type="hidden" name="comment_reply" value="1">
								</div>
							</div>
						</form>
					</div>
					
					<div class="col-lg-4">
					</div>
					
					<?php }else{ ?>
					
					<div class="col-lg-12">
						<table class="table">
							<thead>
								<tr>
									<th><input type="checkbox"></th>
									<th>Author</th>
									<th>Comments</th>
									<th>Subject</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if($user_role==4){
								$comments = get_comments();
							}else{
								$comments = get_comments($get_id);
							}
							
							if($comments){
								foreach($comments as $comment){
									echo '<tr>
										<td><input type="checkbox"></td>
										<td>
											<h4>'.$comment['comment_author'].'</h4>
											<p>'.$comment['comment_author_email'].'</p>
											<p>'.$comment['comment_author_hp'].'</p>
											<p>'.$comment['comment_date'].'</p>
										</td>
										<td>
											<h4>'.$comment['comment_content'].'</h4><p><a href="?act=edit&id='.$comment['comment_ID'].'">Edit</a> | <a class="trash" id="'.$comment['comment_ID'].'" href="#">Hapus</a> ';
											
											if($user_role==4) echo '| <a class="reply" data-id="'.$comment['comment_ID'].'" href="?act=reply&id='.$comment['comment_ID'].'">Balas</a>';
											
										echo '</p></td>
										<td>'.$comment['comment_subject'].'</td>
									</tr>';
								}
							}else{
								echo '<tr>
									<td colspan="4">Data Tidak ditemukan</td>
								</tr>';
							}
							?>
							</tbody>
						</table>
					</div>
					
					<script>
					$(function() {
						$('.trash').on('click', function() {
							var id = $(this).attr('id');
							if (confirm("Are you sure?")) {
								$.ajax({
									url: '<?php echo $site_url;?>/wp-admin/pendampingan/'+id,
									type: 'DELETE',
									success: function(res) {
										// Do something with the result
									}
								});
								
								$(this).parent().parent().parent().css("background-color","#FF3700");
								$(this).fadeOut(400, function(){
									$(this).parent().parent().parent().remove();
								});
							}
							
							return false;
						});
					});
					</script>
					
					<?php
					}
					?>
					
				</div><!--/.row-->
			</section>
      </section>
	  
<?php include ('footer.php'); ?>