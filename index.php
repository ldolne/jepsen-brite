<?php require('./controller/controller.php');

if (isset($_GET["action"])) {
  if ($_GET["action"] == "inscription") {
    getinscriptionpage();
  } elseif ($_GET["action"] == "addEvent") {
    getaddevent();
  } elseif ($_GET["action"] == "category") {
    getcategory();
  } elseif ($_GET["action"] == "event") {
    getevent();
  } elseif ($_GET["action"] == "loging") {
    getloging();
  } elseif ($_GET["action"] == "oneEvent") {
    getoneEvent();
  } elseif ($_GET["action"] == "modifyEvent") {
    getmodifyEvent();
  } elseif ($_GET["action"] == "profil") {
    getprofil();
  } elseif ($_GET["action"] == "resultSearch") {
    getresultSearch();
  } elseif ($_GET["action"] == "search") {
    getSearch();
  }
} else {
  getindexpage();
}
