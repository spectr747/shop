<?php

class User 
{

    public static function register($name, $email, $password) {
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO user (name, email, password, role) '
                . 'VALUES (:name, :email, :password, "")';
        
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        
        return $result->execute();
    }
    
    /**
     * Проверяет имя: не меньше 2 символов
     */
    public static function checkName($name) {
        if (strlen($name) >= 2) {
            return true;
        } 
        return false;
    }
    
    /**
     * Проверяет телефон: не меньше, чем 10 символов
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }
    
    /**
     * Проверяет пароль: не меньше чем 6 символов
     */
    public static function checkPassword($password) {
        if (strlen($password) >= 6) {
            return true;
        } 
        return false;
    }    

    /**
     * Проверяет email
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } 
        return false;
    }    
    
    /**
     * Проверяет имеется ли в БД email 
     */
    public static function checkEmailExists($email) {
        
        $db = Db::getConnection();
        
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        
        if ($result->fetchColumn()) 
            return true;
        return false;
    }    
    
    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email
     * @param string $password
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password) 
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);        
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        
        return false;
    }
    
    /**
     * Запоминаем пользователя
     * @param string $email
     * @param string $password
     */
    public static function auth($userId) 
    {
        $_SESSION['user'] = $userId;
    }
    
    public static function checkLogged() 
    {
        // Если сессия есть, вернем мдентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        
        header('Location: /user/login');
    }
    
    public static function isGuest() 
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    } 
    
    /**
     * Возвращает пользователя с указанным id
     * @param integer $id id пользователя
     */
    public static function getUserById($id) 
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';
            
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
            
            return $result->fetch();
        }
    }
    
    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function edit($id, $name, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }
}
