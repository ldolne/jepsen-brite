<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="./index.php?action=testSubcat" method="POST">
    <select name="Payment 1" id="Payment1" editable="true">
        <option value="null" selected>Select... </option>
        <option value="A/C">A/C</option>
        <option value="Guest">Guest</option>
    </select>

    <div id="BCO" style="display: none">
        <input name="BCO Approved" type="checkbox" value="Yes" id="myId">
        I will pay by A/C.
    </div>

    <!-- <input type="checkbox" id="metal" name="subcategory_id[]" value="1">
    <label for="metal"> Metal</label><br>
    <input type="checkbox" id="classic" name="subcategory_id[]" value="11">
    <label for="classic"> Classic</label><br>
    <input type="checkbox" id="edm" name="subcategory_id[]" value="21">
    <label for="edm"> EDM</label><br>

    <input type="checkbox" id="contemporary_art" name="subcategory_id[]" value="31">
    <label for="contemporary_art"> Contemporary art</label><br>
    <input type="checkbox" id="photography" name="subcategory_id[]" value="41">
    <label for="photography"> Photography</label><br>
    <input type="checkbox" id="historical" name="subcategory_id[]" value="51">
    <label for="historical"> Historical</label><br>

    <input type="checkbox" id="political" name="subcategory_id[]" value="61">
    <label for="political"> Political</label><br>
    <input type="checkbox" id="environmental" name="subcategory_id[]" value="71">
    <label for="environmental"> Environmental</label><br>
    <input type="checkbox" id="educational" name="subcategory_id[]" value="81">
    <label for="educational"> Educational</label><br>

    <input type="checkbox" id="musical" name="subcategory_id[]" value="91">
    <label for="musical"> Musical</label><br>
    <input type="checkbox" id="environmental" name="subcategory_id[]" value="101">
    <label for="environmental"> Environmental</label><br>
    <input type="checkbox" id="social" name="subcategory_id[]" value="111">
    <label for="social"> Social</label><br>

    <input type="checkbox" id="fps" name="subcategory_id[]" value="121">
    <label for="fps"> FPS</label><br>
    <input type="checkbox" id="rpg" name="subcategory_id[]" value="131">
    <label for="rpg"> RPG</label><br>
    <input type="checkbox" id="moba" name="subcategory_id[]" value="141">
    <label for="moba"> MOBA</label><br> -->

    <input type="submit" name="submit" value="Submit"/>
</form>


<script src="./public/js/main.js"></script>
</body>
</html>

<?php
if(isset($_POST['submit'])){//to run PHP script on submit
    if(!empty($_POST['subcategory_id'])){
// Loop to store and display values of individual checked checkbox.
        foreach($_POST['subcategory_id'] as $selected){
            echo $selected."</br>";
            //requête sql de création event-souscat dans table d'assoc
        }
    }
}

// TODO
//  - Checkbox conditionnées en fonction du select - JS
//  - Corriger css des buttons sous cat


<th>
    Subcategory
</th>

                    $subcategories = $subcategoryManager->getSubcategoriesByEvent($data['id']);
                    $subcategoriesArr = $subcategories->fetchAll();

if(!empty($subcategoriesArr))
{
    $displaySubcategories = null;

    foreach($subcategoriesArr as $subcategory)
    {

        $displaySubcategories .= $subcategory['subcategory'];
    }

    echo $displaySubcategories;
}
else
{
    echo "None";
}

$subcategories->closeCursor();
?>