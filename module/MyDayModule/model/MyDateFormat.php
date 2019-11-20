<?php

class MyDateFormat{
    private $timestamp;

    public static function getToday() : string{
        return date("d/m");
    }

    public static function getDayOfWeek() : string{
        return self::getDayOfWeekByNum(date('N'));
    }

    public static function getByFormat(string $date, string $curent_format, string $format_to) : string{
        $rawDate = DateTime::createFromFormat($curent_format, $date);
        return $rawDate->format($format_to);
    }

    private static function getDayOfWeekByNum($number) : string{
        switch ($number) {
            case '1':
                return 'Thứ hai';
                break;
            case '2':
                return 'Thứ ba';
                break;
            case '3':
                return 'Thứ tư';
                break;
            case '4':
                return 'Thứ năm';
                break;
            case '5':
                return 'Thứ sáu';
                break;
            case '6':
                return 'Thứ bảy';
                break;
            case '7':
                return 'Chủ nhật';
                break;
        }
    }
    
    //base format under: Y-m-d
    public static function getCurrentDateTime() : string{
        return date("Y-m-d H:i:s");
    }

    public function __construct(string $date, string $curent_format = 'Y-m-d')
    {
        $this->timestamp = strtotime(self::getByFormat($date, $curent_format, 'Y-m-d'));
    }
    

    public function toDayMonth() : string{
        return date("d/m", $this->timestamp);
    }

    public function toDayOfWeek() : string{
        $dayOfWeek = date("N", $this->timestamp);
        return self::getDayOfWeekByNum($dayOfWeek);
    }
    
    public function get() : string{
        return date("Y-m-d", $this->timestamp);
    }
}