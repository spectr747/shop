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
    
}
