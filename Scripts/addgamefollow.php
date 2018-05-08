<?php
    require_once('Controllers/game_controller.php');
    if(isset($_GET['id']))
    {
        $game = getGameById($_GET['id']);
        $score = getGameScore($_GET['id']);
        $timeToBeat=getTimeToBeat($_GET['id']);
        
    }
    else
        header('Location:findgame.php');
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Follow a game</title>

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
								<div><h2 style="margin:10px;"><span style="margin-left:20px;">Follow Game</span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">
                                    <div class="paragraph-row">
                                        <div class="column3" style="padding:5px;background-color:rgba(0,0,0,0.1);">
                                            <div class="panel-title">
                                                <h3 style="padding:10px;"><span><?php echo $game['title'] ?> stats</span></h3>
                                            </div>
											<p style="padding:0px 20px 5px 5px;">
                                            <?php if($game['cover']!='') $cover='uploads/covers/'.$game['cover'];else $cover='images/photos/image-22.jpg';?>
                                                <img class="right" width="50%" src="<?php echo $cover ?>" alt="">

                                                <div >
                                                    <p><strong> Time to beat : </strong></p><p><?php if($timeToBeat!="") echo $timeToBeat[0]['timetobeat']; else echo '-Not enough data-'; ?></p>
                                                    <p><strong> Rating :</strong><div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: <?php echo $score ?>%;"></div></div></p>
                                                    <p></p>
                                                </div>
                                            </p>
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
											<h3> Follow game</h3>
											<form action="Controllers/game_controller.php" method="post">
                                                <p class="contact-form-email">
                                                    Game title
                                                    <input type="text" name="gf_title" value="<?php echo $game['title']; ?>" readonly/>
                                                </p>
                                                <p class="contact-form-email">
                                                    Platform
                                                    <select name="gf_platform" id="">
                                                        <option value='Nintendo 3DS'>Nintendo 3DS</option><option value='Nintendo Switch'>Nintendo Switch</option><option value='PC'>PC</option><option value='PlayStation 3'>PlayStation 3</option><option value='PlayStation 4'>PlayStation 4</option><option value='Wii U'>Wii U</option><option value='Xbox 360'>Xbox 360</option><option value='Xbox One'>Xbox One</option><option value='3DO'>3DO</option><option value='Amiga'>Amiga</option><option value='Amstrad CPC'>Amstrad CPC</option><option value='Android'>Android</option><option value='Apple II'>Apple II</option><option value='Arcade'>Arcade</option><option value='Atari 2600'>Atari 2600</option><option value='Atari 5200'>Atari 5200</option><option value='Atari 7800'>Atari 7800</option><option value='Atari Jaguar'>Atari Jaguar</option><option value='Atari Jaguar CD'>Atari Jaguar CD</option><option value='Atari Lynx'>Atari Lynx</option><option value='Atari ST'>Atari ST</option><option value='BBC Micro'>BBC Micro</option><option value='Browser'>Browser</option><option value='ColecoVision'>ColecoVision</option><option value='Commodore 64'>Commodore 64</option><option value='Dreamcast'>Dreamcast</option><option value='Emulated'>Emulated</option><option value='FM Towns'>FM Towns</option><option value='Game & Watch'>Game & Watch</option><option value='Game Boy'>Game Boy</option><option value='Game Boy Advance'>Game Boy Advance</option><option value='Game Boy Color'>Game Boy Color</option><option value='Gear VR'>Gear VR</option><option value='HTC Vive'>HTC Vive</option><option value='Intellivision'>Intellivision</option><option value='Interactive Movie'>Interactive Movie</option><option value='iOS'>iOS</option><option value='Linux'>Linux</option><option value='Mac'>Mac</option><option value='Mobile'>Mobile</option><option value='MSX'>MSX</option><option value='N-Gage'>N-Gage</option><option value='Neo Geo'>Neo Geo</option><option value='Neo Geo CD'>Neo Geo CD</option><option value='Neo Geo Pocket'>Neo Geo Pocket</option><option value='Neo Geo Pocket Color'>Neo Geo Pocket Color</option><option value='NES'>NES</option><option value='Nintendo 2DS'>Nintendo 2DS</option><option value='Nintendo 3DS'>Nintendo 3DS</option><option value='Nintendo 64'>Nintendo 64</option><option value='Nintendo DS'>Nintendo DS</option><option value='Nintendo GameCube'>Nintendo GameCube</option><option value='Nintendo Switch'>Nintendo Switch</option><option value='Oculus Rift'>Oculus Rift</option><option value='OnLive'>OnLive</option><option value='Ouya'>Ouya</option><option value='PC'>PC</option><option value='Philips CD-i'>Philips CD-i</option><option value='PlayStation'>PlayStation</option><option value='PlayStation 2'>PlayStation 2</option><option value='PlayStation 3'>PlayStation 3</option><option value='PlayStation 4'>PlayStation 4</option><option value='PlayStation Mobile'>PlayStation Mobile</option><option value='PlayStation Now'>PlayStation Now</option><option value='PlayStation Vita'>PlayStation Vita</option><option value='PlayStation VR'>PlayStation VR</option><option value='Plug & Play'>Plug & Play</option><option value='PSP'>PSP</option><option value='Sega 32X'>Sega 32X</option><option value='Sega CD'>Sega CD</option><option value='Sega Game Gear'>Sega Game Gear</option><option value='Sega Master System'>Sega Master System</option><option value='Sega Mega Drive/Genesis'>Sega Mega Drive/Genesis</option><option value='Sega Saturn'>Sega Saturn</option><option value='Sharp X68000'>Sharp X68000</option><option value='Super Nintendo'>Super Nintendo</option><option value='Tiger Handheld'>Tiger Handheld</option><option value='TurboGrafx-16'>TurboGrafx-16</option><option value='TurboGrafx-CD'>TurboGrafx-CD</option><option value='Virtual Boy'>Virtual Boy</option><option value='Wii'>Wii</option><option value='Wii U'>Wii U</option><option value='Windows Phone'>Windows Phone</option><option value='WonderSwan'>WonderSwan</option><option value='Xbox'>Xbox</option><option value='Xbox 360'>Xbox 360</option><option value='Xbox One'>Xbox One</option><option value='ZX Spectrum'>ZX Spectrum</option>
                                                    </select>
                                                </p>
                                                <p class="contact-form-email">
                                                    Current Progress
                                                    <table width="80%"><tr>
                                                        <td style="padding : 0 4% 0 4%"><input type="number" data-tip="fuck" name="gf_hour" placeholder="HH" min="0"  required/></td>
                                                        <td style="padding : 0 4% 0 4%"><input type="number" name="gf_min" placeholder="MM" min="0" max="59" required/></td>
                                                        <td style="padding : 0 4% 0 4%"><input type="number" name="gf_sec" placeholder="SS" min="0" max="59" required/></td>
                                                    </tr></table>
                                                </p>
                                                <p class="contact-form-email">
                                                    State
                                                    <select name="gf_state" id="">
                                                        <option value="playing">Playing</option>
                                                        <option value="completed">Completed</option>
                                                        <option value="replaying">Replaying</option>
                                                    </select>
                                                </p>
                                                <input type="hidden" name="gf_game" value="<?php echo $game['id']; ?>">
                                                <input class="styled-button" type="submit" value="Add to followed Games" name="gf_submit">
											</form>
										</div>
										
										<div class="column3">
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