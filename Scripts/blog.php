<?php
require_once('Controllers/blog_controller.php');
require_once('Controllers/game_controller.php');
   if(isset($_GET['page']))
   {
		if(filter_var($_GET['page'], FILTER_VALIDATE_INT))
			$games=getGamesByPage($_GET['page']);
		else
			$games=getGamesByPage(1);
   }
   else
   {
		header('Location:blog.php?page=1');
   }
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Game Project | Blog</title>

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
					
					<div class="main-content left">

						<div class="panel-block">
							<div class="panel-title">
								<h2>Latest News</h2>
							</div>
							<div class="panel-content">
								
								<!-- BEGIN .article-double-block -->
								<div class="article-double-block">
									<div class="left">
									<?php 
										$counter=0;
										
										foreach($games as $game)
										{
											$tb='-Not enough data-';
											$timeToBeat=getTimeToBeat($game['id']);
											if($timeToBeat!="") 
												$tb= $tb=$timeToBeat['houre'].' : '.$timeToBeat['min'].' : '.$timeToBeat['sec'];  
											$score=getGameScore($game['id']);
											if($game['cover']==null)
												$cover='images/photos/image-7.jpg';
											else
												$cover='uploads/covers/'.$game['cover'];
											if($counter==ceil(count($games)/2) && count($games)>1)
											{
												break;
											}
											echo 	
												'<div class="article-big">
													<div class="article-header">
														<a href="game.php?id='.$game['id'].'" class="img-hover-image"><img src="'.$cover.'" alt="" class="" /></a>
													</div>
													<div class="article-content">
														<h2><a href="game.php?id='.$game['id'].'">'.$game['title'].'</a><a href="post.html#comments" class="comment-link"></a></h2>
														<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.$score.'%;"></div></div>
														<span class="article-date">'.$game['releaseDate'].'</span>
														<p style="color:white;"><strong>Time to beat : '.$tb.'</strong></p></br>
														<p>'.substr ($game['description'],0,100).'</p>
													</div>
													<div class="article-footer">
														<a href="blog.html" class="left">by '.$game['developper'].'</a>
														<a href="game.php?id='.$game['id'].'" class="right">Read More<span class="icon-text">&#9656;</span></a>
														<div class="clear-float"></div>
													</div>
												</div>'; 
											$counter++;							
										}
									?>
									</div>
									<div class="right">
										<?php 
											$counter=0;
											
											foreach($games as $game)
											{
												$timeToBeat=getTimeToBeat($game['id']);
												$tb='-Not enough data-';
												if($timeToBeat!="") 
												{
													$tb=$timeToBeat['houre'].' : '.$timeToBeat['min'].' : '.$timeToBeat['sec']; 
												}
												$score=getGameScore($game['id']);
												if($game['cover']==null)
													$cover='images/photos/image-7.jpg';
												else
													$cover='uploads/covers/'.$game['cover'];
												if($counter>=count($games)/2 && count($games)>1)
												{
													echo 	
													'<div class="article-big">
														<div class="article-header">
															<a href="game.php?id='.$game['id'].'" class="img-hover-image"><img src="'.$cover.'" alt="" class="" /></a>
														</div>
														<div class="article-content">
															<h2><a href="game.php?id='.$game['id'].'">'.$game['title'].'</a><a href="post.html#comments" class="comment-link"></a></h2>
															<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style="width: '.$score.'%;"></div></div>
															<span class="article-date">'.$game['releaseDate'].'</span>
															<p style="color:white;"><strong>Time to beat : '.$tb.'</strong></p></br>
															<p>'.substr ($game['description'],0,100).'</p>
														</div>
														<div class="article-footer">
															<a href="blog.html" class="left">by '.$game['developper'].'</a>
															<a href="game.php?id='.$game['id'].'" class="right">Read More<span class="icon-text">&#9656;</span></a>
															<div class="clear-float"></div>
														</div>
													</div>'; 
												}
												
												$counter++;							
											}
										?>
									</div>
									<!-- BEGIN .left -->
									

									<div class="clear-float"></div>

								<!-- END .article-double-block -->
								</div>
								
								<div class="pagination">
									<?php 
										$nextpage;
										$previouspage;
										$pages=getPagesNumber();
										if($_GET['page']>1)
											$previouspage=$_GET['page']-1;
										else
											$previouspage='no';
										if($_GET['page']<$pages)
											$nextpage=$_GET['page']+1;
										else
											$nextpage='no';
										if($previouspage!='no')
											echo '<a class="prev page-numbers" href="blog.php?page='.$previouspage.'"><span class="icon-text">&#9666;</span>Previous Page</a>';
										else
											echo '<span class="prev page-numbers current"><span class="icon-text">&#9666;</span>Previous Page</span>';
										for($i=1; $i<=$pages; $i++)
										{
											if($_GET['page']!=$i)
												echo '<a class="page-numbers" href="blog.php?page='.$i.'">'.$i.'</a>';
											else
												echo '<span class="page-numbers current">'.$i.'</span>';
										}
										if($nextpage!='no')
											echo '<a class="next page-numbers" href="blog.php?page='.$nextpage.'">Next Page<span class="icon-text">&#9656;</span></a>';
										else
											echo '<span class="next page-numbers current" >Next Page<span class="icon-text">&#9656;</span></span>';
									?>
								</div>
							</div>
						</div>
						
					</div>

					<?php
						include('sidebar.php');
					?>

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