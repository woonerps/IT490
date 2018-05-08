<?php
	require_once('Controllers/game_controller.php');
	$recentComments=getRecentComments();
?>
<div class="sidebar-content right">

						<!-- BEGIN .panel-block -->
						<div class="panel-block">
							<div class="panel-title">
								<h2>Recent Comments</h2>
							</div>
						</div>
						<div class="split-panel">
							
							<div class="left">
								<div class="panel-block">
									<div class="panel-content">
										<?php 
											$counter=0;
											foreach($recentComments as $comment)
											{
												$tempuser=getUserInfoById($comment['userid'])[0];
												$avatar='images/no-avatar-60x60.jpg';
												if($tempuser['avatar']!='')
													$avatar='uploads/avatars/'.$tempuser['avatar'];	
												if($counter<3)
												{
													echo 
													'<div class="comment-item">
														<div class="comment-header">
															<a href="game.php?id='.$comment['gameid'].'" class="comment-avatar"><img src="'.$avatar.'" alt="" width="40px" /></a>
															<div class="comment-info">
																<h3><a href="game.php?id='.$comment['gameid'].'">'.$tempuser['username'].'</a></h3>
																<div class="date">'.$comment['addDate'].'</div>
															</div>
														</div>
														<div class="comment-content">
															<p>'.substr($comment['message'],0,100).'</p>
														</div>
														<div class="comment-footer">
															<a href="game.php?id='.$comment['gameid'].'">Game page</a>
														</div>
													</div>';
												}
												$counter++;
											}
										?>
									</div>
								</div>
								

							</div>

							<div class="right">
								
								<!-- BEGIN .panel-block -->
								<div class="panel-block">
									
									<div class="panel-content">
										<?php 
										$counter2=0;
											foreach($recentComments as $comment)
											{
												$tempuser=getUserInfoById($comment['userid'])[0];
												$avatar='images/no-avatar-60x60.jpg';
												if($tempuser['avatar']!='')
													$avatar='uploads/avatars/'.$tempuser['avatar'];	
												if($counter2>=3)
												{
													echo 
													'<div class="comment-item">
														<div class="comment-header">
															<a href="game.php?id='.$comment['gameid'].'" class="comment-avatar"><img src="'.$avatar.'" alt="" width="40px" /></a>
															<div class="comment-info">
																<h3><a href="game.php?id='.$comment['gameid'].'">'.$tempuser['username'].'</a></h3>
																<div class="date">'.$comment['addDate'].'</div>
															</div>
														</div>
														<div class="comment-content">
															<p>'.substr($comment['message'],0,100).'</p>
														</div>
														<div class="comment-footer">
															<a href="game.php?id='.$comment['gameid'].'">Game page</a>
														</div>
													</div>';
												}
												$counter2++;
											}
										?>
									</div>
								</div>
							</div>

							<div class="clear-float"></div>

						</div>

						<!-- BEGIN .panel-block -->
						

						<!-- BEGIN .panel-block -->

					</div>