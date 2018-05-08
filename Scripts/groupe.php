<?php
	require_once('Controllers/groupe_controller.php');
	
	if(isset($_GET['id']))
		$groupe=getGroupeById($_GET['id']);
	else
		header('Location:profile.php');
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
		<title>Game Project | Schedule</title>

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
								<div><h2 style="margin:10px;"><span style="margin-left:20px;">Group schedule sync</span></h2></div>
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="the-article-content">
									
									<div class="paragraph-row">
										<div class="column8">
											<h3><?php echo $groupe['name'];?></h3>
											<h3 id="titleToChange"> <?php if(isset($_GET['hrs'])) echo 'Playing hours for '.$theDate; ?></h3>
											<p>Select the hours that you are available to play at by clicking on them</p>
											<div style="margin-bottom:20px;">
												<table id='planningTable' width="100%" height="80px" <?php if(!isset($_GET['hrs']))echo 'style="color:grey;font-size:1.2em;margin-bottom:3%;background-color:#111;border-radius:10px;"';else echo 'style="color:darkgrey;font-size:1.2em;margin-bottom:3%;background-color:#111;border-radius:10px;"'?>>
													<tr style="border-bottom:3px double grey;">
													<?php 
														for($i=0;$i<24;$i++)
														{
															echo '<th style="">'.$i.'h</th>';
														}
													?>
													</tr>
													<tr id="houresRow" height="60%">
													<?php 
														if(isset($_GET['hrs']))
														{
															for($i=0;$i<24;$i++)
															{
																$found=false;
																if($i==23)
																{
																	foreach($houres as $houre)
																	{
																		if($houre == $i)
																		{
																			echo '<td style="background-color:seagreen;" width="4.16%" onclick="tdClicked(event,this)"></td>';
																			$found=true;
																			break;
																		}
																	}
																	if(!$found)
																	{
																		echo '<td style="" width="4.16%" onclick="tdClicked(event,this)"></td>';
																	}
																}
																else
																{
																	foreach($houres as $houre)
																	{
																		if($houre == $i)
																		{
																			echo '<td style="border-right:1px double grey;background-color:seagreen;" width="4.16%" onclick="tdClicked(event,this)"></td>';
																			$found=true;
																			break;
																		}
																	}
																	if(!$found)
																	{
																		echo '<td style="border-right:1px double grey;" width="4.16%" onclick="tdClicked(event,this)"></td>';
																	}
																}
																
															}
														}
														else
														{
															for($i=0;$i<24;$i++)
															{
																echo '<td style="border-right:1px double grey;" width="4.16%" onclick="tdClicked(event,this)"></td>';
															}
														}
													?>
													</tr>
												</table>
											</div>
											<button onclick="checkHoures()" class="styled-button">Save</button>
											
										</div>
										<div class="column4">
											<h3>Date</h3>
											<form id="groupeForm" action="Controllers/groupe_controller.php" method="post" enctype="multipart/form-data">								
												<p class="contact-form-email">
													
													<input id="plannedDay" type="date" name="g_day" oninput="resetHoures()" <?php if(isset($_GET['hrs'])) echo'value="'.$theDate.'"'; ?> required/>
												</p>
												<input type="hidden" id="g_houres" name="g_houres">
												<input type="hidden" value="<?php echo $_GET['id']; ?>" name="g_groupe">
												<input class="styled-button" type="submit" value="Show" name="show_submit">
											</form>
										</div>
									</div>
									<div class="spacers spacer-style-1"></div>
									<div class="paragraph-row">
										<div class="column12">
											<div style="overflow-x:auto;"></div>
												<?php
													if(isset($_SESSION['groupUserPlanning']))
													{
														if(count($_SESSION['groupUserPlanning'])>0)
														{
															echo '<h3>All group users Schedule</h3>';
															$usersPlanning=$_SESSION['groupUserPlanning'];
															echo '<table width="100%" style="color:grey;font-size:1.2em;margin-bottom:3%;border-radius:10px;background-color:#111;">';
															echo '<tr style="border-bottom:3px double grey">';
																for($i=0;$i<25;$i++)
																{
																	$var=$i-1;
																	if($i==0)
																		echo '<th width="4%" style="background:none;"></th>';
																	else
																		echo '<th width="4%" style=";">'.$var.'h</th>';
																}
															echo '</tr>';
															$usersAr=array();
															foreach($usersPlanning as $row)
															{
																if(!in_array($row[0],$usersAr))
																	array_push($usersAr,$row[0]);
															}
															$cnt=0;
															foreach($usersAr as $user)
															{
																$foundcolor=array('r'=>rand(0,255),'g'=>rand(0,255),'b'=>rand(0,255));
																if($cnt%2==0)
																	echo '<tr height="40px" >';
																else
																	echo '<tr height="40px" style="">';
																
																for($i=0;$i<25;$i++)
																{
																	

																	if($i==0)
																	{
																		echo '<td style="vertical-align:middle;border-right:1px double grey;" width="4%" align="center" >'.$user.'</td>';
																	}
																	if($i==23)
																	{
																		
																		$found=false;
																		foreach($usersPlanning as $row)
																		{
																			if($row[0]==$user && $row['houre']==$i)
																			{
																				echo '<td style="background-color:rgb('.$foundcolor['r'].','.$foundcolor['g'].','.$foundcolor['b'].');" width="4%" ></td>';
																						$found=true;
																						break;
																			}
																		}
																		if(!$found)
																		{
																			echo '<td style="" width="4%"></td>';
																		}
																	}
																	else
																	{
																		$found=false;
																		foreach($usersPlanning as $row)
																		{
																			if($row[0]==$user && $row['houre']==$i)
																			{
																				echo '<td style="border-right:1px double grey;background-color:rgb('.$foundcolor['r'].','.$foundcolor['g'].','.$foundcolor['b'].');" width="4%" ></td>';
																						$found=true;
																						break;
																			}
																		}
																		if(!$found)
																		{
																			echo '<td style="border-right:1px double grey;" width="4%"></td>';
																		}
																	}
																}
																echo '</tr>';
																$cnt++;
															}
															echo '</table>';
														}
													}
												?>	
											</div>
										</div>
									</div>
									<div class="contact-form commentform" style="margin-top:20px;">
										
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
			var selectedHours="";
			var dateIsSet=false;
			var connectedUser=<?php echo $_SESSION['loggedinUser']; ?>;
			<?php  unset($_SESSION['groupUserPlanning']); ?>
			var tempHours="";	
			
			function resetHoures()
			{
				dateIsSet=true;
				//document.getElementById('planningTable').style.backgroundColor  = "#ccc";
				var houresRow=document.getElementById('houresRow');
				document.getElementById('titleToChange').innerHTML="Playing hours for "+document.getElementById('plannedDay').value;
				
				for(var i=0;i<houresRow.cells.length;i++)
				{
					//houresRow.cells[i].style.backgroundColor="#ccc";
				}
			}

			function checkHoures()
			{
				if(document.getElementById('plannedDay').value!=null)
				{
					dateIsSet=true;
				}
				if(dateIsSet)
				{
					var gForm=document.getElementById('groupeForm');
					selectedHours="";
					selectedHours=selectedHours+document.getElementById('plannedDay').value+"|";
					var houresRow=document.getElementById('houresRow');
					var temp="";
					for(var i=0;i<houresRow.cells.length;i++)
					{
						if(houresRow.cells[i].style.backgroundColor=="seagreen")
						{
							selectedHours=selectedHours+i+"|";
						}
					}
					document.getElementById('g_houres').value=selectedHours;
					if(document.getElementById('g_houres').value!="")
					{
						gForm.submit();
					}
				}
				else
				{
					alert('Please set the date');
				}
			}
			function tdClicked(e,item)
			{ 
				if(document.getElementById('plannedDay').value!=null)
				{
					dateIsSet=true;
				}
				if(dateIsSet)
				{
					if (!e) var e = window.event;            
					e.cancelBubble = true;                 
					if (e.stopPropagation) e.stopPropagation();
					if(item.style.backgroundColor!="seagreen")
					{
						item.style.backgroundColor  = "seagreen";
					}
					else
					{
						item.style.backgroundColor  = "";
					}
				}
				else
				{
					alert('Please set the date');
				}
			};  
		</script>
    


    <!-- END body -->
	</body>
<!-- END html -->
</html>