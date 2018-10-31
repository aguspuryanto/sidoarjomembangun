<!-- Sidebar -->
				<div class="col-md-4">
					<div class="widget">
						<img src="<?php echo $site_url;?>/source/upload/sms_center.jpg">
</div>
<div class="widget">
<img src="<?php echo $site_url;?>/source/upload/12787749185968284379.png">
					</div>
					
					<div class="widget">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="panel-title">Login Desa</h3>
							</div>
							<div class="panel-body">
								<form method="post" action="<?php echo $site_url;?>/wp-admin/login">
								  <div class="form-group">
									<label>Email address</label>
									<input type="email" name="inputEmail" class="form-control" placeholder="Email" required>
								  </div>
								  <div class="form-group">
									<label>Password</label>
									<input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
								  </div>
								  <button type="submit" class="btn btn-danger btn-block">Login</button>
								</form>
							</div>
						</div>
					</div>
					
					<div class="widget">
						<ul class="list-group">
							<li class="list-group-item active">JUMLAH DESA PER KECAMATAN</li>
							<?php
							$result = $db->query("SELECT a.*, COUNT(b.id) AS tot FROM wp_bukuinduk a LEFT JOIN wp_bukuinduk b ON b.parent=a.kode WHERE a.parent ='35.15' GROUP BY a.id");
							if($result) : 
								while($row = $result->fetch_array()){
									echo '<li class="list-group-item"><span class="badge">'.$row['tot'].'</span> <a href="'.$site_url.'/detail/'.($row['id']).'">'.$row['nama'].'</a></li>';
								}
							else :
								printf("Errormessage: %s\n", $db->error);
							endif;
							?>
						</ul>
					</div>
					
					<div class="widget">
						<img src="<?php echo $site_url;?>/source/upload/870119933516695165.jpg">
					</div>
				</div>
				<!-- End Sidebar -->