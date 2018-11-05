<?php

require_once __DIR__.'/../../vendor/autoload.php';

define('DEBUG', true);
define('CONSOLE_DIR', __DIR__);

// 自动加载命名空间
spl_autoload_register(function ($class){
   $baseDir = CONSOLE_DIR.'/../';
   $file = $baseDir . str_replace('\\', '/', $class) . '.php';
   if (file_exists($file)) {
       include_once $file;
   }
});

