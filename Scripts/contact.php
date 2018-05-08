<?php
if (session_status() == PHP_SESSION_NONE) 
{
	session_start();
}
require_once('Controllers/blog_controller.php');
?>
<!DOCTYPE HTML>
<html lang = "en">
	<head>
		<title>Game Project | Contact Us</title>

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
								<h2>Contact Us</h2>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="contact-block">
									
									<div class="contact-map">
										<iframe width="1200" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?ie=UTF8&amp;t=m&amp;ll=39.959622,-83.000679&amp;spn=0.052631,0.205822&amp;z=13&amp;output=embed"></iframe>
									</div>

								</div>
							
								<div class="paragraph-row contact-block">
									
									<div class="column6">
										<h2>About Our Website</h2>
									        <p>This website aims to gather video-game fans (of all ages and all kinds) in a single
											community of players. The website is a showcase site that presents relevant information on video games. It is a virtual
											meeting place for video game fans in which they can add new games, share news from the world of gaming, 
											share tips and tricks, make comments and criticisms on certain technical aspects, rate games ...
											<p>By registering on the website, the user creates his own member area, he mentions his gaming preferences 
											ie. favorite game platforms, identifier on each game platform, the preferred type of video games, the list
											of games to play. This virtual space also allow members to create groups of players by inviting their friends
											via usernames.</p>
											<p>The website allows members to manage and synchronize their schedules, especially for multiplayer games.
											Indeed, the website offers a schedule matching system allowing a group of players to find the suitable 
											time to play. Each member of the group proposes his availabilities which will be seen by the rest of the 
											players.</p>
											<p>The website provides a game tracking system. This system retains the status of a game (in progress, paused or finished). 
											It will also retains the score and the time taken by each player. This tracking system will calculate the average time to beat each video game. </p>
									</div>

									<div class="column6">
										<div class="contact-address">
											

											<div class="writecomment">
												
												<div class="contact-form commentform">
													<form action="Controllers/user_controller.php" method="post">
														<?php
															if(isset($_GET['error']))
															{
																echo '<div class="info-message error">
																<span class="icon-text">&#9888;</span>
																<b>An Error Occurred</b>
																<p>The email you have inserted is invalid</p>
																<div class="clear-float"></div>
															</div>';
															}
															if(isset($_GET['suc']))
															{
																echo '<div class="info-message success">
																<span class="icon-text">&#10003;</span>
																<b>Great Success !</b>
																<p>Your message has been sent!</p>
																<div class="clear-float"></div>
															</div>';
															}
														?>
														

														<p class="contact-form-user">
															<input type="text" class="error" placeholder="Nickname" name="c_name" id="c_name" />
														</p>
														<p class="contact-form-email">
															<input type="text" placeholder="E-mail" name="c_email" id="c_email" />
														</p>
														<p class="contact-form-message">
															<textarea name="c_message" placeholder="Your message.." id="c_message"></textarea>
														</p>
														<p><input class="styled-button" type="submit" value="Send" name="c_submit"></p>
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