<?php

class ErrorDisplay extends ErrorMessage{
    protected static function getDisplayString(array $backtrace, int $backtrace_index, ErrorParam $param = null, $function) : string{
        $index = 0;
        if(isset($backtrace[$backtrace_index]))
        {
            $function = '_' . $function;
            $message = parent::$function($backtrace[$backtrace_index], $param);
            $index = $backtrace_index + 1;
        }
        else
        {
            $message = '<b>Unknown Error</b>';
        }
        $stack_traces = self::getStackTraces($backtrace, $index);
        return $message . $stack_traces;
    }

    public static function isDisplayError() : bool{
        return ini_get('display_errors') === '1' ? true : false;
    }

    private static function getStackTraces(array $backtrace, int $index) : string{
        if($index >= count($backtrace))
        {
            return '';
        }
        else
        {
            $result = '<b>Stack traces</b>:' . '<br>';
            for($i = $index; $i < count($backtrace); $i++)
            {
                $function = isset($backtrace[$i]['class']) ? $backtrace[$i]['class'] . $backtrace[$i]['type'] . $backtrace[$i]['function'] . '()' : $backtrace[$i]['function'] . '()';
                $result .= '<b>#' . ($i - $index) . '</b>: ' . $function . ' - ' . $backtrace[$i]['file'] . ' (line ' . $backtrace[$i]['line'] . ')' . '<br>';
            }
            return $result;
        }
    }
}