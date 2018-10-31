<?php include ('header.php'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1><?php echo $kec;?></h1>
        <p></p>
      </div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="table-responsive"><table class="table table-bordered">
				<thead>
					<tr>
						<th width="54" rowspan="2"><div align="center">KODE</div></th>
						<th width="350" rowspan="2"><div align="center">NAMA DESA</div></th>
						<th width="202" rowspan="2"><div align="center">LUAS WILAYAH (KM2)</div></th>
						<th width="239" rowspan="2"><div align="center">JUMLAH PENDUDUK (Jiwa)</div></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($datakec as $kecamatan){
						$value = ucwords(strtolower($kecamatan['nama'])).', '.ucwords(strtolower($kec)).', Kabupaten Sidoarjo, Jawa Timur';
						echo '<tr id="'.$kecamatan['id'].'" class="edit_tr">
							<td><div class="text-left">'.$kecamatan['kode'].'</div></td>
							<td><div align="left">'.strtoupper($kecamatan['nama']).' <span class="pull-right"><a href="#" data-value="'.$value.'" data-toggle="modal" data-target="#myModal" class="viewMaps"><i class="glyphicon glyphicon-map-marker"></i> Maps</a></span></div></td>
							<td class="edit_td">'.$kecamatan['luas_wilayah'].'</td>
							<td class="edit_td">'.$kecamatan['jml_penduduk'].'</td>
						</tr>';
					}
					?>
				</tbody>
			</table></div>
			
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Mliriprowo</h4>
						</div>
						<div class="modal-body">
							<address>
								<span class="hide">Mliriprowo, Tarik, Kabupaten Sidoarjo, Jawa Timur</span>
							</address>
						</div>
					</div>
				</div>
			</div>
			
			<script src="http://maps.googleapis.com/maps/api/js"></script>
			<script>
			$(document).ready(function () {
				$('#myModal').on('shown.bs.modal', function (e) {
					var desa = $(e.relatedTarget).data('value');
					$(this).find('.modal-title').text( desa );
					$(this).find('.modal-body address').text( desa );
					console.log( desa );
					
					$("address").each(function(){
						var embed ="<iframe width='100%' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
						$(this).append(embed);             
					});
				});
			});
			</script>
			
		</div>
    </div> <!-- /container -->

<?php include ('footer.php'); ?>
