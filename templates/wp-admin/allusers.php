<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				<?php
				$get_id		= $_SESSION['ID'];
				$user_role	= get_user_meta($get_id, 'user_level');
				
				// GET KECAMATAN
				$kecamatan	= list_bykecamatan();
				?>
				<!--overview start-->              
				<div class="row">				
					<div class="col-md-12 clearfix">
						<?php if($user_role == 4){ ?>
						
						<div class="col-md-4">
							<h3>Users <a class="btn btn-default" href="<?php echo $site_url;?>/wp-admin/usernew">Add New</a> </h3>
						</div>
						
						<div class="col-md-8">
							<div class="form-inline">
							<div class="form-group">
								<label>Filter</label>
								<select name="kec" id="filterkec2" class="form-control">
									<option></option>
									<?php foreach($kecamatan as $x => $kec){
										echo '<option value="'.$kec['kode'].'"';
										if(get_user_meta($get_id, 'kode_kec')==$kec['kode']) echo 'selected';
										echo '>'.$kec['nama'].'</option>';
									} ?>
								</select>
							</div>
							</div>
						</div>
						
						<?php
						}else{
						?>
						<h3>Users </h3>
						<?php }	?>
					</div>
				</div>
				
				<div class="row">				
					<div class="col-md-12 clearfix">
					
						<?php
						// echo var_dump( all_users() ); die();
						$user = json_encode(all_users());
						$users = json_decode($user, true);
						// print_r ($users); die();
						?>
						
						<div class="table-responsive"><table id="dataTables" class="table table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Username</th>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
								</tr>
							</thead>
							<tbody>
							<?php							
							if($users){
							foreach($users as $user){
								echo '<tr>
									<td>'.$user['ID'].'</td>
									<td>'.$user['user_login'].' <p><a href="'.$site_url.'/wp-admin/usernew?act=edit&id='.$user['ID'].'">Edit</a>';
									
									if($user_role == 4){
										echo ' | <a href="#" id='.$user['ID'].' class="delete">Hapus</a>';
									}
									
									echo '</p></td>
									<td>'.$user['display_name'].'</td>
									<td>'.$user['user_email'].'</td>
									<td>'.get_user_role($user['ID']).'</td>
								</tr>';
							}
							}
							?>
							</tbody>
						</table></div>
						
						<?php
						/*$offset = 10;
						$total_page = $users['total'];

						if($total_page>=$offset): ?>
						<p></p>
						<div class="text-center"><ul class="pagination pagination-centered pagination-lg">
							<?php echo Paging($offset, $total_page);?>
						</ul></div>
						<?php endif;*/ ?>
					</div>
					
				</div><!--/.row-->
				
				<script>
				$(function() {
					$('.delete').on('click', function() {
						var id = $(this).attr('id');
						if (confirm("Are you sure?")) {
							$.ajax({
								url: '<?php echo $site_url;?>/wp-admin/allusers/'+id,
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
					
					$('#filterkec2').on('change', function() {
						var kode = $(this).val();
						var myUrl = window.location.href;
						myUrl += ((myUrl.indexOf('?') == -1) ? '?' : '&');
						myUrl += "kec="+kode;
						
						if(location.href.indexOf('?') == -1) {
							window.location.href = myUrl;
						}else{
							window.location.href = myUrl.replace(/&?kec=([^&]$|[^&]*)/i, "");
						}
						//console.log(myUrl);
					});
				});
				</script>
				
			</section>
      </section>
	  
<?php include ('footer.php'); ?>