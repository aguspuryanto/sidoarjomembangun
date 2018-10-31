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
			$i=0;
			foreach($posts as $item){
			?>
			<div class="col-md-4">
				<span class="label label-default"><?php echo get_cat_name($item['post_terms']);?></span>
				<h4><a href="<?php echo $site_url . '/berita/' . $item['post_name'];?>"><?php echo $item['post_title'];?></a></h4>
				<p><?php echo get_excerpt($item['post_content']);?></p>
			</div>
			<?php
				if($i % 3 == 2) echo '</div>
				<hr>
				<div class="row">';
				$i++;
			}
			?>
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
