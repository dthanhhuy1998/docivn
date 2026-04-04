<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Services\Config\ConfigService;

class ConfigController extends Controller
{
    protected ConfigService $configService;

    public function __construct(
        ConfigService $configService
    ) {
        $this->configService = $configService;
    }

    public function getUpdate()
    {
        $configData = Config::pluck('config_value', 'config_key')->toArray();

        $headingTitle = heading(__('Config'));
        $pageTitle = __('Config');

        return view('admin.pages.config.update', compact(
            'headingTitle', 'pageTitle', 'configData'
        ));
    }

    public function postUpdate(Request $req) {
        $data = $req->except(['_token', '_wysihtml5_mode']);

        if (!$data) return abort(404);

        $this->configService->clearCache();

        $fileFields = ['favicon', 'logo', 'logo_footer', 'logo_tagline'];

        foreach($fileFields as $fileField) {
            $file = $req->file($fileField);
            
            if ($file) {
                if (!$file->isValid()) {
                    abort(422, 'Field '.$fileField.': '. $file->getErrorMessage());
                }

                $data[$fileField] = $this->configService->uploadFileFromRequest($req, $fileField);
            }
        }

        foreach($data as $key => $value) {
            Config::updateOrCreate(
                ['config_key' => $key],
                ['config_value' => $value]
            );
        }

        return redirect()->route('admin.system.config.getUpdate')->with('success_msg', __('Settings saved successfully'));
    }
}
