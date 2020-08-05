<?php


require_once('./model/UserManager.php');
require_once('./model/CategoryManager.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');
require_once('./model/SubCategoriesManager.php');


require_once('./require/functions.php');

function AllSubCategoriesController()
{

    $subCategoriesManager = new SubCategoriesManager();
    $search = $subCategoriesManager->AllSubCategoriesModel();
    require('./view/eventsByCategory.php');
}

function OneSubCategoryController()
{
    $subCategoriesManager = new SubCategoriesManager();
    $search = $subCategoriesManager->SubCategoryModel($_GET['subcategory_id']);
    if ($search === null) {
        throw new Exception('No result.');
    } else {
        require('./view/eventsByCategory.php');
    }
}
