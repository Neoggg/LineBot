<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit370a72a57c0ae9317aa3a828dd7bd201
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit370a72a57c0ae9317aa3a828dd7bd201::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit370a72a57c0ae9317aa3a828dd7bd201::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
