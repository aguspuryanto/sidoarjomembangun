<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Pendampingan!</h1>
      </div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-12">
					<?php
					/*<form id="contact-form" method="post" role="form">

                        <?php
						$msg = null;
						if(isset($_POST['csrf_value'])){							
							$data = array(
								'comment_post_ID' => 1,
								'comment_author' => $_POST['name'],
								'comment_author_email' => $_POST['email'],
								'comment_author_hp' => $_POST['phone'],
								'comment_subject' => $_POST['subject'],
								'comment_content' => $_POST['message'],
								'comment_type' => $_POST['category'],
								'comment_parent' => 0,
								'user_id' => 0,
								'comment_author_IP' => current_ip(),
								'comment_agent' => $_SERVER ['HTTP_USER_AGENT'],
								'comment_date' => date('Y-m-d H:i:s'),
								'comment_approved' => 1
							);
							
							$id = insert_comment($data);
							if($id) {
								$msg = '<div class="alert alert-success">
									<p>Terima Kasih, Kami akan segera menindaklanjuti</p>
								</div>';
							}else{
								$msg = '<div class="alert alert-danger">
									<p>Error, Terjadi Kesalahan.</p>
								</div>';
							}
						}
						?>
						<div class="messages"><?php echo $msg;?></div>
                        <div class="controls">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="form_name">Nama Lengkap</label>
                                    <input id="form_name" type="text" name="name" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                    <label for="form_lastname">Email</label>
                                    <input id="form_lastname" type="email" name="email" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                    <label for="form_email">Phone</label>
                                    <input id="form_email" type="text" name="phone" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                    <label for="form_phone">Kategori</label>
                                    <input id="form_phone" type="tel" name="category" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="form_phone">Subject Permasalahan</label>
                                    <input id="form_phone" type="tel" name="subject" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="form_message">Pesan anda</label>
                                    <textarea id="form_message" name="message" class="form-control" placeholder="Message for me" rows="4" required="required"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success btn-send" value="Kirim Pesan">
									<input type="hidden" name="csrf_value" value="<?php echo random_number(16);?>">
                                </div>
                            </div>
                        </div>

                    </form>*/
					?>
					
				<div class="table-responsive">
					<table id="dataTables" class="table table-bordered">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th>Perihal</th>
								<th>Filename</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$list_ph = get_reply_pendampingan();
						$r=1;
						if($list_ph){
						foreach($list_ph as $produk){
							
							$icon = '<i class="glyphicon glyphicon-save"></i>';							
							$pathinfo 	= pathinfo($produk['file_peraturan']);
							if($pathinfo['extension']=="pdf"){
								$icon = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
							}
							if($pathinfo['extension']=="doc"){
								$icon = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
							}
							
							echo '<tr>
								<td>'.$r.'.</td>
								<td>'.$produk['reply_subject'].'</td>
								<td width="30%">'.$icon.' <a target="_blank" href="'.$site_url.'/templates/wp-admin/uploads/'.urlencode($produk['file_peraturan']).'">'.$produk['file_peraturan'].'</a></td>
							</tr>';
							$r++;
						}
						}
						?>
						</tbody>
					</table>
				</div>
						
				<ul class="pagination">
					<?php echo Paging(10, tot_repe());?>
				</ul>
					
			</div>
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
