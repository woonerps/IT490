<?php 
	require_once('Controllers/game_controller.php');
	if(isset($_GET['operation']))
	{
		if($_GET['operation']=='disc')
		{
		    session_destroy();
			header('Location:index.php');
		}
	}
	$games=getGames();
	$recentReview=getrecentReview();
	$sliderGames=getSliderGames();
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Homepage</title>

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
				include("header.php");
			?>
			
			<!-- BEGIN .content -->
			<div class="content">
				
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<div class="main-content left">

						<div class="panel-block responsivehide">
							<div class="panel-title">
								<h2>Hottest Games</h2>
								<div class="right">
									<ul class="slider-navi" rel="slider-block-1"></ul>
								</div>
							</div>
							<div class="panel-content">
								
								<div class="slider-block" id="slider-block-1" rel="autoplay">
									<a href="#" class="slider-play pause"></a>
									<a href="#slider-left" class="slider-arrows"><span class="arrow-left">&nbsp;</span><img src="images/px.gif" class="arrow-img" alt="" /></a>
									<a href="#slider-right" class="slider-arrows"><span class="arrow-right">&nbsp;</span><img src="images/px.gif" class="arrow-img" alt="" /></a>
									<ul>
										<?php
										for($i=0;$i<6;$i++)
										{
											$tb='-Not enough data-';
											$timeToBeat=getTimeToBeat($sliderGames[$i]['id']);
											if($timeToBeat!="") 
												$tb= $tb=$timeToBeat['houre'].' : '.$timeToBeat['min'].' : '.$timeToBeat['sec']; 
											$cover='images/photos/image-1.jpg';
											if($sliderGames[$i]['cover']!="")
												$cover='uploads/covers/'.$sliderGames[$i]['cover'];
											echo '<li>
											<div class="slider-overlay">
												<h2><a href="game.php?id='.$sliderGames[$i]['id'].'">'.$sliderGames[$i]['title'].'</a><a href="post.html#comments" class="comment-link">('.count(getCommentsOfGame($sliderGames[$i]['id'])).')</a></h2>
												<div class="slider-text">
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.getGameScore($sliderGames[$i]['id']).'%;"></div></div>
													<p style="color:white;"><strong>Time to beat : '.$tb.'</strong></p></br>
													<p>'.substr($sliderGames[$i]['description'],0,150).'...</p>
												</div>
											</div>
											<div class="slider-image" style="overflow: hidden;">
												<a href="game.php?id='.$sliderGames[$i]['id'].'"><img src="'.$cover.'" alt="" /></a>
											</div>
											<div class="clear-float"></div>
										</li>';
										}
											
										?>
										

									</ul>
									
								</div>

							</div>
						</div>

						<div class="panel-block">
							<div class="panel-title">
								<h2>Latest Games</h2>
								<div class="right">
									<a href="blog.php">View more games</a>
								</div>
							</div>
							<div class="panel-content">
								
								<!-- BEGIN .article-double-block -->
								<div class="article-double-block" style="z-index:10;">
									
									<!-- BEGIN .left -->
									<?php
										$counter=-1;
										foreach($games as $game)
										{
											$tb='-Not enough data-';
											$timeToBeat=getTimeToBeat($game['id']);
											if($timeToBeat!="") 
												$tb= $tb=$timeToBeat['houre'].' : '.$timeToBeat['min'].' : '.$timeToBeat['sec']; 
											$comments=getCommentsOfGame($game['id']);
											$score=getGameScore($game['id']);
											if($game['cover']==null)
												$cover='images/photos/image-7.jpg';
											else
												$cover='uploads/covers/'.$game['cover'];

											if($counter<0)
											{
												echo '<div class="left">';
												$counter++;
											}
											if($counter<=1)
											{
												echo '
												<div class="article-big">
													<div class="article-header">
														<a href="game.php?id='.$game['id'].'" class="img-hover-image"><img src="'.$cover.'" alt="" class="" /></a>
													</div>
													<div class="article-content">
														<h2><a href="game.php?id='.$game['id'].'">'.$game['title'].'</a><a href="game.php?id='.$game['id'].'#comments" class="comment-link">('.count($comments).')</a></h2>
														<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.$score.'%;"></div></div>
														<span class="article-date">'.$game['releaseDate'].'</span>
														<p style="color:white;"><strong>Time to beat : '.$tb.'</strong></p></br>
														<p>'. substr ($game['description'],0,100).'</p>
													</div>
													<div class="article-footer">
														<a href="blog.php" class="left">by '.$game['developper'].'</a>
														<a href="game.php?id='.$game['id'].'" class="right">Read More<span class="icon-text">&#9656;</span></a>
														<div class="clear-float"></div>
													</div>
												<!-- END .article-big -->
												</div>';
												$counter++;
											}else
											{
												if($counter<=6 )
												{
													echo '
													<div class="article-medium">
														<div class="article-header">
															<a href="game.php?id='.$game['id'].'" class="img-hover-image"><img src="'.$cover.'" alt="" class="" /></a>
														</div>
														<div class="article-content">
															<h2><a href="game.php?id='.$game['id'].'">'.$game['title'].'</a><a href="game.php?id='.$game['id'].'#comments" class="comment-link">('.count($comments).')</a></h2>
															<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.$score.'%;"></div></div>
															
															<span class="article-date">'.$game['releaseDate'].'</span>
															<p style="color:white;"><strong>Time to beat : '.$tb.'</strong></p></br>
															<p>'.substr ($game['description'],0,100).'</p>
														</div>
														<div class="article-footer">
															<a href="blog.php" class="left">by '.$game['developper'].'</a>
															<a href="game.php?id='.$game['id'].'" class="right">Read More<span class="icon-text">&#9656;</span></a>
															<div class="clear-float"></div>
														</div>
													</div>
													';
													$counter++;
												}
											}
											if($counter==2)
											{
												echo '</div>';
												echo '<div class="right">';
											}
											
											if($counter>6)
											{
												echo '</div>';
												break;
											}
												
										}

									?>
									<div class="clear-float"></div>

								<!-- END .article-double-block -->
								</div>

							</div>
						</div>
						
						<!-- BEGIN .panel-block -->
						<div class="panel-block">

							<div class="panel-title">
								<h2>Latest Reviews</h2>
							</div>

							<div class="panel-content">
								<div class="review-block">
									

									<?php
										foreach($recentReview as $review)
										{
											echo
											'<div class="review-item">
												<div class="review-image">
													<a href="game.php?id='.$review['gameid'].'" class="img-hover-image"><img src="images/photos/image-9.jpg" alt="" /></a>
													<a href="#" class="review-category">GAMES</a>
												</div>
												<div class="review-content">
													<h2><a href="game.php?id='.$review['gameid'].'">'.$review['title'].'</a><a href="post.html#comments" class="comment-link"></a></h2>
													<span>'.$review['review'].'</span>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.$review['grade'].'%;"></div></div>
												</div>
												<div class="clear-float"></div>
											</div>';
										}
									?>
								</div>
							</div>

						<!-- END .panel-block -->
						</div>
						
						
					</div>
				
					<?php 
						include('sidebar.php');
					?>
					</div>
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