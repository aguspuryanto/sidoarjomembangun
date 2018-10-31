<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Produk Hukum!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
      </div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-12">
				<?php
				if($id){
					//print_r ($id);
				?>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Perihal</th>
								<th>Nomor</th>
								<th>Tahun</th>
								<th>Filename</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$list_ph = get_produk_list();
						$r=1;
						foreach($list_ph as $produk){
							echo '<tr>
								<td>'.$r.'.</td>
								<td>'.$produk['perihal'].'</td>
								<td>'.$produk['nomor'].'</td>
								<td>'.$produk['tahun'].'</td>
								<td><i class="glyphicon glyphicon-save"></i> <a href="'.$site_url.'/download/produk-hukum/'.$produk['produk_id'].'">'.$produk['filename'].'</a></td>
							</tr>';
							$r++;
						}
						?>
						</tbody>
					</table>
				</div>
						
				<ul class="pagination">
					<?php echo Paging(10, tot_produkhukum());?>
				</ul>
				
				<?php
				}else{
					$jenis = get_produk_cat();				
					foreach($jenis as $key => $value){					
						echo '<div class="col-md-3">
							<a href="'.$site_url.'/produk-hukum/'.$key.'"><div class="thumbnail mybox">
								<h3><span class="glyphicon glyphicon-folder-close"></span>'.$value.'</h3>
							</div></a>
						</div>';
					}
				}
				?>
				
				
			</div>
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
