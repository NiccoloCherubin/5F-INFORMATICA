<?php

class Log
{
    static function errlog(Exception $e, string $file): void{
        error_log("[" . date('Y-m-d H:i:s') . "] " . $e->getMessage() . "\n", '3', $file);
    }

}