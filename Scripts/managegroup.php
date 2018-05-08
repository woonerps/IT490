<?php
	require_once('Controllers/groupe_controller.php');
	$groupes=getUserGroupes($_SESSION['loggedinUser']);

	if(isset($_GET['hrs']))
	{
		$houres=explode('|',$_GET['hrs']);
		$theDate=$houres[0];
		unset($houres[0]);
	}
		
	
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Groups</title>

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
								<div><h2 style="margin:10px;"><span style="margin-left:20px;">Manage your groups</span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">
									
									<div class="paragraph-row">
                                        <div class="column3">
											<p></p>
										</div>
										<div class="column6">
                                            <h3>Your Groups</h3></br>
                                            <table width="100%" style="color:white;font-size:1.2em;margin-bottom:3%;background-color:#111;border-radius:10px;">
                                                <?php
                                                    $counter=0;
                                                    if(count($groupes)>0)
                                                    {
                                                        foreach($groupes as $group)
                                                        {
                                                            if($counter%2!=0)
                                                            {
                                                                if($group['maker']==$_SESSION['loggedinUser'])
                                                                {
                                                                    echo '<tr style="background-color:#222;">
                                                                    <td style="padding:1%;" width="60%"><a href="groupe.php?id='.$group['id'].'">'.$group['name'].'</a></td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" align="center" width="20%"><a href="Controllers/groupe_controller.php?op=quite&id='.$group['id'].'">Quite group</a> </td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" width="20%" align="center"><a href="Controllers/groupe_controller.php?op=delete&id='.$group['id'].'">Delete group</a> </td>
                                                                    </tr>';
                                                                }
                                                                else
                                                                {
                                                                    echo '<tr style="background-color:#222;">
                                                                    <td style="padding:1%;" width="60%"><a href="groupe.php?id='.$group['id'].'">'.$group['name'].'</a></td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" align="center" width="20%"><a href="Controllers/groupe_controller.php?op=quite&id='.$group['id'].'">Quite group</a> </td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" width="20%" align="center"></td>
                                                                    </tr>';
                                                                }
                                                            }
                                                            else
                                                            {
                                                                if($group['maker']==$_SESSION['loggedinUser'])
                                                                {
                                                                    echo '<tr style="">
                                                                    <td style="padding:1%;" width="60%"><a href="groupe.php?id='.$group['id'].'">'.$group['name'].'</a></td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" align="center" width="20%"><a href="Controllers/groupe_controller.php?op=quite&id='.$group['id'].'">Quite group</a> </td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" width="20%" align="center"><a href="Controllers/groupe_controller.php?op=delete&id='.$group['id'].'">Delete group</a> </td>
                                                                    </tr>';
                                                                }
                                                                else
                                                                {
                                                                    echo '<tr style="">
                                                                    <td style="padding:1%;" width="60%"><a href="groupe.php?id='.$group['id'].'">'.$group['name'].'</a></td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" align="center" width="20%"><a href="Controllers/groupe_controller.php?op=quite&id='.$group['id'].'">Quite group</a> </td>
                                                                    <td style="padding:1%;background-color:rgba(0,0,0,0.1);" width="20%" align="center"></td>
                                                                    </tr>';
                                                                }
                                                            }
                                                            $counter++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<p>you are not a member of any group</p>
                                                        <p><a href="addgroup.php">Create a group</a></p>';
                                                    }
                                                    
                                                ?>
                                            </table>								
										</div>
										<div class="column3">
											<p></p>
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