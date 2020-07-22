<?php 
require('./controller/controllerchris.php');

if (isset($_GET['action'])){
    if ($_GET['action'] == 'inscription'){
        getinscriptionpage();
    }
    elseif ($_GET['action'] == 'profilesettings'){
        getprofilesettingspage();
    }
}

else {
    getindexpage();
}