<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
              
				<div class="row">				
					<?php
					$get_id		= $_SESSION['ID'];
					$user_role	= get_user_meta($get_id, 'user_level');
					
					/* INSERT */
					if(isset($_POST['insert'])){
						$data = array(
							'post_title' => $db->real_escape_string($_POST['post_title']),
							'post_content' => $db->real_escape_string($_POST['post_content']),
							'post_status' => $_POST['post_status'],
							'post_name' => slugify($_POST['post_title']),
							'post_terms' => $_POST['post_terms'],
							'post_author' => $_POST['post_author']
						);
						
						// Draf
						if($user_role < 4) {
							$data['post_status'] = "draf";
						}
						
						$insert_id	= insert_post($data);
						if($insert_id) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					$authors 	= all_author();
					$categorys 	= get_category_list();
					?>
					
					<div class="col-md-12">										
						<h3>Edit Post</h3>
					</div>
					
					<form method="post">
					<div class="col-md-9">						
						<div class="form-group">
							<input type="text" class="form-control" name="post_title">
							<p class="help-block">Permalink: <?php echo $baseUrl;?>/<span class="slug"></span></p>
						</div>
						<div class="form-group">
							<textarea id="summernote" name="post_content" class="form-control" rows="24"></textarea>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">Custom Fields</div>
							<div class="panel-body">
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">Publish</div>
							<div class="panel-body">
								<div class="form-group">
									<label>Status</label>
									<select name="post_status" class="form-control">
										<option value="draf">Draf</option>
										<option value="publish">Publish</option>
									</select>
								</div>
								<div class="form-group">
									<label>Author</label>
									<select name="post_author" class="form-control">
										<?php foreach($authors as $author){
										echo '<option value="'.$author['ID'].'">'.$author['user_login'].'</option>';
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Category</label>
									<select name="post_terms" class="form-control">
										<?php foreach($categorys as $category){
										echo '<option value="'.$category['term_id'].'">'.$category['name'].'</option>';
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Published on</label>
									<input name="post_date" class="form-control">
								</div>
								<hr>
								<input type="hidden" name="insert" value="1">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
					</form>
				</div><!--/.row-->
				
				<script>
				$(function() {
					var slug = function(str) {
						var $slug = '';
						var trimmed = $.trim(str);
						$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
						replace(/-+/g, '-').
						replace(/^-|-$/g, '');
						return $slug.toLowerCase();
					}
					
					$("input[name='post_title']").change(function() {
						$("span.slug").html( slug($(this).val()) );
					});
				});
				</script>
				
			</section>
		</section>
	  
<?php include ('footer.php'); ?>