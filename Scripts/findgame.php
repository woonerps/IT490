<?php
	require_once('Controllers/groupe_controller.php');
	$groupes=getUserGroupesmk($_SESSION['loggedinUser']);
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project  | Invite</title>

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
										<div class="column8">
											<h3> Find a game</h3>
											<form method="get" onkeypress="return event.keyCode != 13;">
                                                <p class="contact-form-email">
                                                    Game title
                                                    <input type="text" id="gametitle" name="fg_gametitle" placeholder="Game title" required/>
                                                </p>
											</form>
											<button id='search' class="styled-button">Search</button>
                                            <p id="resultHolder">

                                            </p>
										</div>
										
										<div class="column2">
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

        <script>
        $('#search').click(function() 
        {
			$('#resultHolder').html('loading');
            var title = $('#gametitle').val();
            $('.text').text('loading . . .');
            $.ajax(
                {
                type:"GET",
                url:"gamesearch.php",
                dataType: "html",
                data: { 
                    gameid: title
                },
                success: function(data) 
                {
                    $('#resultHolder').html(data);
                },
            });
        });
        </script>
    <!-- END body -->
	</body>
<!-- END html -->
</html>