<?php 

session_start();

	include("classes/connect.php");
	include("classes/login.php");
 
	$email = "";
	$password = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$login = new Login();
		$result = $login->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			header("Location: profile.php");
			die;
		}
 

		$email = $_POST['email'];
		$password = $_POST['password'];
		

	}


	

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="sap/css/login.css">
    <title>Salt&Pepper|Login</title>
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

/**/
.bodytwo{
    width:20%;
    background-color:#28282B;
    display: flex;
    flex-flow:column;
    justify-content: center;
    align-items:center;
}

.loginformbox{
    width:300px;
    height:170px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loginformbox h1{
    text-align: center;
    color: whitesmoke;
    margin-bottom:5px;
}

.loginformbox input{
    margin-bottom: 10px;;
    height: 25px;
    width:200px;
    font-weight: bolder;
}

.bodytwo a{
    text-decoration: none;
    color:whitesmoke;
    font-weight:700 ;
    font-size:10px;
}

.bodytwo .signup_button{
    border:1px solid whitesmoke;
    height:30px;
    width:100px;
}

a .signup_button{
    display: flex;
    justify-content: center;
    align-items: center;
    transition: ease-out 0.3s;
}

a .signup_button:hover{
    box-shadow: inset 300px 0 0 0 whitesmoke;
    color:black;
    background-color: whitesmoke;
    border:1px solid black;
}
</style>

    <div class="wholebody">

<div class="bodyone">

     <div class="text">
        <h1>Salt & Pepper</h1>
        <h2>Food Social Media</h2>
        <p> Share your recipe . Discover something new</p>
    </div>
    
</div>

<div class="bodytwo">

<div class="loginformbox">
        <form method="post">
        <h1>Log in</h1>
        <input value="<?php echo $email?>" name="email"  type="text" id="text" placeholder="Email"><br>
		<input value="<?php echo $password?>" name="password"  type="password" id="text" placeholder="Password"><br>
        <center><input type="submit" id="button" value="Log in" style="width:50px"><center>
        </form>
</div>
<a href="signup.php"><div class="signup_button">Create New Account</div></a>

</div>

</body>

</html>