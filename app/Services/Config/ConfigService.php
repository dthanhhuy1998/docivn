<?php

namespace App\Services\Config;

use Illuminate\Http\Request;
use Storage;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;

class ConfigService {
    public function getAllConfigs(): array
    {
        return Cache::remember('site_configs', 3600, function () {
            return Config::query()
                ->pluck('config_value', 'config_key')
                ->toArray();
        });
    }

    public function get(string $key, $default = null)
    {
        $configs = $this->getAllConfigs();
        return $configs[$key] ?? $default;
    }

    public function clearCache(): void
    {
        Cache::forget('site_configs');
    }

    public function uploadFileFromRequest(Request $req, $fieldName) {
        $urlFile = [];
        $file = $req->file($fieldName);

        if($file) {
            $fileConfigUrl = Config::where('config_key', $fieldName)->first();
            if ($fileConfigUrl) Storage::disk('public')->delete($fileConfigUrl->config_value);

            $urlFile[] = Storage::disk('public')->putFile('uploads/config/'. $fieldName, $file);
        }

        return $urlFile[0];
    }
}