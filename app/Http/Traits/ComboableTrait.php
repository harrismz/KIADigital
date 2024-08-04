<?php
namespace App\Http\Traits;

Trait ComboableTrait {

    // protected $comboKey;

    public static function getComboKey() {
        return static::$comboKey;
    }

}