<?php 
session_start();
if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])
&& isset($_COOKIE['id']) && !empty($_COOKIE['id'])){
    $_SESSION['username']= $_COOKIE['username'];
    $_SESSION['id']= $_COOKIE['id'];

}

require('./controller/controller.php');

if (isset($_GET['action'])){
  if ($_GET['action'] == 'inscription'){
      if(!empty($_POST['username']) 
      && !empty($_POST['password'])
      && !empty($_POST['passwordcheck'])
      && !empty($_POST['email'])) {
          actualInscription();

      }
      else {
          getInscriptionPage();
      }
  }

  elseif ($_GET['action'] == 'connection'){
      if(!empty($_POST['username']) && !empty($_POST['password'])){
          login();
      }
      else {
          getConnectionPage();
      }
  }

  elseif ($_GET['action'] == 'deconnection'){
      deconnection();
  }

  elseif (isset($_SESSION['username']) && !empty($_SESSION['username'])){
      if ($_GET['action'] == 'profile'){
          getProfilePage();
      }

      elseif ($_GET['action'] == 'modifyprofile'){
          if(!empty($_POST['username']) 
          || (!empty($_POST['password']) && $_POST['password'] == $_POST['passwordcheck'])){
              profileModification();
          }
          else {
              modifyProfilePage();
          }
      }

      elseif ($_GET['action'] == 'deleteprofile'){
          deleteAccount();
      }
  }
}

else {
  getindexpage();
}




  if ($_GET["action"] == "addEvent") {
    getaddevent();
  } elseif ($_GET["action"] == "category") {
    getcategory();
  } elseif ($_GET["action"] == "event") {
    AllCategoryController();
  } elseif ($_GET["action"] == "oneEvent") {
    getoneEvent();
  } elseif ($_GET["action"] == "modifyEvent") {
    getmodifyEvent();
  
  } elseif ($_GET["action"] == "resultSearch") {
    getresultSearch();
  } elseif ($_GET["action"] == "search") {
    getSearch();
  } elseif ($_GET["action"] == "onecategorycontroller") {
    OneCategoryController();
  }elseif ($_GET["action"] == "allcategorycontroller") {
    AllCategoryController();
  }

