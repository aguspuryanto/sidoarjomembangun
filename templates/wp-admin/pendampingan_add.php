<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-md-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Pendampingan</h3>
					</div>
				</div>
              
				<div class="row">
					<?php					
					$comments = null;
					$user = get_user();
					
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');
					
					if(isset($_POST['csrf_value'])){							
						$data = array(
							'comment_post_ID' => 1,
							'comment_author' => $_POST['comment_author'],
							'comment_author_email' => $_POST['comment_author_email'],
							'comment_author_hp' => $_POST['comment_author_hp'],
							'comment_subject' => $_POST['comment_subject'],
							'comment_content' => $_POST['comment_content'],
							'comment_parent' => 0,
							'user_id' => $get_id,
							'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
							'comment_agent' => $_SERVER ['HTTP_USER_AGENT'],
							'comment_date' => date('Y-m-d H:i:s'),
							'comment_approved' => 1
						);
						
						$id = insert_comment($data);
						if($id) {
							echo '<div class="col-md-12"><div class="alert alert-success">
								<p>Terima Kasih, Kami akan segera menindaklanjuti</p>
							</div></div>';
						}else{
							echo '<div class="col-md-12"><div class="alert alert-danger">
								<p>Error, Terjadi Kesalahan.</p>
							</div></div>';
						}
					}
					?>
					
					<div class="col-md-8">
						
						<form class="form-horizontal" method="post">
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_author" value="<?=$user['display_name'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="comment_author_email" value="<?=$user['user_email'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Handphone</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_author_hp" value="<?=$comments['comment_author_hp'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Subject</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_subject" value="<?=$comments['comment_subject'];?>">
								</div>
							</div>
							<div class="form-group hide">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="comment_type" value="<?=$comments['comment_type'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pesan</label>
								<div class="col-sm-10">
									<textarea name="comment_content" class="form-control" rows="4"><?=$comments['comment_content'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-warning">Update</button>
									<input type="hidden" name="csrf_value" value="<?=random_number(16);?>">
									<input type="hidden" name="comment_ID" value="<?=$comments['comment_ID'];?>">
								</div>
							</div>
						</form>
					</div>
					
					<div class="col-md-4"></div>
					
				</div><!--/.row-->
			</section>
      </section>
	  
<?php include ('footer.php'); ?>