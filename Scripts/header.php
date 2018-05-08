<div class="header">

				<div class="very-top">
					<!-- BEGIN .wrapper -->
					<div class="wrapper">

						<ul class="left responsivemenu" rel="Top Menu">
							<li><a href="index.php">Homepage</a></li>
							<li><a href="contact.php">Contact Us</a></li>
							
						</ul>

						<ul class="right">
							<?php
								if(!isset($_SESSION['loggedinUser']))
								{
									echo '<li><a href="register.php">Login</a></li>
										<li><a href="register.php">Register</a></li>';
								}
								else
								{
									echo '
									<li><a href="addgame.php">Add Game</a></li>
									<li><a href="profile.php?id='.$_SESSION['loggedinUser'].'">'.$_SESSION['loggedinUsername'].'</a></li>
									<li><a href="index.php?operation=disc">Disconnect</a></li>';
									include('notifications.php');
								}
							?>
							
						</ul>

						<div class="clear-float"></div>

					<!-- END .wrapper -->
					</div>
				</div>
				
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<div class="logo-image">
						<a href="index.php"><img src="images/logows.png" height="55" alt="" /></a>
					</div>
					
					<!-- <div class="logo-text">
						<a href="index.php">Forca</a>
					</div> -->

					<div class="clear-float"></div>


					<div class="main-menu">
						
						<div class="header-search">
							
						</div>
						
						<ul class="responsivemenu" rel="Main Menu">
							<li><a href="index.php">Home Page<i>,</i></a></li>							
							<li><a href="blog.php">Games Page<i>,</i></a></li>
						</ul>
						
					</div>

					
				<!-- END .wrapper -->
				</div>
				
			<!-- END .header -->
			</div>