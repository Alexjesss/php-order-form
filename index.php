<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();


// VARIABLES & CONSTANTS

$email_error = $street_error = $streetnumber_error = $city_error = $zipcode_error = $order_error = $no_express = "";
$email = $street = $streetnumber = $city = $zipcode = $order = $express = "";
const max_number = 4;
const street_number = 5;
$cookie_name = "saved-orders";
$expire = time() + (86400 * 30);

// COOKIE

if (isset($_COOKIE["saved-orders"])){
    $totalValue = (float)$_COOKIE["saved-orders"];
}
else {
    $totalValue = 0;
    setcookie($cookie_name,(string)$totalValue,$expire);
}

// FOOD & DRINKS ARRAY SWITCH

if (!isset($_GET["food"])) {

    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} elseif ($_GET["food"] == 0) {

    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

// INPUT FIELDS

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //STREET

    if (empty($_POST["street"])) {
        $street_error = "* street name is required";
    } elseif (!empty($_POST["street"]) && is_numeric($_POST["street"])) {
        $street_error = "* text characters only";
    } else {
        $street = modified_input($_POST["street"]);
        $_SESSION["street"] = $street;
    }
    //STREETNUMBER

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
    //CITY

    if (empty($_POST["city"])) {
        $city_error = "* city name is required";
    } elseif (!empty($_POST["street"]) && is_numeric($_POST["city"])) {
        $city_error = "* text characters only";
    } else {
        $city = modified_input($_POST["city"]);
        $_SESSION["city"] = $city;
    }
    //ZIPCODE

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
    // EMAIL

    if (empty($_POST["email"])) {
        $email_error = "* email address is required";
    } elseif (!empty($_POST["email"])) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
            $email_error = "* email address is invalid";
        } else {
            $email = modified_input($_POST["email"]);
            $_SESSION["email"] = $email;
        }
    }
}
// ORDER BUTTON

if (isset($_POST["orderButton"]) && ($email == "" || $street == "" || $streetnumber == "" || $city == "" || $zipcode == "")) {
    $order_error = "* please fill in the form to complete your order!";
}
 else {
    $order = "Everything is filled in, your order has been registered!";
}

// CALCULATING ORDERS

if (isset($_POST["products"],$_POST["express_delivery"])) {
    $currentTime_express = time();
    $express_delivery = 1;
    $express_seconds = $express_delivery * (45 * 60);
    $newTime_express = $currentTime_express + $express_seconds;

    $express = "Thank you for choosing express delivery! Your order will arrive at" . " " . date("H:i", $newTime_express) . " " . "minutes";
} elseif (isset($_POST["products"])) {
    $currentTime = time();
    $deliveryHours = 2;
    $seconds = $deliveryHours * (60 * 60);
    $newTime = $currentTime + $seconds;

    $no_express = "Your order will arrive at " . " " . date("H:i", $newTime) . " " . "Hours";
}

//FUNCTION FOR INPUT SECURITY

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

//COUNTER + COOKIE

if (isset($_POST["products"])) {
    foreach ($_POST["products"] as $i => $price) {
        $totalValue += $products[$i]["price"];
    }
    if
    (isset($_POST["express_delivery"])){
        $totalValue += $_POST["express_delivery"];
    }
    setcookie($cookie_name,(string)$totalValue,$expire);
}

require 'form-view.php';

