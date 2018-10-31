<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title;?></title>
    <link href="<?=$baseUrl;?>/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$baseUrl;?>/dist/jumbotron.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="<?=$baseUrl;?>/dist/js/jquery.min.js"></script>
	<link href="<?=$baseUrl;?>/dist/css/font-awesome.min.css" rel="stylesheet">	
	<link href="<?=$baseUrl;?>/dist/css/dataTables.bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=$baseUrl;?>/">KLINIK PENDAMPINGAN HUKUM</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?=$baseUrl;?>/berita">Berita</a></li>
				<li><a href="<?=$baseUrl;?>/gallery">Gallery</a></li>
				<li><a href="<?=$baseUrl;?>/data-desa">Data Desa</a></li>
				<li><a href="<?=$baseUrl;?>/pendampingan">Pendampingan</a></li>
				<li><a href="<?=$baseUrl;?>/produk-hukum">Produk Hukum</a></li>
				<li><a href="<?=$baseUrl;?>/">Report</a></li>
			</ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>