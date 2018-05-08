<?php
	require_once('Controllers/user_controller.php');
	if(isset($_GET['id']))
	{
        if($_GET['id']==$_SESSION['loggedinUser'])
            header('Location:profile.php');
		$userData=getUserInfoById($_GET['id']);
		$avatarPic="";
		
		if($userData[0]['avatar']==null || $userData[0]['avatar']=="")
		{
			$avatarPic= '"uploads/avatars/noAvatar.jpg"';
		}
		else
		{
			$avatarPic= '"uploads/avatars/'.$userData[0]['avatar'].'"';
		}
		$followedGames=getFollowedGames($_GET['id']);
	}
	else
		header('Location:index.php');
	
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Profile</title>

		<!-- Meta Tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

		<!-- Stylesheets -->
		<link type="text/css" rel="stylesheet" href="css/reset.css" />
		<link type="text/css" rel="stylesheet" href="css/main-stylesheet.css" />
		<link type="text/css" rel="stylesheet" href="css/lightbox.css" />
		<link type="text/css" rel="stylesheet" href="css/shortcode.css" />
		<link type="text/css" rel="stylesheet" href="css/fonts.css" />
        <link type="text/css" rel="stylesheet" href="css/colors.css" />
		<!--[if lte IE 8]>
		<link type="text/css" rel="stylesheet" href="css/ie-ancient.css" />
		<![endif]-->
		<link type="text/css" id="style-responsive" rel="stylesheet" media="screen" href="css/responsive/desktop.css" />

		<!-- Demo Only -->
		<link type="text/css" rel="stylesheet" href="css/demo-settings.css" />

	<!-- END head -->
	</head>

	<!-- BEGIN body -->
	<body>

		<!-- BEGIN .boxed -->
		<div class="boxed">
			
			<!-- BEGIN .header -->
            <?php
                include('header.php'); 
            ?>
			<!-- BEGIN .content -->
			<div class="content">
				
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<div class="main-content full-width">

						<div class="panel-block">
							<div class="panel-title">
								<div><h2 style="margin:10px;"><img  src= <?php echo $avatarPic?>  alt="" height="100" style="border:1px dotted black; border-radius:50%;"><span style="margin-left:20px;"><?php echo $userData[0]['username']; ?></span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<div class="panel-content">
							
								<div class="the-article-content">

									<div class="paragraph-row">
										<div class="column8">
                                            <div style="background-color:#a31a1a; color:#ccc;padding-bottom:1px;margin-bottom:10px;;">
                                                <h2>Followed games</h2>
                                            </div>
                                            <ul>
                                                <?php
                                                    if(count($followedGames)>0)
                                                    {
                                                        $counter=0;
                                                        foreach($followedGames as $row)
                                                        {
                                                            $color='';
                                                            if($counter%2==0)
                                                                $color='background-color:rgba(0,0,0,0.2);';
                                                            echo '<div style="padding:2px 2% 2px 2%;'.$color.'">
                                                            <p class="right">Played for : '.$row['timeplayed'].'</p><p style="font-size:1.2em;"><a href="game.php?id='.$row['gameid'].'">'.$row['title'].'</a></p><p>State : '.$row['state'].'</p>
                                                            </div>';
                                                            $counter++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<li class="styled">this user does not follow any game</li>';
                                                    }
                                                ?>
                                                </ul>
                                        </div>
                                    </div>
                                    <div class="column4">
                                        <p></p>
                                    </div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="clear-float"></div>
					
				<!-- END .wrapper -->
				</div>
				
			<!-- BEGIN .content -->
			</div>
			
			<!-- BEGIN .footer -->
			<?php
                include('footer.php'); 
            ?>
			
		<!-- END .boxed -->
		</div>

		<!-- Scripts -->
        <script type="text/javascript" src="jscript/jquery-latest.min.js"></script>
        
		<script type="text/javascript" src="jscript/orange-themes-responsive.js"></script>
		<script type="text/javascript" src="jscript/theme-scripts.js"></script>
		<script type="text/javascript" src="jscript/lightbox.js"></script>
		<script type="text/javascript" src="jscript/demo-settings.js"></script>
    <!-- END body -->
	</body>
<!-- END html -->
</html>