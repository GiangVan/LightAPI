<?php

includeModel('MyDayModule', 'MyDateFormat');

class Day{
    private $day;

    public function __construct(string $account_id, string $per_day_id)
    {
        $day_list = DB::query("
            SELECT 
                DATE_FORMAT(per_day.bedtime, '%H:%i') AS sleeping_time, 
                DATE_FORMAT(per_day.bonus_time, '%H:%i') AS bonus_time, 
                DATE_FORMAT(per_day.wake_up_time, '%H:%i') AS waking_up_time, 
                id, 
                achievement,
                account_id,
                updated_at
            FROM per_day 
            WHERE account_id = :account_id AND id = :per_day_id", 
            [
                ':account_id' => $account_id, 
                ':per_day_id' => $per_day_id
            ]
        );

        if(empty($day_list))
        {
            $this->day = self::newDay($account_id, date("Y-m-d"), __FILE__, __LINE__);
        }
        else
        {
            $this->day = $day_list[0];
        }
    }

    public function update(array $request, string $account_id){
        $checked_list = [
            'waking_up_time',
            'sleeping_time',
            'bonus_time',
            'achievement'
        ];
        //update per_day if it changed
        foreach ($checked_list as $value){
           if($request[$value] !== $this->day[$value])
           {
                foreach ($checked_list as $v) {
                    $this->day[$v] = $request[$v];
                }
                $result = $this->save();
                if(!$result)
                {
                    jsAlert('error at file' . __FILE__ . ' line ' . __LINE__);
                }
                break;
           }
        }
        //check eatting changed
        $index = 0;
        while (isset($request['name-' . $index])) {
            $name = $request['name-' . $index];
            $calorie = $request['calo-' . $index];
            $id = $request['id-' . $index];

            if(!isEmpty($name) || !isEmpty($calorie))
            {
                $result = DB::nonQuery("
                    UPDATE eatting 
                    SET updated_at = :today, 
                        `describe` = :describe, 
                        calorie = :calo 
                    WHERE id = :id", 
                    [
                        ':describe' => $name,
                        ':calo' => $calorie,
                        ':id' => $id,
                        ':today' => MyDateFormat::getCurrentDateTime()
                    ]
                );
                if(!$result)
                {
                    jsAlert('error at file' . __FILE__ . ' line ' . __LINE__);
                }
            }
            else
            {
                $result = DB::nonQuery('DELETE FROM eatting WHERE id = :id', [':id' => $id]);
                if(!$result)
                {
                    jsAlert('error at file' . __FILE__ . ' line ' . __LINE__);
                }
            }
            
            $index++;
        }
        $index = 0;
        while (isset($request['new-name-' . $index])) {
            $name = $request['new-name-' . $index];
            $calorie = $request['new-calo-' . $index];

            if(!isEmpty($name) || !isEmpty($calorie))
            {
                $result = DB::nonQuery("
                    INSERT INTO eatting(`describe`, calorie, per_day_id, account_id) 
                    VALUES(:describe, :calo, :day_id, :account_id)", 
                    [
                        ':describe' => $name,
                        ':day_id' => $request['day_id'],
                        ':account_id' => $account_id,
                        ':calo' => $calorie
                    ]
                );
                if(!$result)
                {
                    jsAlert('error at file' . __FILE__ . ' line ' . __LINE__);
                }
            }

            $index++;
        }
    }

    public function save() : bool{
        return DB::nonQuery("
            UPDATE per_day 
            SET updated_at = :today, 
                wake_up_time = :waking_up_time, 
                bedtime = :sleeping_time, 
                bonus_time = :bonus_time, 
                achievement = :achievement 
            WHERE id = :day_id AND account_id = :account_id", 
            [
                ':waking_up_time' => $this->day['waking_up_time'] . ':00',
                ':sleeping_time' => $this->day['sleeping_time'] . ':00',
                ':bonus_time' => $this->day['bonus_time'] . ':00',
                ':achievement' => $this->day['achievement'],
                ':day_id' => $this->day['id'],
                ':account_id' => $this->day['account_id'],
                ':today' => MyDateFormat::getCurrentDateTime()
            ]
        );
    }

    public static function newDay(string $account_id, ?string $date, $file, $line) : array{
        $date = $date === null ? date("Y-m-d") : $date;
        if(DB::nonQuery('INSERT INTO per_day(account_id, id) VALUES(:account_id, :today)', [':account_id' => $account_id, ':today' => $date]))
        {
            $day_list = DB::query("
                SELECT 
                    DATE_FORMAT(per_day.bedtime, '%H:%i') AS sleeping_time, 
                    DATE_FORMAT(per_day.bonus_time, '%H:%i') AS bonus_time, 
                    DATE_FORMAT(per_day.wake_up_time, '%H:%i') AS waking_up_time, 
                    id, 
                    achievement,
                    account_id, 
                    updated_at 
                FROM per_day 
                WHERE account_id = :account_id AND id = :today 
                LIMIT 1", 
                [
                    ':account_id' => $account_id, 
                    ':today' => $date
                ]
            );
            if(empty($day_list))
            {
                jsAlert('error at file' . $file . ' line ' . $line . ' and ' . __LINE__);
            }
            else
            {
                return $day_list[0];
            }
        }
        else
        {
            jsAlert('error at file' . $file . ' line ' . $line . ' and ' . __LINE__);
        }
    }

    public static function getDay(string $account_id, string $date = null/* date type: Y-m-d*/) : array{
        $today = $date === null ? date("Y-m-d") : $date;
        $day_list = DB::query("
            SELECT 
                DATE_FORMAT(per_day.bedtime, '%H:%i') AS sleeping_time, 
                DATE_FORMAT(per_day.bonus_time, '%H:%i') AS bonus_time, 
                DATE_FORMAT(per_day.wake_up_time, '%H:%i') AS waking_up_time, 
                id, 
                achievement,
                account_id,
                updated_at 
            FROM per_day 
            WHERE account_id = :account_id AND id = :today 
            LIMIT 1", 
            [
                ':account_id' => $account_id, 
                ':today' => $today
            ]
        );

        $day = [];
        if(empty($day_list))
        {
            $day = self::newDay($account_id, $date, __FILE__, __LINE__);
        }
        else
        {
            $day = $day_list[0];
        }

        if(empty($day))
        {
            jsAlert('error at file' . __FILE__ . ' line ' . __LINE__);
        }
        else
        {
            //receive eatiing list for a day
            $day['eatting_list'] = DB::query("
                SELECT * 
                FROM eatting 
                WHERE per_day_id = :id AND account_id = :account_id", 
                [
                    ':account_id' => $account_id,
                    ':id' => $day['id']
                ]
            );
            return $day;
        }
    }
}