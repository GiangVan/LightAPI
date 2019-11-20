<?php

class MappingTrace{
    public $line;
    public $file;
    public $caller;
    public $args;

    public function __construct(int $backtrace_index){
        $trace_array = debug_backtrace();
        $trace = $trace_array[$backtrace_index];
        $this->line = $trace['line'];
        $this->args = $trace['args'][1];
        $this->file = $trace['file'];
        if(!isset($trace['class']))
        {
            $this->caller = $trace['function'] . '()';
        }
        else
        {
            $this->caller = $trace['class'] . $trace['type'] . $trace['args'][0] . '()';
        }
    }
}