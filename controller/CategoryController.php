<?php

// CATEGORY CONTROLLERS
namespace controller;

//require_once('autoloader.php');

require_once('./model/CategoryManager.php');

class CategoryController
{
    private $categoryManager;

    public function __construct()
    {
        $this->categoryManager = new \model\CategoryManager();
    }

    public function AllCategoryController()
    {
        $search = $this->categoryManager->AllCategoryModel();
        require('./view/eventsByCategory.php');
    }

    public function OneCategoryController()
    {
        $search = $this->categoryManager->OneCategoryModel($_GET['category_id']);
        if ($search === null) {
            throw new Exception('No result.');
        } else {
            require('./view/eventsByCategory.php');
        }
    }
}