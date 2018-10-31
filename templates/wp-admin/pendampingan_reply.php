<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
				<div class="row">
					<div class="col-md-12">
						<h3 class="page-header"><i class="fa fa-laptop"></i> Balasan Pendampingan</h3>
					</div>
				</div>
              
				<div class="row">
					<div class="col-md-12">
						<?php
						$get_id		= $_SESSION['ID'];
						$user_role	= get_user_meta($get_id, 'user_level');
						?>
						
						<div class="table-responsive"><table id="dataTables" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Pendampingan</th>
									<th>Perihal</th>
									<th>Filename</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$allreply = get_allreply();
							$r=1;
							if($allreply):
							foreach($allreply as $reply){
								$comment = get_comments_ID($reply['comment_ID']);
								echo '<tr>
									<td>'.$r.'.</td>
									<td><a href="'.$site_url.'/wp-admin/pendampingan-list?act=edit&id='.$reply['comment_ID'].'">'.$comment['comment_subject'].'</a></td>
									<td>
										<h4>'.$reply['reply_subject'].'</h4>
										<p>'.$reply['reply_content'].'</p>
									</td>
									<td><a target="_blank" href="'.$site_url.'/templates/wp-admin/uploads/'.($reply['file_peraturan']).'">'.$reply['file_peraturan'].'</a></td>
									<td>';
									
									if($user_role==4) echo ' <a class="trash" id="'.$reply['reply_id'].'" href="#">Hapus</a>';
									
									echo '</td>
								</tr>';
								$r++;
							}
							endif;
							?>
							</tbody>
						</table></div>
						
						<ul class="pagination">
							<?php echo Paging(10, tot_reply());?>
						</ul>
					</div>
					
					<script>
					$(function() {
						$('.trash').on('click', function() {
							var id = $(this).attr('id');
							if (confirm("Are you sure?")) {
								$.ajax({
									url: '<?php echo $site_url;?>/wp-admin/reply/'+id,
									type: 'DELETE',
									success: function(res) {
										// Do something with the result
									}
								});
								
								$(this).parent().parent().parent().css("background-color","#FF3700");
								$(this).fadeOut(400, function(){
									$(this).parent().parent().remove();
								});
							}
							
							return false;
						});
					});
					</script>
					
				</div><!--/.row-->
			</section>
		</section>

	  
<?php include ('footer.php'); ?>