<?php
error_reporting(0);

require '../keyauth.php';
require '../credentials.php';

session_start();



if (!isset($_SESSION['user_data'])) // if user not logged in
{
    header("Location: ../");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

function findSubscription($name, $list)
{
    for ($i = 0; $i < count($list); $i++) {
        if ($list[$i]->subscription == $name) {
            return true;
        }
    }
    return false;
}

$username = $_SESSION["user_data"]["username"];
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;
$timeleft = $_SESSION["user_data"]["subscriptions"][0]->timeleft;

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../");
    exit();
}
?>

<html lang="en">

<head>
    <title>Dashboard</title>
    <script src="https://cdn.keyauth.win/dashboard/unixtolocal.js"></script>
    <link rel="icon" type="image/svg+xml" href="../logo.svg">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap');
        *{
            font-family: 'DM Sans', sans-serif;
            margin:0;
            border-radius: 0.2rem;
            
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 85%;
            }

        .blue-rectangle {
            width: 600px;
            height: 285px;
            background-color: rgb(17, 17, 17);
            color:white;
        }

        .upperrectangle{
            width: 100% - 10px;
            height: 25px;
            background-color: rgb(21, 21, 21);
            z-index: 3;
            padding-top:5px;
            padding-left:10px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

     

        .topnav {
            background-color: rgb(21, 21, 21);
            overflow: hidden;
            margin:0;
            width: 100%;
            height: 60px;
            border-radius: 0;
        }

        .buttonwrapper{
            display:flex;
            justify-content: flex-end;
            margin-right: 20px;
            margin-top:15px;
        }

        .logoutbutton{
            background-color: transparent;
            border:0;
            color:white;
            font-size: 18px;

            transition: 0.23s ease-in-out;
        }
        
        .logoutbutton:hover{
            color: rgb(145, 145, 145);
            transition: 0.23s ease-in-out;
        }

        .buttonswrapper{
            margin-top:40px;
        }

        .dbuttonwrapper{
            display:flex;
            justify-content: center; 
            margin-top:10px;
            margin-left:26px;
            width: 548px;
            /* border:1px solid transparent; */
            
            height: 36px;
            background-color: rgb(21, 21, 21);

            transition: 0.23s ease-in-out;
        
        }

        .dbuttonwrapper:hover,
        .dbuttonwrapper:hover .downloadbutton {

            cursor:pointer;
            color: rgb(145, 145, 145);
            transition: 0.23s ease-in-out;
        }

        .downloadbutton{
            display: flex;
            justify-content: center;
            margin-top: 7px;

            width: 200px;
            color:white;
            text-decoration: none;
            
            transition: 0.23s ease-in-out;
        }

        .downloadbutton:hover{
            color: rgb(145, 145, 145);
            transition: 0.23s ease-in-out;
        }

        .subwrapper{
            display:block;
            align-items: center;
            text-align: center;
        }

        body{
            background:rgb(15, 15, 15);
        }
    </style>
</head>

<body>

    <div class="topnav">
        <div class="buttonwrapper">
            <form method="post"><button class="logoutbutton" name="logout">Logout</button></form>
        </div>
    </div>


    <div class="container">
        <div class="blue-rectangle">
            <div class="upperrectangle">
                <div class="welcome">
                    Welcome, <?php echo $username; ?>
                </div>
            </div>
        
            <br>
            <div class="subwrapper">
                <?php
                for ($i = 0; $i < count($subscriptions); $i++) {
                    echo "<span style='color:rgb(52, 235, 119);'>Active:</span> " . $subscriptions[$i]->subscription . " | Days left: " . floor($subscriptions[$i]->timeleft / (24*60*60)) . " days<br>";
                }
                ?>
            </div>
            <div class="buttonswrapper">
                <div class="dbuttonwrapper" onclick="document.querySelector('.downloadbutton').click()">
                    <a class="downloadbutton" href="./download.php">Download Loader</a>
                </div>

                <div class="dbuttonwrapper" onclick="document.querySelector('#discord').click()">
                    <a class="downloadbutton" id="discord" href="https://www.discord.com/" target="/">Join Discord</a>
            </div>
        </div>
        </div>
    </div>
    <!-- Does subscription with name <code style="background-color: #eee;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;">default</code> exist: <?php echo ((findSubscription("default", $_SESSION["user_data"]["subscriptions"]) ? 1 : 0) ? 'yes' : 'no'); ?> -->
</body>

</html>
<?php


#region Extra Functions
/*
//* Get Public Variable
$var = $KeyAuthApp->var("varName");
echo "Variable Data: " . $var;
//* Get User Variable
$var = $KeyAuthApp->getvar("varName");
echo "Variable Data: " . $var;
//* Set Up User Variable
$KeyAuthApp->setvar("varName", "varData");
//* Log Something to the KeyAuth webhook that you have set up on app settings
$KeyAuthApp->log("message");
//* Basic Webhook with params
$result = $KeyAuthApp->webhook("WebhookID", "&type=add&expiry=1&mask=XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX&level=1&amount=1&format=text");
echo "<br> Result from Webhook: " . $result;
//* Webhook with body and content type
$result = $KeyAuthApp->webhook("WebhookID", "", "{\"content\": \"webhook message here\",\"embeds\": null}", "application/json");
echo "<br> Result from Webhook: " . $result;
//* If first sub is what ever then run code
if ($subscription === "Premium") {
	Premium Subscription Code ...
}
//* Ban Function
 $KeyAuthApp->ban('Ban Reason Here');
*/
#endregion
?>
