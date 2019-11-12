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
 
    public function actionIndex() 
    {
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $productsInCart =false;
        
        // Получим данные из корзины
        $productsInCart = Cart::getProducts();
        
        if ($productsInCart) {
            // Получаем полную информацию о товарах из списка
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);
            
            // Получаем общую стоимость товара
            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once(ROOT . '/views/cart/index.php');
        
        return true;
    }
    
    /**
     * Action для добавления товара в корзину синхронным запросом
     * @param integer $id <p>id товара</p>
     */
    public function actionDelete($id)
    {
        // Удаляем заданный товар из корзины
        Cart::deleteProduct($id);
        // Возвращаем пользователя в корзину
        header("Location: /cart");
    }
}
