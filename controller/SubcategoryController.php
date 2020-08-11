<?php

// CATEGORY CONTROLLERS
namespace controller;

require_once('./autoloader.php');
require_once('./model/SubcategoryManager.php');

class SubcategoryController
{
    private $subcategoryManager;

    public function __construct()
    {
        $this->subcategoryManager = new \model\SubcategoryManager();
    }

    public function showOneSubcategory()
    {
        $search = $this->subcategoryManager->getOneSubcategory($_GET['subcategory_id']);
        if ($search === null) {
            throw new \Exception('No result.');
        } else {
            require('./view/eventsByCategory.php');
        }
    }
}