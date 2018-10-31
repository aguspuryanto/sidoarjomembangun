
      <!--main content end-->
  </section>
  <!-- container section start -->
  
    <script src="<?php echo $template_url;?>/wp-admin/js/bootstrap.min.js"></script>
    <script src="<?php echo $template_url;?>/wp-admin/js/scripts.js"></script>
	<script src="<?php echo $template_url;?>/wp-admin/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo $template_url;?>/wp-admin/js/jquery.nicescroll.js" type="text/javascript"></script>
	<!-- <script src="<?php echo $template_url;?>/wp-admin/js/jquery.autosize.min.js"></script>
	<script src="<?php echo $template_url;?>/wp-admin/js/jquery.placeholder.min.js"></script>
	<script src="<?php echo $template_url;?>/wp-admin/js/jquery.slimscroll.min.js"></script> -->
	
	<script src="<?php echo $template_url;?>/wp-admin/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $template_url;?>/wp-admin/js/dataTables.bootstrap.min.js"></script>
	<script>
    $(function() {		
		$('#dataTables').DataTable();
	});
	</script>
	
	<script>
    $(function() {		
		$('#summernote').summernote({
			height: 300,                 // set editor height
			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
			focus: true                  // set focus to editable area after initializing summernote
		});
		
		$('#prov').on('change', function() {
			var kode = $(this).val();
			$("input[name*='kode']").val( kode + '.' );
			
			$.ajax({
				type: "GET",
				url: "getdatakab/" + kode,
				success: function(res){
					//console.log(res);					
					$('#kabkota_display').html(res);
				}
			});
		});
		
		$('#kabkota').on('input', function() {
			var kode = $(this).val();
			var value = $("#kabkota_display option[value='" + kode + "']").data('id');
			$("input[name*='kode']").val( value + '.' );			
			
			$.ajax({
				type: "GET",
				url: "getdatakec/" + value,
				success: function(res){
					//console.log(res);
					$('#kec_display').html(res);
				}
			});
		});
		
		$('#kec').on('change', function() {
			var kode = $(this).val();
			var value = $("#kec_display option[value='" + kode + "']").data('id');
			if(value){
				$("input[name*='kode']").val( value + '.' );
			}
		});
		
			
		$('#kec2').on('change', function() {
			var kode = $(this).val();
			$.ajax({
				type: "GET",
				url: "<?php echo $site_url;?>/wp-admin/getdatadesa/" + kode,
				success: function(res){
					//console.log(res);
					$('#desa2').html(res);
				}
			});
		});
    });
	</script>

  </body>
</html>