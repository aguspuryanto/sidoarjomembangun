    <!-- footer starts here -->
	<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
						<li><a href="<?php echo $baseUrl;?>/berita">Berita</a></li>
						<li><a href="<?php echo $baseUrl;?>/">Gallery</a></li>
						<li><a href="<?php echo $baseUrl;?>/data-desa">Data Desa</a></li>
						<li><a href="<?php echo $baseUrl;?>/pendampingan">Pendampingan</a></li>
						<li><a href="<?php echo $baseUrl;?>/produk-hukum">Produk Hukum</a></li>
						<li><a href="<?php echo $baseUrl;?>/">Report</a></li>
					</ul>
                    <p class="copyright text-muted small">Copyright &copy; 2015. <b>Klinik Pendampingan Hukum Kejaksaan Negeri Sidoarjo</b>.</p>
                    <p class="copyright text-muted">Jl. Sultan Agung No 36, Sidoarjo.</p>
                </div>
            </div>
        </div>
    </footer>
	
</div><!-- #wrapper -->

	<script src="<?php echo $baseUrl;?>/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
    $(function ($) {
        $('#carousel1').carousel({
            interval: 2000
        });
	});
	</script>
	<script type="text/javascript">
	$( document ).ready(function() {
		$(".row-eq-height").each(function() {
			var heights = $(this).find(".col-eq-height").map(function() {
				return $(this).outerHeight();
			}).get(), maxHeight = Math.max.apply(null, heights);

			$(this).find(".col-eq-height").outerHeight(maxHeight);
		});
	});
	</script>
</body>
</html>