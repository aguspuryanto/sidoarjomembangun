<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
				
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="4"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
							  <img src="<?php echo $site_url;?>/source/upload/proyek-mrt.jpg">
							  <div class="carousel-caption">
								<h2 class="sr-only">Heading</h2>
							  </div>
							</div>
							
							<div class="item">
							  <img src="<?php echo $site_url;?>/source/upload/madrid_271941e.jpg">
							  <div class="carousel-caption">
								<h2 class="sr-only">Heading</h2>
							  </div>
							</div>

							<div class="item">
							  <img src="<?php echo $site_url;?>/source/upload/klinik.jpg">
							  <div class="carousel-caption">
								<h2 class="sr-only">Heading</h2>
							  </div>
							</div>
							
							<div class="item">
							  <img src="<?php echo $site_url;?>/source/upload/messi-iniesta_579372f.jpg">
							  <div class="carousel-caption">
								<h2 class="sr-only">Heading</h2>
							  </div>
							</div>

							<div class="item">
							  <img src="<?php echo $site_url;?>/source/upload/kades.jpg">
							  <div class="carousel-caption">
								<h2 class="sr-only">Heading</h2>
							  </div>
							</div>
						</div>

					  <!-- Controls 
					  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					  </a> -->
					</div>
					
					<hr>
					<!-- Row -->
					<div class="category">
						<div class="clearfix">
							<span class="label label-default">Berita Terbaru</span>
						</div>
						
						<br>
						<div class="row">
						<div class="col-md-12">
							<?php
							$category = get_cat_post('',4);
							if($category){
								foreach($category as $post){
									//echo get_imgPost($post['post_content']);
									echo '<div class="media">
										<div class="media-left">
											<a href="#">
												<img class="media-object" src="'.get_imgPost($post['post_content']).'" width="90" height="80">
											</a>
										</div>
										<div class="media-body">
											<h4 class="media-heading"><a href="'.$site_url . '/berita/' . $post['post_name'].'">'.$post['post_title'].'</a></h4>
											<span>'.$post['post_date'].'</span>
											<p>'.get_excerpt($post['post_content']).'</p>
										</div>
									</div>';
								}
							}
							?>
						</div>
						</div>
					</div>
					<!-- End Row -->
					
					<div class="category">
						<div class="banner_tengah">
							<img class="img-responsive" src="<?php echo $site_url;?>/source/upload/posterantikorupsi.gif" width="100%">
						</div>
					</div>
					
				</div>
				
				<?php include ('sidebar.php'); ?>
				
			</div>
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
