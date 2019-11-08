<?php

include_once(ROOT . '/models/Category.php');

class SiteController 
{

    public function actionIndex() 
    {
        $categories = array();
        $categories = Category::getCategoriesList();
        
        require_once(ROOT . '/views/site/index.php');
        
        return true;
    }
}
