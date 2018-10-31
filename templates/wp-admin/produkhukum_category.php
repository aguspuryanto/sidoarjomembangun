<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->              
				<div class="row">				
					<div class="col-lg-12">
						<div class="page-header">
							<h3>Produk Hukum</h3>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<table id="dataTables" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Category</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$sql_query	= $db->query("select * from wp_produk_cat");
							$r=1;
							while($cat = $sql_query->fetch_array()){
								echo '<tr>
									<td>'.$r.'.</td>
									<td>'.$cat['name'].'</td>
								</tr>';
								$r++;
							}
							endif;
							?>
							</tbody>
						</table>
					</div>
				</div>
				
			</section>
      </section>
	  
<?php include ('footer.php'); ?>