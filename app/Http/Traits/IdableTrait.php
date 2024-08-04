<?php
namespace App\Http\Traits;

Trait IdableTrait {
    
    public static function bootIdableTrait()
    {
        static::creating(function ($model) {
            $model->guid = $model->generateGuid();
        });
    }

    public function generateGuid(){
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
    }

}