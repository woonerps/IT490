<?php
	require_once('Controllers/user_controller.php');
	if(isset($_SESSION['loggedinUser']))
	{
		$userData=getUserInfoById($_SESSION['loggedinUser']);
		$avatarPic="";
		$invites=getInvites();
		if($userData[0]['avatar']==null || $userData[0]['avatar']=="")
		{
			$avatarPic= '"uploads/avatars/noAvatar.jpg"';
		}
		else
		{
			$avatarPic= '"uploads/avatars/'.$userData[0]['avatar'].'"';
		}
		$followedGames=getFollowedGames($_SESSION['loggedinUser']);
	}
	else
		header('Location:register.php');
	
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
								<div><h2 style="margin:10px;"><img  src= <?php echo $avatarPic?>  alt="" height="100" style="border:1px dotted black; border-radius:50%;"><span style="margin-left:20px;"><?php echo $_SESSION['loggedinUsername'] ?></span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">

									<div class="paragraph-row">
										<div class="column4">
											<div class="accordion" >
												<div style="background-color:#ccc">
													<a href="#" style="background-color:#a31a1a; color:#ccc;">Groups</a>
													<div>
														<ul>
															<li class="styled"><a href="addgroup.php">Create group</a></li>
															<li class="styled"><a href="managegroup.php">Manage groups</a></li>
															<li class="styled"><a href="invitegroup.php">Invite user to a group</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="column4">
											<div class="accordion">
												<div style="background-color:#ccc">
													<a href="#" style="background-color:#a31a1a; color:#ccc;">Games</a>
													<div>
														<ul>
														<li class="styled"><a href="findgame.php">Add a new game to your list</a></li>
														<li class="styled">--------------------------------------------------------</li>
															<?php
																foreach($followedGames as $row)
																{
																	echo '<li class="styled"><a href="followedgame.php?id='.$row['gameid'].'&fid='.$row['id'].'">'.$row['title'].'</a></li>';
																}
															?>
															
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="column4">
											<div class="accordion">
												<div style="background-color:#ccc">
													<a href="#" style="background-color:#a31a1a; color:#ccc;">Invites</a>
													<div>
														<ul>
															<?php
																if(count($invites)>0)
																{
																	echo '<table style=" width:100%"><tr><th style="background-color:#333;width:25%;border:1px solid black;">From</th><th style="background-color:#333;width:25%;border:1px solid black;">Group</th><th style="width:25%;"></th><th></th></tr></table>';
																	foreach($invites as $invite)
																	{
																		echo'<li class="styled"><table style="margin:10px 0 10px 0;background-color:#333; width:100%"><tr ><td style="width:25%;padding:10px; border:1px solid black;"> '.$invite['username'].' </td><td style="width:25%;padding:10px; border:1px solid black;"> '.$invite['groupname'].' </td><td style="width:25%;padding:10px; border:1px solid black;"><a href="Controllers/user_controller.php?inv=invite-accept&id='.$invite['id'].'"> Accept </a></td><td style="padding:10px;border:1px solid black;"><a href="Controllers/user_controller.php?inv=invite-refuse&id='.$invite['id'].'"> Decline </a></td></tr></table></li>';
																	}
																}
																else
																{
																	echo '<li class="styled">You have no invites</li>';
																}
															?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="paragraph-row">
										<div class="column6">
											<div class="panel-title" style="background: #a31a1a;">
                                                <h2>Profile</h2>
											</div>
											<?php
												if(isset($_GET['error']))
												{
													if($_GET['error']=='avatar')
													{
														echo '<div class="info-message error">
																<span class="icon-text">&#9888;</span>
																<b>Account error</b>
																<p>'.$_SESSION['avatarError'].'</p>
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
                                                            Email
															<input type="text" placeholder="E-mail" name="p_email"  value=<?php echo '"'.$userData[0]['email'].'"'; ?> required/>
														</p>
														<p class="contact-form-email">
                                                            Name
															<input type="text" placeholder="Name" name="p_name"  value=<?php echo '"'.$userData[0]['name'].'"'; ?> />
														</p>
														<p class="contact-form-email">
                                                            Last name
															<input type="text" placeholder="Last name" name="p_lastname"  value=<?php echo '"'.$userData[0]['lastname'].'"'; ?> />
														</p>
                                                            Gender
														<table><td style="padding:0 50px 0 50px;"><input type="radio" name="p_gender" value="male" <?php echo ($userData[0]['gender']=='male')?'checked':'' ?>> Male</td><td td style="padding:0 50px 0 50px;"><input type="radio" name="p_gender" value="female" <?php echo ($userData[0]['gender']=='female')?'checked':'' ?>> Female</td></table>
														<p class="contact-form-user">
															Profile headline
															<textarea name="p_bio" placeholder="About you.." id="c_message"><?php echo $userData[0]['bio']; ?></textarea>
														</p>
														<p class="contact-form-email">
                                                            Steam ID
															<input type="text" placeholder="Steam ID" name="p_steamid"  value=<?php echo '"'.$userData[0]['steamid'].'"'; ?> />
														</p>
														<p class="contact-form-email">
                                                            Change avatar
															<input type="file" size="60" name="p_avatar" id="p_avatar" accept="image/*"/>
														</p>
														<p><input name="p_submit" type="submit" class="styled-button" value="Save"></p>
													</form>
												</div>
										</div>
										<div class="column6">
											<div class="panel-title" style="background: #a31a1a;">
                                                <h2>Account</h2>
											</div>
											<?php
												if(isset($_GET['error']))
												{
													if($_GET['error']=='aerror')
													{
														echo '<div class="info-message error">
																<span class="icon-text">&#9888;</span>
																<b>Account error</b>
																<p>'.$_SESSION['accountError'].'</p>
																<div class="clear-float"></div>
															</div>';
													}
												}
												if(isset($_GET['success']))
												{
													if($_GET['success']=='suc')
													{
														echo '<div class="info-message success">
															<span class="icon-text">&#10003;</span>
															<b>Success !</b>
															<p>Account updated</p>
															<div class="clear-float"></div>
														</div>';
													}
												}
											?>
											<div class="contact-form commentform" style="margin-top:20px;">
												<form action="Controllers/user_controller.php" method="post">
													<p class="contact-form-user">
														Username
														<input type="text" class="error" placeholder="Username" name="a_username" id="c_name" value=<?php echo '"'.$userData[0]['username'].'"'; ?> required/>
													</p>
													<p class="contact-form-user">
														New password
														<input type="password" class="error" placeholder="New password" name="a_newpassword" id="c_name" required/>
													</p>
													<p class="contact-form-user">
														Confirm password
														<input type="password" class="error" placeholder="Confirm password" name="a_confpassword" id="c_name" required/>
													</p>
													<p class="contact-form-user">
														Old password
														<input type="password" class="error" placeholder="Old password" name="a_oldpassword" id="c_name" required/>
													</p>
													<p><input name="a_submit" type="submit" class="styled-button" value="Save"></p>
												</form>
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