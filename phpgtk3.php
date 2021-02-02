<?php

putenv('GTK_CSD=0');
// putenv("PATH=" . getenv("PATH") . ";C:\\gtk3\\bin");

// Define a path to class
defined('PHPGTK3_PATH') || define('PHPGTK3_PATH', dirname(__FILE__));

// Define a path to source directory
defined('PHPGTK3_SOURCE_PATH') || define('PHPGTK3_SOURCE_PATH', PHPGTK3_PATH.'/src');

// Define lib path
if ('windows' === strtolower(PHP_OS_FAMILY)) {
    // define("GTK_LIB_PATH", "C:\\php7.4\\bin\\gtk-3.dll");
    define('GTK_LIB_PATH', 'C:\\gtk3\\bin\\libgtk-3-0.dll');
} elseif ('linux' === strtolower(PHP_OS_FAMILY)) {
    define('GTK_LIB_PATH', '/usr/lib/x86_64-linux-gnu/libgtk-3.so.0');
} elseif ('darwin' === strtolower(PHP_OS_FAMILY)) {
    throw new Exception('Not tested and working on Mac', 0);
    // define("GTK_LIB_PATH", "/usr/lib/x86_64-linux-gnu/libgtk-3.so.0");
}

// Define if need recompile headers on run
define('PHPGTK3_RECOMPILE_HEADERS', true);

// Autoload
spl_autoload_register(function ($className) {
    $filename = PHPGTK3_SOURCE_PATH.'/'.implode('/', explode('\\', $className)).'.php';
    if (!file_exists($filename)) {
        throw new Exception('Class "'.$className.'" not fount', 1);
    }

    require_once $filename;
});

/**
 * Main PhpGtk3 class.
 */
class PhpGtk3
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

    /**
     * Construtor.
     */
    private function __construct()
    {
        $final_header = PHPGTK3_PATH.'/gtk.h';

        // Verifica se precisa recompilar o header cache
        if (PHPGTK3_RECOMPILE_HEADERS) {
            unlink($final_header);
        }

        // Verifica se o header nao existe
        if (!file_exists($final_header)) {
            // Create def lib path
            $data = '#define FFI_LIB "'.GTK_LIB_PATH."\"\n\n";

            // Percorre os headers
            $files = scandir(PHPGTK3_PATH.'/headers');
            foreach ($files as $file) {
                if (!is_dir(PHPGTK3_PATH.'/headers/'.$file)) {
                    $data .= file_get_contents(PHPGTK3_PATH.'/headers/'.$file)."\n\n";
                }
            }

            // Cria o header cache final
            file_put_contents($final_header, $data);
        }

        // Carrega o header
        //$this->ffi = \FFI::load($final_header);
        $this->ffi = \FFI::cdef(file_get_contents($final_header), GTK_LIB_PATH);
    }

    /**
     * Singleton.
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getFFI()
    {
        $instance = self::getInstance();

        return $instance->ffi;
    }

    /**
     * Convert PHP string into char *.
     */
    public static function char_p(string $string)
    {
        $char = \FFI::new('char['.strlen($string).']');

        \FFI::memcpy($char, $string, strlen($string));

        return \FFI::cast('char *', $char);
    }
}
