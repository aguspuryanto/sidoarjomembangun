<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				<?php
				$nama_desa = null;
				
				$get_id		= $_SESSION['ID'];
				$user_role	= get_user_meta($get_id, 'user_level');
					
				if($user_role < 4) {
					$kode_desa	= get_user_meta($_SESSION['ID'], 'kode_desa');
					$nama_desa	= get_desa($kode_desa);
				}
				?>
				
				<!--overview start-->
				<div class="row">
					<div class="col-md-12">
						<!-- <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3> -->
						<ol class="breadcrumb">
							<li><i class="fa fa-home"></i><a href="<?php echo $site_url;?>/wp-admin/dashboard">Home</a></li>
							<li><i class="fa fa-laptop"></i>Dashboard</li>
							<?php if($nama_desa) echo '<li>'.$nama_desa.'</li>'; ?>
						</ol>
					</div>
				</div>
              
				<?php if($user_role==4){ ?>
				<div class="row">					
					<?php $dana = total_danadesa(); $penduduk = total_penduduk();?>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<a href="<?php echo $site_url;?>/wp-admin/dana"><div class="info-box blue-bg">
							<i class="fa fa-money"></i>
							<div class="count"><?=toBill_3($dana['tot']);?></div>
							<div class="title">Dari <?=$dana['tot_desa'];?> Desa</div>						
						</div></a><!--/.info-box-->			
					</div><!--/.col-->
					
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="info-box brown-bg">
							<i class="fa fa-users"></i>
							<div class="count"><?=toBill_3($penduduk['tot']);?></div>
							<div class="title">Penduduk</div>						
						</div><!--/.info-box-->			
					</div><!--/.col-->				
				</div><!--/.row-->
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-success">
							<div class="panel-heading">Permohonan Pendampingan</div>
							<div class="panel-body">
							<div class="table-responsive"><table class="table">
								<thead>
									<tr>
										<th>Author</th>
										<th>Comments</th>
									</tr>
								</thead>
								<tbody>
								<?php								
								$comments = get_comments();
								if($comments){
									foreach($comments as $comment){
										$get_reply = get_reply($comment['comment_ID']);									
										if($get_reply['total'] > 0) $tr_class = "success"; else $tr_class = "";
										
										echo '<tr class="'.$tr_class.'">
											<td>
												<h4>'.$comment['comment_author'].'</h4>
												<p>'.$comment['comment_author_email'].'</p>
												<p>'.$comment['comment_date'].'</p>
											</td>
											<td>
												<h4>'.$comment['comment_subject'].'</h4>
												<p>'.$comment['comment_content'].'</p>';
												
												if($get_reply['data']['reply_content']) echo '<span class="label label-danger">Jawaban</span>
												<blockquote><h4><i class="glyphicon glyphicon-thumbs-up"></i> </h4> '.$get_reply['data']['reply_content'].'</blockquote>';
												
												echo '<p><a href="pendampingan-list?act=edit&id='.$comment['comment_ID'].'">Edit</a> | <a class="reply" data-id="'.$comment['comment_ID'].'" href="pendampingan-list?act=reply&id='.$comment['comment_ID'].'">Balas</a> </p>
											</td>
										</tr>';
									}
								}
								?>
								</tbody>
							</table></div>
							</div>
						</div>
					</div><!--/.col-->
				</div><!--/.row-->
				
				<?php
				}else{
					//print_r ($_SESSION['ID']);
					$kode_desa	= get_user_meta($_SESSION['ID'], 'kode_desa');
					//print_r ($kode_desa);
					
					$nama_desa	= ucwords(strtolower(get_desa($kode_desa))) . ", Kabupaten Sidoarjo, Jawa Timur";
					
					echo "<h4>".($nama_desa)."</h4>";
					echo "<iframe width='100%' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q=".urldecode($nama_desa)."&amp;output=embed'></iframe>";
					
				?>
				
				<hr>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-success">
							<div class="panel-heading">Permohonan Pendampingan</div>
							<div class="panel-body">
							<div class="table-responsive"><table class="table">
								<thead>
									<tr>
										<th>Author</th>
										<th>Comments</th>
									</tr>
								</thead>
								<tbody>
								<?php								
								$comments = get_comments($get_id);
								if($comments){
									foreach($comments as $comment){
										$get_reply = get_reply($comment['comment_ID']);									
										if($get_reply['total'] > 0) $tr_class = "success"; else $tr_class = "";
										
										echo '<tr class="'.$tr_class.'">
											<td>
												<h4>'.$comment['comment_author'].'</h4>
												<p>'.$comment['comment_author_email'].'</p>
												<p>'.$comment['comment_date'].'</p>
											</td>
											<td>
												<h4>'.$comment['comment_subject'].'</h4>
												<p>'.$comment['comment_content'].'</p>';
												
												if($get_reply['data']['reply_content']) echo '<span class="label label-danger">Jawaban</span>
												<blockquote><h4><i class="glyphicon glyphicon-thumbs-up"></i> </h4> '.$get_reply['data']['reply_content'].'</blockquote>';
												
												echo '<p><a href="pendampingan-list?act=edit&id='.$comment['comment_ID'].'">Edit</a> </p>
											</td>
										</tr>';
									}
								}else{
									echo '<tr>
										<td colspan="4">Data Tidak ditemukan</td>
									</tr>';
								}
								?>
								</tbody>
							</table></div>
							</div>
						</div>
					</div><!--/.col-->
				</div><!--/.row-->
				
				<?php					
				}
				?>
			</section>
      </section>
	  
<?php include ('footer.php'); ?>