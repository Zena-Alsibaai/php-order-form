<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Order Pizzas & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order pizzas in restaurant "the Personal Pizza Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order pizzas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <span class = "error">* required field </span> 
    <br>
    <br>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
            <?php echo $successMessage; ?>
            <?php echo $errorMessage; ?>
                <label for="email">E-mail:</label>
                <span class="error">*</span>
                <?php echo $emailErr; ?>
                <input type="text" id="email" name="email"  class="form-control" value="<?php echo $email;?>" required>
            </div>
            <div></div>
        </div>
        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <span class="error">*</span>
                    <?php echo $streetErr; ?>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo $street;?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <span class="error">*</span>
                    <?php echo $streetNumberErr; ?>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo $streetNumber;?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city" >City:</label>
                    <span class="error">*</span>
                    <?php echo $cityErr; ?>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo $city;?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <span class="error">*</span>
                    <?php echo $zipCodeErr; ?>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $zipCode;?>" required>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        
        <label>
            <input type="checkbox" name="express_delivery" value="5" /> 
            Express delivery (+ 5 EUR) 
           
        </label>
        <?php echo $successMessage; ?>
            
        <button type="submit" class="btn btn-primary" name="submit">Order!</button>
        
        <?php
                pre_r($_POST);
                if (isset($_POST["submit"])){
                    echo $email . "<br>";
                    echo $street . "<br>";
                    echo $streetNumber . "<br>";
                    echo $city  . "<br>";
                    echo $zipCode . "<br>";
                }
                function pre_r ($array) {
                    echo '<pre>';
                    print_r($array);
                    echo '<pre>';
                }
        ?>
    </form>


    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in pizza(s) and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
    .error {
        color: #FF0000;
        font-size: 1.2rem;
    }
</style>
</body>
</html>





