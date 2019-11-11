<?php

class CartController {

    public function actionAdd($id) 
    {
        // Добавляем товар в корзину
        Cart::addProduct($id);
        
        // Возвращаем пользователя на страницу
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
    
    public function actionAddAjax($id) 
    {
        // Добавляем товар в корзину
        echo Cart::addProduct($id);
        return true;
    }
    
}
