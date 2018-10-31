<?php include ('header.php'); ?>

    <div class="container main">
		<div class="row">			
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="label label-default"><?php echo get_cat_name($post['post_terms']);?></span>
						<h4><?php echo $post['post_title'];?></h4>
					</div>
					<div class="panel-body">
						<p><?php echo nl2br($post['post_content']);?></p>
					</div>
				</div>
			</div>
			
			<?php include ('sidebar.php'); ?>
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
