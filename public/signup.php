<?php
if(!session_id())
  session_start();

use Iutrds\Tp5\Authentification;
use Iutrds\Tp5\BddConnect;
use Iutrds\Tp5\MariaDBUserRepository;

require_once 'header.php';
require_once '../vendor/autoload.php';

$bdd = new BddConnect();

$pdo = $bdd->connexion();
$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  try {
    $retour = $auth->register($_POST['email'], $_POST['password'], $_POST['repassword']);
    $message = "Vous êtes enregistré. Vous pouvez vous authentifier";
    $code = "success";
  }
  catch(Exception $e) {
    $retour = false;
    $message = "Enregistrement impossible : " . $e->getMessage();
    $code = "warning";
  }


  $_SESSION['flash'][$code] = $message;

  $direction = $_SERVER['HTTP_ORIGIN'];
  header("Location: $direction/index.php");

}

require_once 'footer.php';