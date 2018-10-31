<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
              
				<div class="row">
					<div class="col-md-12">
					<?php
					/* INSERT */
					if(isset($_POST['ID'])){
						$data = array(
							'post_title' => $_POST['post_title'],
							'post_content' => $_POST['post_content'],
							'post_status' => $_POST['post_status'],
							'post_modified' => date('Y-m-d H:i:s'),
							'post_author' => 1
						);
						
						update_post($data, $_POST['ID']);
						echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					$action	= isset($_GET['action']) ? $_GET['action'] : '';
					$postID	= isset($_GET['id']) ? $_GET['id'] : '';
					
					/* DELETE */
					if($action=='delete'){
						delete_post($postID);
					}
					
					/* EDIT */
					if($action=='edit' && $postID){
						$posts 		= get_post($postID);
						$authors 	= all_author();
						$categorys 	= get_category_list();
						//var_dump ($posts);
					?>					
					<h3>Edit Post</h3>
					</div>
					
					<form method="post">
					<div class="col-md-9">						
						<div class="form-group">
							<input type="text" class="form-control" name="post_title" value="<?php echo $posts['post_title'];?>">
							<p class="help-block">Permalink: <?php echo $baseUrl;?>/berita/<?php echo $posts['post_name'];?></p>
						</div>
						<div class="form-group">
							<textarea id="summernote" name="post_content" class="form-control" rows="24"><?php echo $posts['post_content'];?></textarea>
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
										<option value="draf" <?php if($posts['post_status']=='draf') echo 'selected';?>>Draf</option>
										<option value="publish" <?php if($posts['post_status']=='publish') echo 'selected';?>>Publish</option>
									</select>
								</div>
								<div class="form-group">
									<label>Author</label>
									<select name="post_author" class="form-control">
										<?php foreach($authors as $author){
										echo '<option value="'.$author['ID'].'"';
										if($author['ID']==$posts['post_author']) echo 'selected';
										echo '>'.$author['display_name'].'</option>';
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Category</label>
									<select name="post_author" class="form-control">
										<?php foreach($categorys as $category){
										echo '<option value="'.$category['term_id'].'"';
										if($category['term_id']==$posts['post_terms']) echo 'selected';
										echo '>'.$category['name'].'</option>';
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Published on</label>
									<input name="post_date" class="form-control" placeholder="<?php echo $posts['post_date'];?>">
								</div>
								<hr>
								<input type="hidden" name="ID" value="<?php echo $posts['ID'];?>">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
					</form>
					<?php
					}else{
					?>
					
					<div class="col-md-12">						
						<table class="table">
							<thead>
								<tr>
									<th><input type="checkbox"></th>
									<th>Title</th>
									<th>Author</th>
									<th>Categories</th>
									<th>Comments</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$posts = all_posts();
							if($posts){
							foreach($posts as $post){
								echo '<tr>
									<td><input type="checkbox"></td>
									<td>
										<h4>'.$post['post_title'].'</h4>
										<p><a href="?action=edit&id='.$post['ID'].'">Edit</a>';
										
										if(get_user_meta($_SESSION['ID'], 'user_level')==4) {
										echo '| <a class="delete" data-id="'.$post['ID'].'" href="?action=delete&id='.$post['ID'].'">Hapus</a>';
										}
										
										echo '| <a href="'.$baseUrl.'/berita/'.$post['post_name'].'" target="_blank">Lihat</a></p>
									</td>
									<td>'.get_userdata($post['post_author']).'</td>
									<td>'.get_the_category_by_ID($post['post_terms']).'</td>
									<td>'.$post['comment_count'].'</td>
									<td>'.$post['post_status'].'<br>'.$post['post_date'].'</td>
								</tr>';
							}
							}
							?>
							</tbody>
						</table>
						
						<hr>
						<?php
						//echo 'site_url: '.$site_url.'<br>';
						//echo 'base_url: '.$base_url.'<br>';
						//echo 'current_url: '.$current_url.'<br>';
						$per_page = 10;
						$max_page = num_all();
						//echo $max_page;
						?>
						<ul class="pagination">
							<?php echo Paging($per_page, $max_page);?>
						</ul>
						
					</div>
					<?php } ?>
				</div><!--/.row-->
				
				<script>
				$(function() {
					$('tr>td a.delete').click(function(){
						var post_id = $(this).data("id");						
						if(confirm("Hapus Post ID = " + post_id + "?")){
							$.ajax({
								type: 'DELETE',
								url: "post-delete/"+post_id,
								success: function(data){
									$('#hasil').html(data);
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
				
			</section>
		</section>
	  
<?php include ('footer.php'); ?>