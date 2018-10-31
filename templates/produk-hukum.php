<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1><?php echo $title;?></h1>
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
					<table id="dataTables" class="table table-bordered">
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
						$list_ph = get_produk_list($id);
						$r=1;
						if($list_ph){
						foreach($list_ph as $produk){
							
							$icon = '<i class="glyphicon glyphicon-save"></i>';							
							$pathinfo 	= pathinfo($produk['filename']);
							if($pathinfo['extension']=="pdf"){
								$icon = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
							}
							if($pathinfo['extension']=="doc"){
								$icon = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
							}
							
							echo '<tr>
								<td>'.$r.'.</td>
								<td>'.$produk['perihal'].'</td>
								<td>'.$produk['nomor'].'</td>
								<td>'.$produk['tahun'].'</td>
								<td width="30%">'.$icon.' <a target="_blank" href="'.$site_url.'/templates/wp-admin/uploads/'.urlencode($produk['filename']).'">'.$produk['filename'].'</a></td>
							</tr>';
							$r++;
						}
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
	
	<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
	<script>
    $(function() {		
		$('#dataTables').DataTable();
	});
	</script>

<?php include ('footer.php'); ?>
