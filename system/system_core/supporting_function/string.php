<?php

//kiểm tra chuỗi rỗng (bỏ qua các ký tự khoảng trắng), trường hợp mang giá trị số là 0 thì sẽ không tính là rỗng
function isEmpty($text) : bool{
    return is_null($text) || (empty($text) && $text != 0) || (is_string($text) && strlen(str_replace(" ", "", $text)) == 0);
}

//generate a random string
function generateRandomString(int $length) : string{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//characters form
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//generate a random number string
function generateRandomNumString(int $length) : string{
    $characters = "0123456789";//characters form
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function replaceOne(string $search, string $replace, string $subject) : string{
    $index = strpos($subject, $search);
    if($index !== false)
    {
        if($index === 0)
        {
            return $replace . substr($subject, strlen($search));
        }
        else
        {
            return substr($subject, 0, $index) . $replace . substr($subject, $index + strlen($search));
        }
    }
    else
    {
        ErrorHandler::echo('');
    }   
}




