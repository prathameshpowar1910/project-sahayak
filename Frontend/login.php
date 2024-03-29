<?php
// Replace with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dpp";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn -> connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['epid']) && isset($_POST['pwd'])) 
{

    $epid = $_POST['epid'];
    $pwd = $_POST['pwd'];

    // Validate the user's credentials against the database
    $sql = "SELECT * FROM login WHERE emp_id = '$epid' AND password = '$pwd'";
    $result = $conn->query($sql);

    $pattern_client = "/cl+/";
    $pattern_admin = "/ad+/";

    if ($result->num_rows > 0 && preg_match($pattern_client , $pwd)) 
    {
        // User is authenticated
        // echo "Login successful";
        header("Location: Chatbot.html ");
        // You can redirect the user to the chatbot app here
    } 

    else if($result->num_rows > 0 && preg_match($pattern_admin , $pwd))
    {
        header("Location: Admin.html ");
    }
    
    else {
        echo '<script>alert("Invalid Login Id or Password")</script>';
    }
}

    $conn->close();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahayak</title>
    <link rel="stylesheet" href="./Login.css">
</head>
    

<style>

    @import url('https://fonts.googleapis.com/css2?family=Overpass:wght@800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Overpass:wght@600;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Overpass:wght@600;800&family=Radio+Canada&display=swap');

    button{
        transition: .3s;
    }

    button:hover
    {
        scale: 1.05;
        cursor: pointer;
    }

    .lgin
    {
        position: absolute;
        left: 38px;
    }

    *
    {
        margin: 0;
        padding: 0;
    }


    .sbmt:hover
    {
        cursor: pointer;
        scale: 1.05;
    }


</style>

<body>
    <div style="width:100%; height: 100vh; position: relative; background: #24252D; overflow: hidden;">
    
        <!-- Right Side Login Page  -->
    
        <section style="scale: 1.1; position: relative; top: -30px; left: -40px;">

        <div style="position: relative; top: -150px; left: 40px;">
        
        <img style="width: 47px; height: 48px; left: 1098px; top: 298px; position: absolute" src="./Assets/lotus-flower 1.png" />
        <div style="left: 997px; top: 408px; position: absolute; color: white; font-size: 34px; font-family: Overpass; font-weight: 600; letter-spacing: 2.04px; word-wrap: break-word; font-family: 'Overpass', sans-serif;">Welcome back!</div>
        <div style="width: 284px; height: 33px; left: 983px; top: 512px; position: absolute; background: #595959; border-radius: 11px"></div>
        <div style="width: 284px; height: 33px; left: 983px; top: 556px; position: absolute; background: #595959; border-radius: 9px"></div>
        <img style="width: 24px; height: 24px; left: 988px; top: 516px; position: absolute; transform: rotate(0deg); transform-origin: 0 0" src="./Assets/profile 1.png" />
        <img style="width: 24px; height: 22px; left: 988px; top: 561px; position: absolute" src="./Assets/padlock 1.png" />
        
        <div style="left: 1020px; top: 451px; position: absolute; color: rgba(255, 255, 255, 0.70);  font-size: 13px; font-family: Radio Canada; font-weight: 500; letter-spacing: 0.78px; word-wrap: break-word">Start your session by signing in.</div>
        
        <!-- Login Form  -->

        <form method="post">

        <input name="epid" style="left: 1022px; top: 518px; position: absolute; color: rgba(255, 255, 255, 0.70); background-color: #595959; border: none; outline: none; font-size: 17px; font-family: Radio Canada; font-weight: 500; letter-spacing: 0.84px; word-wrap: break-word" placeholder="Enter user id">
        <input name="pwd" type="password" style="left: 1022px; top: 561px; position: absolute; color: rgba(255, 255, 255, 0.70); background-color: #595959; border: none; outline: none;  font-size: 17px; font-family: Radio Canada; font-weight: 500; letter-spacing: 0.84px; word-wrap: break-word" placeholder="********">

        <div class="lgin">

            <button id="sbmt" class="sbmt" name="save" type="submit" value="Login" style="left: 1024px; top: 630px; height: 40px; width: 125px; position: absolute; color: rgba(255, 255, 255, 0.70); background-color: #595959; border: none; border-radius: 20px; outline: none; font-size: 20px; font-family: Radio Canada; font-weight: 500; letter-spacing: 0.84px; word-wrap: break-word; padding-right: 30px; font-family: 'Overpass', sans-serif;">Login</button>
            
            <img style="width: 19px; height: 19px; left: 1118px; top: 639px; position: absolute" src="./Assets/image (2) 1.png" />

        </div>

        </form>
        
        </div>

        </section>
    
        <!-- Info Image  -->
        <img style="width: 16px; height: 16px; left: 1479px; top: 68px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0" src="./Assets/more 1.png" />
    
        <!-- Left Side Image  -->
    
        

        <div style="width: 762px; height: 100vh; left: 0px; top: 0px; position: absolute; background: #537CE6; border-radius: 00px"></div>
        <section style="scale: 0.8; position: relative; top: 70px; left: -90px;">
        <img style="width: 73px; height: 73px; left: 195px; top: 75px; position: absolute" src="./Assets/lotus-flower 1.png" />
        <div style="left: 294px; top: 80px; position: absolute; color: white; font-size: 53px; font-family: Overpass; font-weight: 800; letter-spacing: 3.18px; word-wrap: break-word; font-family: 'Overpass', sans-serif;" >Sahayak</div>
        <div style="position: absolute; top: -200px;">
        <div style="width: 547px; left: 131px; top: 710px; position: absolute; color: white; font-size: 49px; font-family: Overpass; font-weight: 800; letter-spacing: 2.94px; word-wrap: break-word"> Chat, Solve, Achieve</div>
        <div style="width: 537px; left: 115px; top: 790px; position: absolute; opacity: 0.70; text-align: center; color: white; font-size: 17px; font-family: 'Radio Canada', sans-serif; font-weight: 400; line-height: 24.48px; letter-spacing: 1.02px; word-wrap: break-word">"Experience effortless substation maintenance through our AI-powered chat-bot,  a knowledgeable companion offering expert advice and solutions at your fingertips."</div>
        </div>
        <img style="width: 500px; height: 300px; left: 120px; top: 194px; position: absolute" src="./Assets/7883-removebg-preview 1.png" />

        </section>

    </div>

</body>

</html>