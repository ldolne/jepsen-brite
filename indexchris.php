<?php 
session_start();
if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])
&& isset($_COOKIE['id']) && !empty($_COOKIE['id'])){
    $_SESSION['username']= $_COOKIE['username'];
    $_SESSION['username']= $_COOKIE['username'];

}
require('./controller/controllerchris.php');

if (isset($_GET['action'])){
    if ($_GET['action'] == 'inscription'){
        if(!empty($_POST['username']) 
        && !empty($_POST['password'])
        && !empty($_POST['passwordcheck'])
        && !empty($_POST['email'])) {
            actualInscription();

        }
        else {
            getinscriptionpage();
        }
    }

    elseif ($_GET['action'] == 'connection'){
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            login();
        }
        else {
            getconnectionpage();
        }
    }

    elseif ($_GET['action'] == 'deconnection'){
        deconnection();
    }

    elseif (isset($_SESSION['username']) && !empty($_SESSION['username'])){
        if ($_GET['action'] == 'profile'){
            getprofilepage();
        }

        elseif ($_GET['action'] == 'modifyprofile'){
            if(!empty($_POST['username']) 
            || (!empty($_POST['password']) && $_POST['password'] == $_POST['passwordcheck'])){
                profilemodification();
            }
            else {
                modifyprofilepage();
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