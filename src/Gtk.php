<?php

class Gtk extends PhpGtk3
{
    private static $instance;

    /**
     * FFI Object.
     */
    protected $ffi = '';

    /**
     * Invalida os metodos magicos.
     */
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function __construct()
    {
    }

    public static function init(int $argc = 0, array $argv = [])
    {
        $instance = self::getInstance();

        $argc = FFI::new('int');
        $argv = FFI::new('char[0]');
        $pargv = FFI::addr($argv);

        $instance->ffi->gtk_init(\FFI::addr($argc), \FFI::addr($pargv));
    }

    public static function main()
    {
        $instance = self::getInstance();

        $instance->ffi->gtk_main();
    }

    public static function main_quit()
    {
        $instance = self::getInstance();

        $instance->ffi->gtk_main_quit();
    }
}
