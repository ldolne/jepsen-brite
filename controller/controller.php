<?php
require('./model/model.php');

function getindexpage()
{
    require('./view/mainPage.php');
}

function getinscriptionpage(){
    $inscription= register();
    require('./view/signup.php');
}

function getaddevent(){
    require('./view/addEvent.php');
}

function getcategory(){
    require('./view/category.php');
}

function getevent(){
    require('./view/event.php');
}

function getloging(){
    require('./view/loging.php');
}

function getmodifyEvent(){
    require('./view/modifyEvent.php');
}

function getoneEvent(){
    require('./view/oneEvent.php');
}

function getprofil(){
    require('./view/profil.php');
}

function getresultSearch(){
    require('./view/resultSearch.php');
}

function getsearch(){
    require('./view/search.php');
}