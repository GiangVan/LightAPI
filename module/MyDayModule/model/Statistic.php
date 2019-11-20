<?php

class Statistic{
    public static function getLineCharts(string $account_id) : array{
        $result = DB::query("
            SELECT 
                DATE_FORMAT(dayb.id, '%d/%m/%y') AS aday,
                SUM(calorie) AS calories,
                ADDTIME(
                    IF(
                        dayb.wake_up_time > 
                        (
                            SELECT daya.bedtime 
                            FROM per_day daya 
                            WHERE daya.id < dayb.id AND daya.account_id = dayb.account_id
                            ORDER BY daya.id DESC LIMIT 1
                        ),  
                        TIMEDIFF(
                            dayb.wake_up_time, 
                        	(
                                SELECT daya.bedtime 
                                FROM per_day daya 
                                WHERE daya.id < dayb.id AND daya.account_id = dayb.account_id
                                ORDER BY daya.id DESC LIMIT 1
                            )
                        ), 
                        ADDTIME(
                            TIMEDIFF(
                                dayb.wake_up_time, 
                                (
                                    SELECT daya.bedtime 
                                    FROM per_day daya 
                                    WHERE daya.id < dayb.id AND daya.account_id = dayb.account_id
                                    ORDER BY daya.id DESC LIMIT 1
                                )
                            ), 
                            '24:00:00'
                        ) 
                    ), 
                    dayb.bonus_time
                ) AS sleeping_time
            FROM per_day dayb
            INNER JOIN eatting ON dayb.id = eatting.per_day_id AND eatting.account_id = dayb.account_id
            WHERE dayb.account_id = :account_id
            GROUP BY dayb.id",
            [
                ':account_id' => $account_id
            ]
        );

        foreach ($result as &$value) {
            if(!empty($value['sleeping_time']))
            {
                $timestamp = strtotime($value['sleeping_time']);
                $value['sleeping_time'] = date('H', $timestamp) + date('i', $timestamp) / 60;  
            }
        }
        return $result;
    }

    public static function getDoughnutCharts(string $account_id) : array{
        $result = [];
        $result['usuallyWakeUp'] = DB::query("
            SELECT 
                COUNT(wake_up_time) AS num, 
                IF(MINUTE(wake_up_time) > 40,
                    CONCAT(HOUR(wake_up_time) + 1, ':00'),
                    IF(MINUTE(wake_up_time) > 19,
                        CONCAT(HOUR(wake_up_time), ':30'),
                        CONCAT(HOUR(wake_up_time), ':00'))) AS waking_up_time 
            FROM per_day
            WHERE wake_up_time IS NOT null AND account_id = :account_id
            GROUP BY waking_up_time", 
            [
                ':account_id' => $account_id
            ]
        );
        $result['usuallySleep'] = DB::query("
            SELECT 
                COUNT(bedtime) AS num, 
                IF(MINUTE(bedtime) > 40,
                    CONCAT(HOUR(bedtime) + 1, ':00'),
                    IF(MINUTE(bedtime) > 19,
                        CONCAT(HOUR(bedtime), ':30'),
                        CONCAT(HOUR(bedtime), ':00'))) AS sleeping_time 
            FROM per_day
            WHERE bedtime IS NOT null AND account_id = :account_id
            GROUP BY sleeping_time", 
            [
                ':account_id' => $account_id
            ]
        );

        return $result;
    }

    public static function getAchievement(string $account_id) : array{
        return DB::query("
            SELECT 
                DATE_FORMAT(id, '%d/%m/%Y') AS day, 
                achievement
            FROM per_day
            WHERE LENGTH(achievement) > 0 AND account_id = :account_id", 
            [
                ':account_id' => $account_id
            ]
        );
    }
}