<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    // Functions
    public function getConfig($key) {
        $config = Config::select('config_value')->where('config_key', $key)->first();
        return $config->config_value;
    }
}
