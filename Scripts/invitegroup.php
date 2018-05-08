<?php
	require_once('Controllers/groupe_controller.php');
	$groupes=getUserGroupesmk($_SESSION['loggedinUser']);
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Invite</title>

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
								<div><h2 style="margin:10px;"><span style="margin-left:20px;">Inviting users</span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">
                                    <div class="paragraph-row">
                                        <div class="column2">
											<p></p>
										</div>
										<div class="column6">
                                        <?php
                                            if(isset($_GET['error']))
                                            {
                                                if($_GET['error']=='notfount')
                                                {
                                                    echo '<div class="info-message error">
                                                            <span class="icon-text">&#9888;</span>
                                                            <b>Invite error</b>
                                                            <p>User not found</p>
                                                            <div class="clear-float"></div>
                                                        </div>';
                                                }
                                                if($_GET['error']=='sent')
                                                {
                                                    echo '<div class="info-message error">
                                                            <span class="icon-text">&#9888;</span>
                                                            <b>Invite error</b>
                                                            <p>Invite already sent to this user</p>
                                                            <div class="clear-float"></div>
                                                        </div>';
												}
												if($_GET['error']=='member')
                                                {
                                                    echo '<div class="info-message error">
                                                            <span class="icon-text">&#9888;</span>
                                                            <b>Invite error</b>
                                                            <p>User is already a member of that group</p>
                                                            <div class="clear-float"></div>
                                                        </div>';
												}
												if($_GET['error']=='selftinv')
                                                {
                                                    echo '<div class="info-message error">
                                                            <span class="icon-text">&#9888;</span>
                                                            <b>Invite error</b>
                                                            <p>You cant send an invite to yourself</p>
                                                            <div class="clear-float"></div>
                                                        </div>';
                                                }
                                            }
                                            if(isset($_GET['success']))
                                            {
                                                if($_GET['success']=='sent')
                                                {
                                                    echo '<div class="info-message success">
                                                        <span class="icon-text">&#10003;</span>
                                                        <b>Success !</b>
                                                        <p>Invite sent</p>
                                                        <div class="clear-float"></div>
                                                    </div>';
                                                }
                                            }
                                        ?>
											<h3> Invite User</h3>
											<form action="Controllers/groupe_controller.php" method="post">
                                                <p class="contact-form-email">
                                                    Username
                                                    <input type="text" name="i_username" oninput="resetHoures()" required/>
                                                </p>
                                                <p class="contact-form-email">
                                                    Group
                                                    <select id="selectedGroupe" name="i_groupe" oninput="showHours()" required>
                                                            <?php 
                                                                foreach($groupes as $groupe)
                                                                {
                                                                    echo '<option value="'.$groupe['id'].'">'.$groupe['name'].'</option>';
                                                                }
                                                            ?>
                                                            
                                                    </select>
                                                </p>
                                                <input class="styled-button" type="submit" value="invite" name="i_submit">
											</form>
										</div>
										
										<div class="column4">
										    <p></p>
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