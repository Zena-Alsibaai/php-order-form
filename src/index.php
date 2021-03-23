<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
//your products with their price.
$pizzas = [
    ['name' => 'Margherita', 'price' => 8],
    ['name' => 'Hawaï', 'price' => 8.5],
    ['name' => 'Salami pepper', 'price' => 10],
    ['name' => 'Prosciutto', 'price' => 9],
    ['name' => 'Parmiggiana', 'price' => 9],
    ['name' => 'Vegetarian', 'price' => 8.5],
    ['name' => 'Four cheeses', 'price' => 10],
    ['name' => 'Four seasons', 'price' => 10.5],
    ['name' => 'Scampi', 'price' => 11.5]
];

$drinks = [
    ['name' => 'Water', 'price' => 1.8],
    ['name' => 'Sparkling water', 'price' => 1.8],
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 2.2],
];


// ==== Define pizzas as default ====
$products =$pizzas;
// ==== Switch between drinks and pizzas ====
if (isset($_GET['food'])){ // C'est true par défaut
    if($_GET['food'] == false) { // food = 0 donc c'est faux
        $products = $drinks;
    }
}


$totalValue = 0;

// ========= Validate Form Data =========

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = valid_data($_POST["email"]);
    $street = valid_data($_POST["street"]);
    $streetNumber = valid_data($_POST["streetnumber"]);
    $city = valid_data($_POST["city"]);
    $zipCode = valid_data($_POST["zipcode"]);
}

function valid_data($data) {
    $data = trim($data); // trim () pour supprimer les espaces inutiles
    $data = stripslashes($data);// stripslashes() pour supprimer les antislashes que certains hackers pourraient utiliser pour échapper des caractères spéciaux
    $data = htmlspecialchars($data);
    // htmlspecialchars () pour permettre d’échapper certains caractères spéciaux comme les chevrons « < » et « > » en les transformant en entités HTML.
    return $data;
}

// Define variables to empty values  
$email= $street = $streetNumber = $city = $zipCode = "";
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipCodeErr = "";
$message ="";
$menuErr = $menuSelect ="";
$deliveryTime="";
// ========= Required Fields =========

//  if (empty($_POST["email"])) {
//       $emailErr = "Email is required";
//     } else {
//       $email = valid_data($_POST["email"]);
//       // check if e-mail address is well-formed
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $emailErr = '<div class="alert alert-danger" role="alert">
//                         Invalide Email
//                         </div>';
                
//         }
//     }
// ========= Form Validation =========


// ========= Submit button =========
if(isset($_POST['submit'])) { 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ========= Email Validation =========
        if (!empty($_POST["email"])) {
            $email = valid_data($_POST["email"]);
          // check if e-mail address isn't in valid format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = '<div class="alert alert-danger" role="alert">Invalid Email !</div>';
            }
        }
        // ========= Street Validation =========
        if (!empty($_POST["street"])) {
            $street = valid_data($_POST["street"]);
        }
        // ========= Street-number Validation =========
        if (!empty($_POST["streetnumber"])) {
            $streetNumber = valid_data($_POST["streetnumber"]);
            // check if street number  isn't in numeric format
            if (!is_numeric($streetNumber)) {
               $streetNumberErr = '<div class="alert alert-danger" role="alert">Only numeric value is allowed !</div>';
           }
        }
        // ========= City  =========
        if (!empty($_POST["city"])) {
            $city = valid_data($_POST["city"]);
        } 
        // ========= Zipcode =========
        if (!empty($_POST["zipcode"])) {
            $zipCode = valid_data($_POST["zipcode"]);
            // check if zipcode  isn't in numeric format
            if (! is_numeric($zipCode)) {
               $zipCodeErr = '<div class="alert alert-danger" role="alert">Only numeric value is allowed !</div>';
           }
        }
          // ========= Set local hour =========
        $localtime = localtime();
        $minute = $localtime[1];// localtime() return un array. [1] the index of the Minute & [2]Hour
        $hour = $localtime[2]+1;
        
        if(isset($_POST['express_delivery'])){
            $minute = $minute + 30;
            if ($minute >= 60){
                $hour =$hour + 1;
                $minute = $minute - 60; 
            }
            if ($minute < 10){
                $minute = 0 . $minute;
                }
            $deliveryTime = '<div class="alert alert-info" role="alert">Your order will arrive at : ' . $hour . ' H ' . $minute . '</div>';
            $totalValue = 5;      
        }else{
        $deliveryTime = '<div class="alert alert-info" role="alert">Your order will arrive at : ' . $hour +1 . ' H ' . $minute .  '</div>';
        } 
        
          
        //   if(!isset($_POST['products'])){
        //     $menuErr = '<div class = "alert alert-danger" role = "alert">Invalid Selection</div>';
        // }
        // else{
        //     $menuSelect= $_POST['products'];
        //     echo $deliveryTime;
        // }
    }
    

    if($emailErr == "" && $streetErr == "" && $streetNumberErr == "" && $cityErr == "" && $zipCodeErr == "" ) {  
        $message = '<div class="alert alert-info" role="alert">You have sucessfully registered.</div>';  
    }else {  
        $message = '<div class="alert alert-danger" role="alert">You did not filled up the form correctly.</div>';  
    }
  
    // var_dump($localtime);
    // echo $hour;
    // echo $minute;
    if(isset($_POST['products'])){
        $products_select = $_POST['products'];
        foreach($products_select AS $i => $choice){
            $choice =$products[$i]['price'];
            $totalValue += $choice;
        }
        $_SESSION ['total-price'] = $totalValue;
    }
}
require 'form-view.php';