		<!--sidebar start-->
		<aside>
			<div id="sidebar"  class="nav-collapse ">
				<?php
				$user_level = get_user_meta($_SESSION['ID'], 'user_level');
				?>
				<!-- sidebar menu start-->
				<ul class="sidebar-menu">                
					<li class="active">
						<a href="<?php echo $site_url;?>/wp-admin/dashboard">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard </span>
						</a>
					</li>
					<li class="sub-menu">
						<a href="javascript:;">
                          <i class="icon_document_alt"></i>
                          <span>Data Desa</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
						</a>
						<ul class="sub">
							<?php if($user_level==4){ ?>
							<li><a href="<?php echo $site_url;?>/wp-admin/list-desa">Semua Desa</a></li>                          
							<li><a href="<?php echo $site_url;?>/wp-admin/desa">Buat Baru</a></li>
							<?php } ?>
							<!--<li><a href="#">Jumlah Penduduk</a></li>
							<li><a href="<?php echo $site_url;?>/wp-admin/edu">Tingkat Pendidikan</a></li>-->
							<li><a href="<?php echo $site_url;?>/wp-admin/pejabat">Pejabat Desa</a></li>
							<li><a href="<?php echo $site_url;?>/wp-admin/dana">Dana Desa</a></li>
							<li><a href="<?php echo $site_url;?>/wp-admin/realisasi">Realisasi Desa</a></li>
						</ul>
					</li>       
					<li class="sub-menu">
						<a href="javascript:;">
                          <i class="icon_desktop"></i>
                          <span>Pendampingan</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $site_url;?>/wp-admin/pendampingan-list">Tampilkan Semua</a></li>
							<li><a href="<?php echo $site_url;?>/wp-admin/pendampingan-add">Ajukan Pendampingan</a></li>
							<li><a href="<?php echo $site_url;?>/wp-admin/pendampingan-reply">Balasan Pendampingan</a></li>
						</ul>
					</li>         
					<li class="sub-menu">
						<a href="javascript:;">
                          <i class="icon_desktop"></i>
                          <span>Produk Hukum</span>
						</a>
						<ul class="sub">
							<?php if($user_level==4){?>
							<li><a href="<?php echo $site_url;?>/wp-admin/produkhukum">Tambah</a></li>
							<?php } ?>
							<!-- <?php if($user_level==4) ?> <li><a href="<?php echo $site_url;?>/wp-admin/produkhukum/category">Kategori</a></li> //-->
						</ul>
					</li>           
					<li class="sub-menu">
						<a href="javascript:;">
                          <i class="icon_desktop"></i>
                          <span>Report</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
						</a>
						<ul class="sub">
                          <li><a href="<?php echo $site_url;?>/wp-admin/report">Tampilkan Semua</a></li>
						</ul>
					</li>  
					<li class="sub-menu">
                      <a href="javascript:;">
                          <i class="icon_document_alt"></i>
                          <span>Berita</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
						<ul class="sub">
							<li><a href="<?php echo $site_url;?>/wp-admin/edit">Tampilkan Semua</a></li>                          
							<li><a href="<?php echo $site_url;?>/wp-admin/post-new">Buat Baru</a></li>
							<?php if($user_level==4) ?> <li><a href="<?php echo $site_url;?>/wp-admin/post-category">Kategori</a></li>
						</ul>
					</li>       
					<li class="sub-menu">
                      <a href="javascript:;">
                          <i class="icon_desktop"></i>
                          <span>Media</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a href="<?php echo $site_url;?>/wp-admin/gallery">Gallery</a></li>
                          <!--<li><a href="<?php echo $site_url;?>/wp-admin/gallery/add">Buat Baru</a></li>-->
                      </ul>
					</li>
					<li class="sub-menu">
                      <a href="javascript:;">
                          <i class="icon_table"></i>
                          <span>Users</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
						<ul class="sub">
							<li><a href="<?php echo $site_url;?>/wp-admin/allusers">All Users</a></li>
							<?php if($user_level==4){ ?> <li><a href="<?php echo $site_url;?>/wp-admin/usernew">Buat Baru</a></li> <?php } ?>
						</ul>
					</li>                  
				</ul>
				<!-- sidebar menu end-->
			</div>
		</aside>
		<!--sidebar end-->