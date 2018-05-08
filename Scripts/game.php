<?php 
	if(isset($_GET['id']))
	{
		require_once('Controllers/game_controller.php');
		$game=getGameById($_GET['id']);
		$comments=getCommentsOfGame($_GET['id']);
		$gametags=explode(',',$game['tags']);
		$gameReview=getGameReview($_GET['id']);
		if($gameReview!="no reviews")
		{
			if($gameReview['avg']/100*5<1)
			$gameIs='Terrible';
			else if($gameReview['avg']/100*5<2)
				$gameIs='Bad';
			else if($gameReview['avg']/100*5<3)
				$gameIs='Mediocre';
			else if($gameReview['avg']/100*5<4)
				$gameIs='Good';
			else if($gameReview['avg']/100*5<5)
				$gameIs='Very good';
			else if($gameReview['avg']/100*5==5)
				$gameIs='Master piece';
		}
		
	}
	else
		header('Location:blog.php');
?>
<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
	<!-- BEGIN head -->
	<head>
		<title>Forca | Game</title>

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
								<div class="right">
									<a href="index.php">Back to homepage</a>
								</div>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
							
								<div class="article-header">
									<div class="the-article-title">
										<?php 
										if(isset($_SESSION['loggedinUser']))
										{
											if($game['author']==$_SESSION['loggedinUser'])
											{
												echo'<div class="article-icons right">
													<a href="Controllers/game_controller.php?op=deleteGame&id='.$game['id'].'" class="title-icon"><span class="icon-text"></span>Delete Game</a>
												</div>';
											}
										}
											
										?>
										
									</div>
									<img src=<?php echo ($game['cover']==null)? "images/photos/image-53.jpg":'"uploads/covers/'.$game['cover'].'"'; ?> alt="" width="100%"/>
									<div class="the-article-title">
										<h2><?php echo $game['title'];?></h2>
										<div class="article-icons">
											<p class="title-icon"><span class="icon-text">&#128100;</span>Developped by : <?php echo $game['developper'];?></p>
											<p class="title-icon"><span class="icon-text">&#59160;</span><?php echo count($comments);?> Comments</p>
											<p class="title-icon"><span class="icon-text">&#128197;</span><?php echo $game['releaseDate'];?></p>
										</div>
									</div>
								</div>
								<div class="the-article-content">
									
                                    <p><?php echo $game['description'];?></p>
                                    
								</div>
								
								<!-- BEGIN .article-review-block -->
								<div class="article-review-block">
									<div class="review-title">
									<h3 class="right"><a href=<?php echo '"review.php?id='.$game['id'].'"';?>>Send your review</a></h3>
										<b><?php echo $game['title']; ?> - overview</b>
										
									</div>
									<?php
										if($gameReview!="no reviews")
										{
											?>
												<div class="review-content">
													<b>Graphics</b>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['graphics'].'%;"' ?>></div></div>
												</div>
												<div class="review-content">
													<b>Gameplay</b>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['gameplay'].'%;"' ?>></div></div>
												</div>
												<div class="review-content">
													<b>Sound</b>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['sounds'].'%;"' ?>></div></div>
												</div>
												<div class="review-content">
													<b>Storyline</b>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['storyline'].'%;"' ?>></div></div>
												</div>
												<div class="review-content">
													<b>Presentation</b>
													<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['presentation'].'%;"' ?>></div></div>
												</div>
												<div class="review-foot">
													<div class="review-sum">
														<p><b> </b> </p>
													</div>

													<div class="review-total">
														<b><?php echo number_format((float)$gameReview['avg']/100*5, 2, '.', '');?></b>
														<span><?php echo $gameIs; ?></span>
														<div class="stars-block"><div class="star-overlay"></div><div class="star-inline" style=<?php echo '"width:'.$gameReview['avg'].'%;"' ?>></div></div>
													</div>
											<?php
										}
										else
										{
											echo '<div class="review-content">
											<b>There are no reviews of this game yet</b>
											<h3 class="right"><a href="review.php?id='.$game['id'].'";>Send the first review</a></h3>
										</div>
										<div class="review-foot">
											<div class="review-sum">
												<p><b> </b> </p>
											</div>

											<div class="review-total">
												<b>-</b>
												<span>No reviews</span>
											</div>';
										}
									?>
									

										<div class="clear-float"></div>
									</div>
								<!-- END .article-review-block -->
								</div>

								<!-- BEGIN .article-share -->
								<div class="article-tags">
									<div class="assigned-title">
										<b><span class="icon-text">&#59148;</span>Assigned tags:</b>
									</div>
									<div class="assigned-content tag-cloud">
									<?php 
										foreach($gametags as $tag)
										{
											echo '<a href="#">'.$tag.'</a>';
										}
									?>
									</div>
									<div class="clear-float"></div>
								<!-- END .article-share -->
								</div>

							<!-- END .panel-content -->
							</div>
						</div>
						

						<div class="panel-block">
							<div class="panel-title">
								<h2><?php echo count($comments);?> Comments</h2>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
								
								<ol id="comments">
									<?php 
										foreach($comments as $comment)
										{
											$tempuser=getUserInfoById($comment['userid'])[0];
											$avatar='images/no-avatar-60x60.jpg';
											if($tempuser['avatar']!='')
												$avatar='uploads/avatars/'.$tempuser['avatar'];
											echo '<li>
													<div class="commment-content">
														<div class="user-avatar">
															<img src="'.$avatar.'" width="60px" />
														</div>
														<div class="user-content">
															<span class="time-stamp">'.$comment['addDate'].'</span>
															<strong class="user-nick"><a href=userprofile.php?id='.$tempuser['id'].'>'.$tempuser['username'].'</a></strong>
															<div class="comment-text">
																<p>'.$comment['message'].'</p>
															</div>
														</div>
														<div class="clear-float"></div>
													</div>
												</li>';
										}
									?>
									
								</ol>

							<!-- END .panel-content -->
							</div>
						</div>

						<div class="panel-block">
							<div class="panel-title">
								<h2>Leave a comment</h2>
							</div>
							<!-- BEGIN .panel-content -->
							<div class="panel-content">
								<div class="writecomment">
									<div class="contact-form commentform">
									<?php 
										if(isset($_SESSION['loggedinUser']))
										{
									?>
										<form action="Controllers/game_controller.php" method="POST">
											<?php 
												if(isset($_GET['suc']))
												{
													echo ' <div class="info-message success">
														<span class="icon-text">&#10003;</span>
														<b>Great Success !</b>
														<p>Your comment has beeen added</p>
														<div class="clear-float"></div>
													</div>' ;
												}
												if(isset($_GET['error']))
												{
													if($_GET['error']=='comment')
													{
														echo '<div class="info-message error">
															<span class="icon-text">&#9888;</span>
															<b>An Error Occurred</b>
															<p>Your comment is empty</br></p>
															<div class="clear-float"></div>
														</div>';
													}
												}
											?>
											<p class="contact-form-message">
												<textarea name="c_message" placeholder="Your message.." id="c_message"></textarea>
											</p>
											<input type="hidden" name="c_game" value=<?php echo '"'.$game['id'].'"'; ?>>
											<p><input name="c_submit" type="submit" class="styled-button" value="Send"></p>
										</form>
									
									<?php
										}
										else
										{
											echo '<h3><a href="register.php">Please login to be able leave a comment</a></h3>';
										}
									?>
									</div>
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