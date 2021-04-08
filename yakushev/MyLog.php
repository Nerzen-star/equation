<?php

namespace yakushev;

use core\LogAbstract;
use core\LogInterface;

class MyLog extends LogAbstract implements LogInterface {
    // fact logic
    public function _write() {
        $dateLog = date('d.m.Y_H.i.s.v');
        foreach ($this->log as $value) {
            echo $value . "\r\n";
            file_put_contents("log\\$dateLog.log", $value . PHP_EOL, FILE_APPEND);
        }
    }
    // only string, array
    public static function log(string $str): void {
        MyLog::Instance()->log[] = $str;
    }
    public static function write(): void {
        MyLog::Instance()->_write();
    }

    public static function clearArray() {
        MyLog::Instance()->log = array();
    }

    public static function getLog() {
        return MyLog::Instance()->log;
    }
}
