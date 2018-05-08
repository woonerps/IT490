<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Login - Register</title>

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
								<h2>Register</h2>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="paragraph-row contact-block">
									
									<div class="column6" style="background-color: rgba(50, 50, 50, 0.2);border-radius: 10px;">
                                        <div class="contact-address">
											<div class="writecomment">
                                                <div class="panel-title" style="background: #25823b;">
                                                    <h2>Login</h2>
												</div>

												<?php
													if(isset($_GET['error']))
													{
														if($_GET['error']=='logEr')
														{
															echo '<div class="info-message error">
																	<span class="icon-text">&#9888;</span>
																	<b>Login error</b>
																	<p>Invalide username or password</p>
																	<div class="clear-float"></div>
																</div>';
														}
													}
												?>

                                                <div class="contact-form commentform" style="margin-top:20px;">
                                                    <form action="Controllers/user_controller.php" method="post">
                                                        <p class="contact-form-user">
                                                            Username
                                                            <input type="text" class="error" placeholder="Username" name="username" id="c_name" required/>
                                                        </p>
                                                        <p class="contact-form-user">
                                                            Password
                                                            <input type="password" class="error" placeholder="Password" name="password" id="c_name" required/>
                                                        </p>
                                                        
                                                        <p><input name="l_submit" type="submit" class="styled-button" value="Login"></p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

									<div class="column6" style="background-color: rgba(50, 50, 50, 0.2);border-radius: 10px;">
										<div class="contact-address">
											<div class="writecomment">
                                                <div class="panel-title" style="background: #25823b;">
                                                    <h2>Register</h2>
												</div>
												
												<?php
													if(isset($_GET['error']))
													{
														if($_GET['error']=='regEr')
														{
															echo '<div class="info-message error">
																	<span class="icon-text">&#9888;</span>
																	<b>Register error</b>
																	<p>'.$_SESSION['registerError'].'</p>
																	<div class="clear-float"></div>
																</div>';
														}
													}
												?>

												<div class="contact-form commentform" style="margin-top:20px;">
													<form action="Controllers/user_controller.php" method="post">

														<p class="contact-form-user">
                                                            Username
															<input type="text" class="error" placeholder="Username" name="r_username" id="c_name" required/>
                                                        </p>
                                                        <p class="contact-form-user">
                                                            Password
															<input type="password" class="error" placeholder="Password" name="r_password" id="c_name" required/>
                                                        </p>
                                                        <p class="contact-form-user">
                                                            Confirm password
                                                            <input type="password" class="error" placeholder="Confirm password" name="r_confpassword" id="c_name" required/>
                                                        </p>
														<p class="contact-form-email">
                                                            Email
															<input type="text" placeholder="E-mail" name="r_email" id="c_email" required/>
														</p>
														<p><input name="r_submit" type="submit" class="styled-button" value="Register"></p>
													</form>
												</div>
											</div>
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