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
            $favicon = asset('storage/app/'.$this->configModel->getConfig('favicon'));
            $codeHeader = $this->configModel->getConfig('code_header');

            $view->with([
                'favicon'       => $favicon,
                'code_header'   => $codeHeader
            ]);
        });

        View::composer('catalog.common.header', function ($view) {
            $categories = ProductCategory::where('status', 1)
            ->where('parent_id', 0)
            ->where('id', '<>', 1)
            ->orderBy('sort_order', 'asc')
            ->get();
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));

            if(!session()->exists('userLogin')) {
                $view->with([
                    'categories'    => $categories,
                    'logo'          => $logo
                ]);
            } else {
                $userLogin = Customer::select('firstname', 'lastname')->where('email', session()->get('userLogin'))->first();

                $view->with([
                    'userLogin'     => $userLogin,
                    'categories'    => $categories,
                    'logo'          => $logo
                ]);
            }
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
            $zalo = $this->configModel->getConfig('zalo');

            $view->with([
                'zalo'   => $zalo
            ]);
        });

        View::composer('catalog.common.footer', function ($view) {
            $contact = $this->configModel->getConfig('contact');
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $copyright = $this->configModel->getConfig('copyright');
            $phone = $this->configModel->getConfig('phone');
            // social
            $gmail = $this->configModel->getConfig('gmail');
            $facebook = $this->configModel->getConfig('facebook');
            $youtube = $this->configModel->getConfig('youtube');
            $zalo = $this->configModel->getConfig('zalo');
            $instagram = $this->configModel->getConfig('instagram');
            $tiktok = $this->configModel->getConfig('tiktok');
            $twitter = $this->configModel->getConfig('twitter');

            $ramdomUserOnline = $this->randomUserOnline();

            $view->with([
                'contact'           => $contact,
                'logo'              => $logo,
                'copyright'         => $copyright,
                'phone'             => $phone,
                'gmail'             => $gmail,
                'facebook'          => $facebook,
                'youtube'           => $youtube,
                'zalo'              => $zalo,
                'instagram'         => $instagram,
                'tiktok'            => $tiktok,
                'twitter'           => $twitter,
                'ramdomUserOnline'  => $ramdomUserOnline
            ]);
        });

        View::composer('catalog.common.foot', function ($view) {
            $codeFooter = $this->configModel->getConfig('code_footer');

            $view->with([
                'code_footer'   => $codeFooter
            ]);
        });

        // Admin
        View::composer('admin.common.head', function ($view) {
            $favicon = asset('storage/app/'.$this->configModel->getConfig('favicon'));

            $view->with([
                'favicon'   => $favicon
            ]);
        });
    }

    public function randomUserOnline() {
        $session = date('h:i A', strtotime(date('Y-m-d H:i:s')));
        $time = new \DateTime($session); 
        $data = substr($time->format('H:i'), 0, 2);
        
        $userOnline = 0;
        if($data < 24) {
            $userOnline = rand(100, 200);
        }
        if($data < 23) {
            $userOnline = rand(200, 750);
        }
        if($data < 11) {
            $userOnline = rand(100, 200);
        }

        return $userOnline;
    }
}
