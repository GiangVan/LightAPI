<?php

class DB{
    private static $conn = null;

    private static function checkCon(){
        if(self::$conn === null)
        {
            $db_type = SystemConfig::get('DB_TYPE');
            $db_name = SystemConfig::get('DB_NAME');
            $host_name = SystemConfig::get('HOST_NAME');
            $user_name = SystemConfig::get('USER_NAME');
            $password = SystemConfig::get('PASSWORD');
            try
            {
                self::$conn = new PDO("{$db_type}:host={$host_name};dbname={$db_name}", $user_name, $password, 
    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);

                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch(PDOException $ex)
            {
                if(ErrorDisplay::isDisplayError())
                {
                    jsAlert($ex->getMessage(), false);
                }
            }
        }
    }

    public static function nonQuery($sql, array $params = null) : bool{
        self::checkCon();

        try {
            $obj = self::$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $obj->execute($params);
        } catch (PDOException $ex) {
            if(ErrorDisplay::isDisplayError())
            {
                jsAlert($ex->getMessage(), false);
            }
        }
        
        return false;
    }
    public static function query($sql, array $params = null) : array{
        self::checkCon();

        try {
            $obj = self::$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $obj->execute($params);
            if($obj !== false)
            {
                return $obj->fetchAll();
            }
        } catch (PDOException $ex) {
            if(ErrorDisplay::isDisplayError())
            {
                jsAlert($ex->getMessage(), false);
            }
        }

        return [];
    }
}