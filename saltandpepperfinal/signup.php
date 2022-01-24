<?php 

	include("classes/connect.php");
	include("classes/signup.php");

	$first_name = "";
	$last_name = "";
	$gender = "";
	$email = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$signup = new Signup();
		$result = $signup->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			header("Location: login.php");
			die;
		}
 

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];

	}


	

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="signup.css">
    <title>Salt&Pepper|SignUp</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap');

*{
    padding:0;
    margin:0;
    overflow: hidden;
    font-family: 'Rajdhani', sans-serif;
}

body{
    background-color:whitesmoke;
}

.wholebody{
    display: flex;
    width:100%;
    height: 100vh;
    
}

.bodyone{
    border:1px solid black;
    width:80%;
    display:flex;
    justify-content: center;
    align-items: center;
}

.bodyone .text{
    font-family: 'Rajdhani', sans-serif;
}

.bodyone .text h1{
    font-size:130px;
    
}

.bodyone .text h2{
    font-size:50px;
    margin-top:-30px;
    margin-left:6px;
}

.bodyone .text p{
    font-size:25px;
    margin-left:6px;
    font-weight:lighter;
}

.bodytwo{
    width:20%;
    background-color:#28282B;
    display: flex;
    flex-flow:column;
    justify-content: center;
    align-items: center;
}

.signupformbox{
    height:100%;
    width:100%;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}

.signupformbox h1{
    color:whitesmoke;
    text-align: center;
    margin-bottom:10px;
}

.signupformbox input{
    height:25px;
    width:250px;
    font-weight:700;
}

form{
    display: flex;
    flex-flow: column;
    align-items: center;
    width:100%;
}


</style>

<body>
<div class="wholebody">


<div class="bodyone">

     <div class="text">
        <h1>Salt & Pepper</h1>
        <h2>Food Social Media</h2>
        <p> Share your recipe . Discover something new</p>
    </div>
    
</div>

<div class="bodytwo">

<div class="signupformbox">

        <form method="post" action="">    
		
			<h1>SIGNUP</h1>
			<input value="<?php echo $first_name?>" name="first_name" type ="text" id="text" placeholder="First Name"><br>
			<input value="<?php echo $last_name?>" name="last_name" type ="text" id="text" placeholder="Last Name"><br>
			<span style="color:whitesmoke; font-weight:500;">Gender:</span>
			<select name="gender" id="text">
				<option><?php echo $gender?></option>
				<option>Male</option>
				<option>Female</option>
			</select><br>
			<input value="<?php echo $email?>" name="email" type ="text" id="text" placeholder="Email Address"><br>
			<input name="password"type ="password" id="text" placeholder="Password"><br>
			<input name="password1" type ="password" id="text" placeholder="Confirm Password"><br>
			<center><input style="width:50px" type="submit" id="button" value="Sign Up"><center>
        
		</form>

</div>

</div>

         
    
</body>

</html>