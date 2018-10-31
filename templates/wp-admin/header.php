<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLINIK PENDAMPINGAN HUKUM</title>
    <link href="<?=$template_url;?>/wp-admin/css/bootstrap.min.css" rel="stylesheet">	
	<link href="<?=$template_url;?>/wp-admin/css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?=$template_url;?>/wp-admin/css/elegant-icons-style.css" rel="stylesheet">
    <link href="<?=$template_url;?>/wp-admin/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?=$template_url;?>/wp-admin/css/widgets.css" rel="stylesheet">
    <link href="<?=$template_url;?>/wp-admin/css/style.css" rel="stylesheet">
	<link href="<?=$template_url;?>/wp-admin/css/style-responsive.css" rel="stylesheet" />
	<link href="<?=$template_url;?>/wp-admin/css/jquery-ui-1.10.4.min.css" rel="stylesheet">	
	<link href="<?=$template_url;?>/wp-admin/css/dataTables.bootstrap.min.css" rel="stylesheet">	
    <script src="<?=$template_url;?>/wp-admin/js/jquery.js"></script>
	<script src="<?=$template_url;?>/wp-admin/js/jquery-ui-1.10.4.min.js"></script>	
	<!-- include summernote css/js-->
	<link href="<?=$template_url;?>/wp-admin/css/summernote.css" rel="stylesheet">
	<script src="<?=$template_url;?>/wp-admin/js/summernote.min.js"></script>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
</head>
<body>
	
	<!-- container section start -->
	<section id="container">
  
		<header class="header green-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->
            <a href="<?=$baseUrl;?>/" target="_blank" class="navbar-brand logo hidden-xs">
				KLINIK PENDAMPINGAN HUKUM
			</a>
			
            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" src="<?=$template_url;?>/wp-admin/img/avatar1_small.jpg">
                            </span>
                            <span class="username"><?=$_SESSION['display_name'];?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="<?=$site_url;?>/wp-admin/usernew?act=edit&id=<?=$_SESSION['ID'];?>"><i class="icon_profile"></i> My Profile</a>
                            <li>
                                <a href="<?=$site_url;?>/logout"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
		</header>      
		<!--header end-->