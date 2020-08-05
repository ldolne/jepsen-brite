<?php

// CATEGORY CONTROLLERS
namespace controller;

require_once('autoloader.php');

class CategoryController
{
    public function AllCategoryController()
    {
        $categoryManager = new CategoryManager();
        $search = $categoryManager->AllCategoryModel();
        require('./view/eventsByCategory.php');
    }

    public function OneCategoryController()
    {
        $categoryManager = new CategoryManager();
        $search = $categoryManager->OneCategoryModel($_GET['category_id']);
        if ($search === null) {
            throw new Exception('No result.');
        } else {
            require('./view/eventsByCategory.php');
        }
    }
}