<?php

// CATEGORY CONTROLLERS
namespace controller;

require_once('./autoloader.php');
require_once('./model/CategoryManager.php');

class CategoryController
{
    private $categoryManager;

    public function __construct()
    {
        $this->categoryManager = new \model\CategoryManager();
    }

    public function showAllCategories()
    {
        $search = $this->categoryManager->getAllCategories();

        if ($search === null) {
            throw new \Exception('No result.');
        } else {
            require('./view/eventsByCategory.php');
        }
    }

    public function showOneCategory()
    {
        $search = $this->categoryManager->getOneCategory($_GET['category_id']);

        if ($search === null) {
            throw new \Exception('No result.');
        } else {
            require('./view/eventsByCategory.php');
        }
    }
}