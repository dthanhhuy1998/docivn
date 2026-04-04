<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = ['config_key', 'config_value'];

    public $timestamps = false;

    // Functions
    public function getConfig($key) {
        $config = Config::select('config_value')->where('config_key', $key)->first();
        if(!$config) return '';

        return $config->config_value;
    }
}
