<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
              
				<div class="row">				
					<?php
					/* INSERT */
					if(isset($_POST['insert'])){
						$data	= array(
							'name' => $_POST['category'],
							'slug' => slugify($_POST['category'])
						);
						
						$save = save_category($data);
						if($save) echo '<div class="alert alert-success">Data User Tersimpan.</div>';
					}
					
					$categorys 	= get_category_list();
					//print_r ($categorys);
					?>
					
					<div class="col-lg-12">										
						<h3>Category</h3>
					</div>
					
					<form method="post">
					<div class="col-lg-4">						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Tambah Category</h3>
							</div>
							<div class="panel-body">
								<form method="post">
									<div class="form-group">
										<label>Nama Category</label>
										<input name="category" class="form-control">
									</div>
									<input type="hidden" name="insert" value="1">
									<button type="submit" class="btn btn-primary">Submit</button>
								</form>
							</div>
						</div>
					</div>
					
					<div class="col-lg-8">
						<table class="table table-bordered">
							<thead>
							<tr>
								<th width="5%">ID</th>
								<th>Nama</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($categorys as $item){
								echo '<tr>
									<td>'.$item['term_id'].'.</td>
									<td>'.$item['name'].'</td>
								</tr>';
								}
								?>
							</tbody>
						</table>
					</div>
					</form>
				</div><!--/.row-->
				
				<script>
				$(function() {
					
				});
				</script>
				
			</section>
		</section>
	  
<?php include ('footer.php'); ?>