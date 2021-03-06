<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaa840dc933f6e395fb1351888ba1451c
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/MF',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaa840dc933f6e395fb1351888ba1451c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaa840dc933f6e395fb1351888ba1451c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaa840dc933f6e395fb1351888ba1451c::$classMap;

        }, null, ClassLoader::class);
    }
}
