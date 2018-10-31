<?php
					$files	= 'templates/wp-admin/uploads/*.{jpg,png,gif}';
					
					$files = glob($files, GLOB_BRACE);
					/*usort($files, function ($a, $b) {
					return filemtime($b) - filemtime($a);
					});*/

					$record_count  = 20;
					$totla_pages   = ceil(count($files)/$record_count);
					$page          = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1'; ///make it dyanamic :: page num
					$offset        = ($page-1)*$record_count;
					$files_filter  = array_slice($files, $offset,$record_count);

					$i=1;
					foreach ($files_filter as $file) {
						echo '<div class="col-md-3">
							<div class="panel panel-default thumb">
								<div class="panel-heading">
									<a href="#" class="delete" data-value="'.$file.'" >&times;</a>
								</div>
								<div class="panel-body">
									<a class="pop" href="#">
										<img class="img-responsive" src="'.$site_url.'/'.$file.'" alt="'.$file.'">
									</a>
								</div>
							</div>
						</div>';
						if ($i%4 == 0) echo '</div>
						<div class="row-eq-height">';
						$i++;
					}
					?>
				</div><!--/.row-->
				
				<div class="row">
					<div class="col-md-12">
					<?php
					echo '<nav><ul class="pager">';
					if($totla_pages > 1){
						//if($page != 1){
							echo '<li class="previous"><a href="?page='.($page-1).'"><span aria-hidden="true">&larr;</span> Prev</a></li>';
						//}
						//if($page != $totla_pages){
							echo '<li class="next"><a href="?page='.($page+1).'">Next <span aria-hidden="true">&rarr;</span></a></li>';
						//}
					}
					echo '</ul></nav>';
					?>
					</div>