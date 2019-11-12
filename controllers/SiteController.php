<?php

class SiteController 
{

    public function actionIndex() 
    {
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(6);
        
        // Список товаров для слайдера
        $sliderProducts = Product::getRecommendedProducts();
        
        require_once(ROOT . '/views/site/index.php');
        
        return true;
    }
    
    public function actionContact() 
    {
        $userEmail = '';
        $userText = '';
        $result = false;
        
        if (isset($_POST['submit'])) {
            
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            
            $errors = false;
            
            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Непарвильный email';
            }
            
            // Для удаленного сервера
            /*
            if ($errors == false) {
                $adminEmail = 'test_email@test_email.test_email';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
            */
            
            // Для локального сервера
            if ($errors == false) {
                $result = true;
            }
        }
        
        require_once(ROOT . '/views/site/contact.php');      
        
        return true;
    }
}
