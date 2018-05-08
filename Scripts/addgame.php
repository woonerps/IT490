<?php
	require_once('Controllers/user_controller.php');
	if(isset($_SESSION['loggedinUser']))
		$userData=getUserInfoById($_SESSION['loggedinUser']);
	else
		header('Location:register.php');
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Adding a game</title>

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
								<div><h2 style="margin:10px;"><span style="margin-left:20px;">Adding a game</span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">

                                    <div class="panel-title" style="background: #a31a1a;">
                                                <h2>Game info</h2>
											</div>
											<?php
												if(isset($_GET['error']))
												{
													if($_GET['error']=='avatar')
													{
														echo '<div class="info-message error">
																<span class="icon-text">&#9888;</span>
																<b>Account error</b>
																<p>'.$_SESSION['coverError'].'</p>
																<div class="clear-float"></div>
															</div>';
													}
												}
												if(isset($_GET['success']))
												{
													if($_GET['success']=='avatar')
													{
														echo '<div class="info-message success">
															<span class="icon-text">&#10003;</span>
															<b>Success !</b>
															<p>Profile updated</p>
															<div class="clear-float"></div>
														</div>';
													}
												}
											?>
											<div class="contact-form commentform" style="margin-top:20px;">
													<form action="Controllers/user_controller.php" method="post" enctype="multipart/form-data">
                                                        <p class="contact-form-email">
                                                            Game cover
															<input type="file" size="60" name="g_cover" accept="image/*" required/>
														</p>
                                                        <p class="contact-form-email">
                                                            Game title
															<input type="text" placeholder="Game title" name="g_title" required/>
														</p>
														<p class="contact-form-email">
                                                            Game developper
															<input type="text" placeholder="Game developper" name="g_developper" required/>
														</p>
														<p class="contact-form-email">
                                                            Release date
															<input type="date" name="g_release" required>
														</p>
														<p class="contact-form-user">
                                                            About the game
															<textarea name="g_description" placeholder="Description" id="c_message" required></textarea>
														</p>
														<p class="contact-form-email">
                                                            Tags
															<input type="text" placeholder="action,sci-fy .." name="g_tags" required/>
														</p>   
                                                        
														
														<p><input name="g_submit" type="submit" class="styled-button" value="Add game"></p>
													</form>
												</div>
										</div>
									
                                </div>
							<!-- END .panel-content -->
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