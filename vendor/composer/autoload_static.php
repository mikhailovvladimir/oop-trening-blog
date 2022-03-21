<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd8539407a119e15b60276d58661aada3
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mikhailov\\Myproject\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mikhailov\\Myproject\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd8539407a119e15b60276d58661aada3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd8539407a119e15b60276d58661aada3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd8539407a119e15b60276d58661aada3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd8539407a119e15b60276d58661aada3::$classMap;

        }, null, ClassLoader::class);
    }
}
