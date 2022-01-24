<!--top bar-->
<?php 

	$corner_image = "images/user_male.jpg";
	if(isset($USER)){
		
		if(file_exists($USER['profile_image']))
		{
			$image_class = new Image();
			$corner_image = $image_class->get_thumb_profile($USER['profile_image']);
		}else{

			if($USER['gender'] == "Female"){

				$corner_image = "images/user_female.jpg";
			}
		}
	}
?>
<style>@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap');</style>
<div id="blue_bar">
	<form method="get" action="search.php">
		<div style="width: 845px;margin:auto;font-size: 30px;">
			
			<a href="index.php" style="margin-left:30px; font-size:25px; font-weight: bold; color: black; text-decoration: none;  font-family: 'Rajdhani', sans-serif;">Salt&Pepper</a>
			&nbsp; &nbsp; <input type="text" id="search_box" name="find" placeholder=" &nbsp;Search" />

			<?php if(isset($USER)): ?>

				<div class="dropdown">
					<a href="profile.php" class="dropbtn">
						<img src="<?php echo $corner_image ?>" style="width: 30px;float: right; border: 1px solid black; border-radius: 50px; margin-top: 5px;"/>
					</a>
  						<div class="dropdown-content">
 							<a href="profile.php"><i class="far fa-user-circle"></i>&nbsp; Profile</a>
  							<a href="profile.php?section=settings&id="><i class="fas fa-sliders-h"></i>&nbsp; Settings</a>
							<a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a>
  						</div>
				</div>

				<a href="logout.php">
				<span style="font-size:11px;float: right;margin:10px;color:black;"></span>
				</a>

				<span>
					<a href="index.php" style=" text-decoration: none;">
						<i class="fas fa-home" style="font-size: 20px; color: black; margin-top: 12px; margin-left: 20px;"></i>
					</a>
				</span>

				<a href="notifications.php" style=" text-decoration: none;">
				<span style="display: inline-block;position: relative;">
				<i class="fas fa-bell" style="font-size: 20px; color: black; margin-left: 10px;"></i>
					<?php 
						$notif = check_notifications();
					?>
					<?php if($notif > 0): ?>
						<div style="background-color: red;color: white;position: absolute;right:-7px; top: 7px;
						width: 8px;height: 8px;border-radius: 50%;padding: 4px;text-align:center;font-size: 8px;"><?= $notif ?></div>
					<?php endif; ?>
				</span>
				</a>

				<span>
					<a href="profile.php?section=followers&id=<?php echo $user_data['userid'] ?>"style=" text-decoration: none;">
						<i class="fas fa-heart" style="font-size: 20px; color: black; margin-top: 12px; margin-left: 10px;"></i>
					</a>
				</span>

			<?php else: ?>
				<a href="login.php">
				<span style="font-size:13px;float: right;margin:10px;color:white;">Login</span>
			<?php endif; ?>
				</a>


		</div>
	</form>
	<hr class="rounded">
</div>