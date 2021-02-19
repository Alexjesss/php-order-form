<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=0">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=1">Order drinks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=3">Order food & drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control"
                       value="<?php echo $_POST["email"] ?? $_SESSION["email"] ?? ''; ?>"/>
                <!-- above code is shortcut for < ? php echo isset($_POST['name']) ? $_POST['name'] : ''; ? > , ?? = if isset? do this, code after ?? = else, '' = empty string  -->
                <span><?php echo $email_error; ?></span>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control"
                           value="<?php echo $_POST["street"] ?? $_SESSION["street"] ?? ''; ?>">
                    <span><?php echo $street_error; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control"
                           value="<?php echo $_POST["streetnumber"] ?? $_SESSION["streetnumber"] ?? ''; ?>">
                    <span><?php echo $streetnumber_error; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"
                           value="<?php echo $_POST["city"] ?? $_SESSION["city"] ?? ''; ?>">
                    <span><?php echo $city_error; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control"
                           value="<?php echo $_POST["zipcode"] ?? $_SESSION["zipcode"] ?? ''; ?>">
                    <span><?php echo $zipcode_error; ?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="number" value="0" min="0" max="10" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
                <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5"/>
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary" name="orderButton">Order!</button>
        <span><?php echo $order . $order_error ?></span>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks. <br>
        <strong><?php echo $express . $no_express ?></strong>
    </footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
