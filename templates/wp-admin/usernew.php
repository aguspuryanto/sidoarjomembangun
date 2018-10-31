<?php include ('header.php'); ?>

      <?php include ('sidebar.php'); ?>
      
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">            
				<!--overview start-->
              
				<div class="row">				
					<div class="col-lg-12">
						<h3>Add New User</h3>
						<?php
						if(isset($_POST['submit'])){
							//print_r ($_POST);
							$simpan	= save_user();							
						}
						?>
					</div>
				</div>
				
				<div class="row">				
					<div class="col-lg-6">
						<?php
						$edit	= '0';
						$action	= isset($_GET['act']) ? $_GET['act'] : '';
						$get_id	= isset($_GET['id']) ? $_GET['id'] : '';
						
						/*$res['user_login']	= null;
						$res['user_email']	= null;
						$res['display_name']	= null;
						$res['ID']	= null;*/
						$res		= null;
						
						if($get_id){
							$edit	= '1';
							$sql = $db->query("SELECT * FROM wp_users WHERE ID='".$get_id."'");
							while($row = $sql->fetch_array()){
								$res = $row;
							};
						}
						//print_r ($res);
						
						$kode_kec = get_user_meta($get_id, 'kode_kec');
						$kode_desa = get_user_meta($get_id, 'kode_desa');
						$user_role = get_user_role($get_id);
							
						/*print_r (array(
							'kode_kec' => $kode_kec,
							'kode_desa' => $kode_desa,
							'user_level' => $user_role
						));*/
						
						// GET KECAMATAN
						$kecamatan	= list_bykecamatan();
						?>
						
						<form class="form-horizontal" method="post">
							<div class="form-group">
								<label class="col-sm-4 text-left">Username (required)</label>
								<div class="col-sm-8">
								  <input type="text" name="user_login" value="<?php echo $res['user_login'];?>" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Email (required)</label>
								<div class="col-sm-8">
								  <input type="email" name="user_email" value="<?php echo $res['user_email'];?>" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Nama Lengkap</label>
								<div class="col-sm-8">
								  <input type="text" name="display_name" value="<?php echo $res['display_name'];?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Password</label>
								<div class="col-sm-8">
								  <input type="password" name="user_pass" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Kecamatan</label>
								<div class="col-sm-8">
									<select name="kec" id="kec2" class="form-control">
										<option></option>
										<?php foreach($kecamatan as $x => $kec){
											echo '<option value="'.$kec['kode'].'"';
											if(get_user_meta($get_id, 'kode_kec')==$kec['kode']) echo 'selected';
											echo '>'.$kec['nama'].'</option>';
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Desa</label>
								<div class="col-sm-8">
									<select id="desa2" name="nama_desa" class="form-control">
										<option value="<?=get_user_meta($get_id, 'kode_desa');?>"><?=get_desa( get_user_meta($get_id, 'kode_desa') );?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Role</label>
								<div class="col-sm-8">
									<select name="user_role" class="form-control">
									  <option value="0" <?php if(get_user_meta($get_id, 'user_level')==0) echo "selected";?>>Staff</option>
									  <option value="1" <?php if(get_user_meta($get_id, 'user_level')==1) echo "selected";?>>Operator</option>
									  <option value="4" <?php if(get_user_meta($get_id, 'user_level')==4) echo "selected";?>>Administrator</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 text-left">Send User Notification</label>
								<div class="col-sm-8">
								  <div class="checkbox">
									<label>
									  <input name="user_notif" type="checkbox"> Send the new user an email about their account.
									</label>
								  </div>
								</div>
							</div>
							
							<?php if($res['ID']){?>
							<button type="submit" class="btn btn-default">Update User</button>
							<input type="hidden" name="ID" value="<?php echo $res['ID'];?>">
							<?php }else{ ?>
							<button type="submit" class="btn btn-default">Add New User</button>
							<?php } ?>
							<input type="hidden" name="edit" value="<?php echo $edit;?>">
							<input type="hidden" name="submit" value="1">
						</form>
					</div>
					
				</div><!--/.row-->
			</section>
      </section>
	  
<?php include ('footer.php'); ?>