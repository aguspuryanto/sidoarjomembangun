<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title;?></title>
    <link href="<?php echo $baseUrl;?>/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/dist/jumbotron.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="<?php echo $baseUrl;?>/dist/js/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet">	
	<link href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">
        <div class="card card-container">
            <?php
			if($flash['error']){
				echo '<div class="alert alert-danger">'.$flash['error'].'</div>';
			}
			?>
			
			<img id="profile-img" class="profile-img-card" src="<?php echo $baseUrl;?>/source/upload/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
	
</body>
</html>