<?php
/**
 *
 * Title:GRC/IT328/Dating App/index.php
 * Author: Carmen Gallardo && Robert Hill III
 * Date: 05.02.2019
 * Code Version: V1.0
 * Availability: http://rhill.greenriverdev.com/328/pet4/index.php
 *
 */

//Start session
session_start();

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Require the business logic
require_once('model/validation-functions.php');
////Include static head
//include('views/head.html');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('colors', array(
    'pink',
    'green',
    'blue'
));
$f3->set('activity', array(
    'jump',
    'kick',
    'run',
    'kiss'
));

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function()
{
    echo "<h1>my Pets</h1><br><p><a href='order'>Order a pet</a></p>";
    //    //Display a view
    //    $view = new Template();
    //    echo $view->render('views/home.html');

});

$f3->route('GET|POST /order', function($f3)
{

    $animal = null;
    $qty    = null;

    if (!empty($_POST)) {
        $animal = $_POST['animal'];
        $qty    = $_POST['qty'];

        //Add data to hive
        $f3->set('animal', $animal);
        $f3->set('qty', $qty);

        if (validText($animal) && (validQty($qty))) {
            $_SESSION['animal'] = $animal;
            $_SESSION['qty']    = $qty;
            $f3->reroute('/order2');
        } //validText($animal) && (validQty($qty))

        if (!validText($animal)) {
            $f3->set("errors['animal']", "Please enter a valid animal.");
        } //!validText($animal)

        if (!validQty($qty)) {
            $f3->set("errors['qty']", "Please enter a valid quantity");
        } //!validQty($qty)
    } //!empty($_POST)

    //Display a view
    $view = new Template();
    echo $view->render('views/form1.html');

});

$f3->route('GET|POST /order2', function($f3)
{
    if (!empty($_POST)) {
        $color = $_POST['color'];
        $act   = $_POST['act'];

        if (validColor($color) && validCheck($act)) {
            $_SESSION['color'] = $color;
            $_SESSION['act']   = $act;

            $f3->reroute('/results');
        } //validColor($color) && validCheck($act)
        else {
            $f3->set("errors['color']", "Please enter a color.");
            $f3->set("errors['act']", "Your pet cannot do that right now! Choose an Activity");
        }
    } //!empty($_POST)
    //Display a view
    $view = new Template();
    echo $view->render('views/form2.html');
});
//Define a Lunch route with a parameter
$f3->route('GET /@animal', function($f3, $params)
{
    $animal = $params['animal'];
    switch ($animal) {
        case 'chicken':
            echo "Cluck!";
            break;

        case 'dog':
            echo "Wuff!";
            break;

        case 'Cat':
            echo "Meow!";
            break;

        case 'pig':
            echo "Oink!";
            break;

        case 'wolf':
            echo "Ouuuuu!";
            break;

        default:
            $f3->error(404);
    } //$animal
});

$f3->route('GET|POST /results', function()
{
    //    $_SESSION['color'] = $_POST['color'];
    //    print_r($_SESSION);
    $interest              = implode(", ", $_SESSION['act']);
    $_SESSION['actString'] = $interest;
    //Display a view
    $view                  = new Template();
    echo $view->render('views/results.html');

});

//Run fat free
$f3->run(); 