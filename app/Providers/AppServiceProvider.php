<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

// Models
use App\Models\ProductCategory;
use App\Models\ArticleCategory;
use App\Models\ProductGroup;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\Config;
use App\Services\Config\ConfigService;
use App\Helpers\AnalyticsHelper;

class AppServiceProvider extends ServiceProvider
{
    protected $configModel = '';

    public function __construct() {
        $this->configModel = new Config();
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        // Catalog
        View::composer('catalog.common.head', function ($view) {
            $configService = app(ConfigService::class);

            $view->with([
                'siteConfig' => $configService->getAllConfigs(),
            ]);
        });

        View::composer('catalog.common.header', function ($view) {
            $categories = ProductCategory::where('status', 1)
                ->where('parent_id', 0)
                ->where('id', '<>', 1)
                ->orderBy('sort_order', 'asc')
                ->get();

            $configService = app(ConfigService::class);
            $logo = $configService->get('logo') ? 'public/storage/' .$configService->get('logo') : 'public/images/no-image.png';
            $logoTagLine = $configService->get('logo_tagline') ? 'public/storage/' .$configService->get('logo_tagline') : 'public/images/no-image.png';

            $userLogin = Customer::select('firstname', 'lastname')->where('email', session()->get('userLogin'))->first();

            $view->with([
                'categories'    => $categories,
                'logo'          => $logo,
                'logoTagLine'   => $logoTagLine,
                'userLogin'     => $userLogin
            ]);
        });

        View::composer('catalog.common.sidebar', function ($view) {
            $categories = ProductCategory::where('status', 1)
            ->where('parent_id', 0)
            ->where('id', '<>', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

            $view->with([
                'categories' => $categories
            ]);
        });

        View::composer('catalog.common.cart', function ($view) {
            $configService = app(ConfigService::class);
            $zalo = $configService->get('zalo') ?? '';

            $view->with([
                'zalo'   => $zalo
            ]);
        });

        View::composer('catalog.common.footer', function ($view) {
            $configService = app(ConfigService::class);
            $siteConfig = $configService->getAllConfigs();

            $view->with([
                'siteConfig'        => $siteConfig,
                'ramdomUserOnline'  => AnalyticsHelper::randomUserOnline(),
                'siteConfig'        => $siteConfig
            ]);
        });

        View::composer('catalog.common.foot', function ($view) {
            $configService = app(ConfigService::class);
            $codeFooter = $configService->get('code_footer');

            $view->with([
                'code_footer' => $codeFooter
            ]);
        });

        // Admin
        View::composer('admin.common.head', function ($view) {
            $configService = app(ConfigService::class);
            $favicon = $configService->get('favicon') ? asset('public/storage/' .$configService->get('favicon')) : 'public/images/no-image.png';

            $view->with([
                'favicon'   => $favicon
            ]);
        });
    }
}
