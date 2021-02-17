<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();


// Variables & constants

$email_error = $street_error = $streetnumber_error = $city_error = $zipcode_error = $order_error = "";
$email = $street = $streetnumber = $city = $zipcode = $order = "";
const max_number = 4;
const street_number = 5;

// Food & drinks array

if (!isset($_GET["food"])){

    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
}

elseif ($_GET["food"] == 0) {

    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
}
else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

// Required features
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["street"])) {
        $street_error = "* street name is required";
    } elseif (!empty($_POST["street"]) && is_numeric($_POST["street"])) {
        $street_error = "* text characters only";
    } else {
        $street = modified_input($_POST["street"]);
        $_SESSION["street"] = $street;
    }

    if (!empty($_POST["streetnumber"]) && !is_numeric($_POST["streetnumber"])) {
        $streetnumber_error = "* Needs to only consist of numbers";
    } elseif (empty($_POST["streetnumber"])) {
        $streetnumber_error = "* street number is required";
    } elseif (mb_strlen($_POST["streetnumber"]) > street_number) {
        $streetnumber_error = "* Street number exceeds the max value";
    } else {
        $streetnumber = modified_input($_POST["streetnumber"]);
        $_SESSION["streetnumber"] = $streetnumber;
    }

    if (empty($_POST["city"])) {
        $city_error = "* city name is required";
    } elseif (!empty($_POST["street"]) && is_numeric($_POST["city"])) {
        $city_error = "* text characters only";
    } else {
        $city = modified_input($_POST["city"]);
        $_SESSION["city"] = $city;
    }

    if (!empty($_POST["zipcode"]) && !is_numeric($_POST["zipcode"])) {
        $zipcode_error = "* Needs to only consist of numbers";
    } elseif (empty($_POST["zipcode"])) {
        $zipcode_error = "zipcode is required";
    } elseif (mb_strlen($_POST["zipcode"]) != max_number) {
        $zipcode_error = "* Needs to be 4 digits";
    } else {
        $zipcode = modified_input($_POST["zipcode"]);
        $_SESSION["zipcode"] = $zipcode;
    }

    if (empty($_POST["email"])) {
        $email_error = "* email address is required";}
        elseif (!empty($_POST["email"])) {
            if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false)  {
            $email_error = "* email address is invalid";
        }
        else {
            $email = modified_input($_POST["email"]);
            $_SESSION["email"] = $email;
        }
    }
}

if (isset($_POST["orderButton"]) && ($email == "" || $street == "" || $streetnumber == "" || $city == "" || $zipcode == "")) {
    $order_error = "* please fill in the form (todo and array) to complete your order!";
}
else {
    $order = "Everything is filled in, your order has been registered!";
}



// Calculate the expected delivery time for the product. For normal delivery all orders are fulfilled in 2 hours, for express delivery it is only 45 minutes.
//Add this expected time to the confirmation message.
//If you are wondering: they deliver with drones.




function modified_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}



$totalValue = 0;

if (!isset($_COOKIE["totalValue"]))
if (isset($_POST["products"])) {
    foreach ($_POST["products"] as $i => $price) {

        $totalValue += $products[$i]["price"];

    }
}


//    $_COOKIE = $i;


require 'form-view.php';

