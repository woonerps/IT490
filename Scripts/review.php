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
		<title>Game Project | Review</title>

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
                                            <div class="paragraph-row">
                                                <div class="column3">
                                                    <p> </p>
                                                </div>
										        <div class="column6">
                                                    <div class="contact-form commentform" style="margin-top:20px;">
                                                        <form action="Controllers/game_controller.php" method="post" enctype="multipart/form-data">
                                                        
                                                            <p class="contact-form-email">
                                                                <h3 style="float:left;">Graphics - &nbsp;</h3><h3 style="float:left;" id="grOut"> 5</h3>
                                                                <input type="range" min="0" max="5" value="5" name="r_graphics" class="slider" id="grap" oninput="rangeValueChange(this)" required/>
                                                            </p>
                                                            <p class="contact-form-email">
                                                                <h3 style="float:left;">Gameplay - &nbsp;</h3><h3 style="float:left;" id="gpOut"> 5</h3>
                                                                <input type="range" min="0" max="5" value="5" name="r_gameplay" class="slider" id="gamep" oninput="rangeValueChange(this)" required/>
                                                            </p>
                                                            <p class="contact-form-email">
                                                                <h3 style="float:left;">Sound - &nbsp;</h3><h3 style="float:left;" id="soOut"> 5</h3>
                                                                <input type="range" min="0" max="5" value="5" name="r_sound" class="slider" id="sound" oninput="rangeValueChange(this)" required/>
                                                            </p>
                                                            <p class="contact-form-user">
                                                                <h3 style="float:left;">Storyline - &nbsp;</h3><h3 style="float:left;" id="stOut"> 5</h3>
                                                                <input type="range" min="0" max="5" value="5" name="r_storyline" class="slider" id="story" oninput="rangeValueChange(this)" required/>
                                                            </p>
                                                            <p class="contact-form-email">
                                                                <h3 style="float:left;">Presentation - &nbsp;</h3><h3 style="float:left;" id="prOut"> 5</h3>
                                                                <input type="range" min="0" max="5" value="5" name="r_presentation" class="slider" id="pres" oninput="rangeValueChange(this)" required/>
                                                            </p>   
                                                            <input type="hidden" name="r_game" value=<?php echo '"'.$_GET['id'].'"';?>>
                                                            <p><input name="r_submit" type="submit" class="styled-button" value="Send review"></p>
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



    

    <script>

        function rangeValueChange(elem)
        {
            
            switch(elem.name) {
                case "r_graphics":
                    document.getElementById("grOut").innerHTML=elem.value;
                    break;
                case "r_gameplay":
                    document.getElementById("gpOut").innerHTML=elem.value;
                    break;
                case "r_sound":
                    document.getElementById("soOut").innerHTML=elem.value;
                    break;
                case "r_storyline":
                    document.getElementById("stOut").innerHTML=elem.value;
                    break;
                case "r_presentation":
                    document.getElementById("prOut").innerHTML=elem.value;
                    break;
            } 
        }
    </script>
    <!-- END body -->
	</body>
<!-- END html -->
</html> 