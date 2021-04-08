<?php

use PHPUnit\Framework\TestCase;
use yakushev\MyLog;

class MyLogTest extends TestCase {

    public static $log=[];

    public static function setUpBeforeClass(): void {
        MyLog::clearArray();
        $dir = 'log\\';
        if (!file_exists($dir)) {
            mkdir($dir, 0755);
        }
    }

    /**
     * @dataProvider providerLog
     * @param string $str
     * @return void
     */
    public function testLog(string $str): void {
        MyLog::log($str);
        self::$log[] = $str;
        $this->assertSame(self::$log, MyLog::getLog());
    }

    public function providerLog() {
        return array(
            array('Hello'),
            array('GG')
        );
    }

    protected function _scandir($dir, $exp, $how='name', $desc=0) {
        $r = array();
        $dh = @opendir($dir);
        if ($dh){
            while(($fname = readdir($dh)) !== false) {
                if (preg_match($exp, $fname)) {
                    $stat = stat("$dir/$fname");
                    $r[$fname] = ($how == 'name')? $fname: $stat[$how];
                }
            }
            closedir($dh);
            if ($desc){
                arsort($r);
            }else{
                asort($r);
            }
        }
        return(array_keys($r));
    }

    /**
     * @depends testLog
     */
    public function testWrite() {
        $_tmpLogTxt='';
        foreach(self::$log as $v){
            $_tmpLogTxt.="{$v}\r\n";
        }
        $this->expectOutputString($_tmpLogTxt);
        MyLog::write();
        $this->assertDirectoryExists('log');
        $_tmpLogFile=$this->_scandir(
            'log\\',
            '/'.date('d.m.Y_H.i.s.v').'[0-9.]*\.log$/',
            'ctime',
            1
        )[0];
        $this->assertFileExists('log/'.$_tmpLogFile);
        $this->assertIsReadable('log/'.$_tmpLogFile);
        $this->assertStringEqualsFile('log/'.$_tmpLogFile,$_tmpLogTxt);
    }
}