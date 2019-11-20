<?php

class FormattedURI{
    public $uri = null;

    public function __construct(string $uri){
        
        if(strlen($uri) > 1 && !isEmpty(str_replace('/', '', $uri)))
        {
            //check '/' char at the last position, ex uri: https://yourdomain.com/blabla/
            if(substr($uri, strlen($uri) - 1, 1) === '/')
            {
                $uri = substr($uri, 0, strlen($uri) - 1);
            }
            //remove GET mothod data
            if(stripos($uri, '?') !== false)
            {
                $uri = substr($uri, 0, stripos($uri, '?'));
            }
            //remove the '/' first char
            if(strlen($uri) > 1 && substr($uri,0 , 1) === '/')
            {
                $uri = substr($uri, 1);
            }
        }
        else if(strlen($uri) === 0)
        {
            $uri = '/';
        }
        $this->uri = $uri;
    }
}