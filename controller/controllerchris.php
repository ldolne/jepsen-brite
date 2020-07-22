<?php

require('./model/modelchris.php');

function getindexpage(){
    require('./view/mainpagechrisview.php');
}

function getinscriptionpage() {
    $inscription = register();
    require('./view/inscriptionview.php');
}

function getprofilesettingspage() {
    
}



