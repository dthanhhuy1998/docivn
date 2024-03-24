<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use URL;
use SEOMeta;
use OpenGraph;
use Cart;
use Session;
use \RecentlyViewed\Facades\RecentlyViewed;
use Mail;

// Models
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleToCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductToCategory;
use App\Models\ProductGroup;
use App\Models\ProductToGroup;
use App\Models\ProductDescription;
use App\Models\Customer;
use App\Models\CustomerReviews;
use App\Models\Slide;
use App\Models\Province;
use App\Models\ProductReviews;
use App\Models\Config;
use App\Models\Video;
use App\Models\Seller;
use App\Models\Image;
use App\Models\ImageDetail;

class CatalogController extends Controller
{
    protected $productCategoryModel = '';
    protected $productModel = '';
    protected $configModel = '';
    protected $articleModel = '';
    protected $videoModel = '';

    public function __construct() {
        $this->productCategoryModel = new ProductCategory();
        $this->productModel = new Product();
        $this->configModel = new Config();
        $this->articleModel = new Article();
        $this->videoModel = new Video();
    }

    public function homepage() {
        // access analytics
        $this->analyticsAccess();
        // online analytics
        $this->analyticsOnline();
        // product categories
        $pCategories = ProductCategory::where('status', 1)
        ->where('parent_id', 0)
        ->with(['subCategories' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])->where('id', '<>', 1)
        ->orderBy('sort_order', 'desc')
        ->get();

        // lasted posts
        $articles = $this->articleModel->getArticleByCategorySlug('tin-tuc', 3);
        // activity
        $activityPosts = $this->articleModel->getArticleByCategorySlug('hinh-anh-hoat-dong', 40);
        // slides
        $slides = Slide::orderBy('slide_sort_order', 'asc')->where('slide_type', 'slide')->where('slide_status', true)->get();
        $slideProducts = Slide::orderBy('slide_sort_order', 'asc')->where('slide_type', 'product')->where('slide_status', true)->get();
        // videos
        $videos = Video::where('status', 1)->orderBy('created_at', 'desc')->get();
        // lasted video active
        $lastedVideo = NULL;
        if($this->videoModel->getLastedVideo() != NULL) {
            $lastedVideo = pathResolution($this->videoModel->getLastedVideo()->youtube);
        }
        // images
        $albums = Image::where('image_status', 1)->orderBy('id', 'desc')->get();

        // SEO
        $title = $this->configModel->getConfig('meta_title');
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
        $this->seo_tools($title, $description, $keyword, $logo, URL::current());

        return view('catalog.pages.index',
            compact('pCategories', 'slides', 'slideProducts', 'logo', 'activityPosts', 'videos', 'lastedVideo', 'articles', 'albums')
        );
    }

    public function articles() {
        $articles = $articles = $this->articleModel->getArticleByCategorySlug('tin-tuc', 15);

        $categories = ArticleCategory::where('status', 1)->get();
        // SEO
        $pageTitle = 'Tất cả bài viết';
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));

        return view('catalog.pages.articles',
            compact('pageTitle', 'articles', 'categories')
        );
    }

    public function articleCategory($category_slug) {
        // get category id
        if(ArticleCategory::where('slug', $category_slug)->exists()) {
            $category = ArticleCategory::where('slug', $category_slug)->first();

            // get articles
            $parentCate = ArticleCategory::select('id')->where('slug', $category_slug)->first();
            $childCate = ArticleCategory::select('id')->where('parent_id', $parentCate->id)->get();
            $cateArr = array($parentCate->id);
            if(count($childCate) > 0) {
                foreach($childCate as $child) {
                    array_push($cateArr, $child->id);
                }
            }
            $articles = DB::table('article_to_category as atc')
            ->select('a.id as post_id', 'a.title as post_title', 'a.summary as post_summary', 'a.slug as post_slug', 'a.image as post_image', 'ac.slug as category_slug', 'a.created_at as post_created_at')
            ->join('article as a', 'atc.article_id', '=', 'a.id')
            ->join('article_category as ac', 'atc.category_id', '=', 'ac.id')
            ->whereIn('category_id', $cateArr)
            ->where('a.status', 1)
            ->orderBy('a.created_at', 'desc')
            ->paginate(15);

            $pageTitle = $category->name;

            // SEO
            $image = (!empty($category->image)) ? asset('storage/app/' . $category->image) : asset('storage/app/uploads/default.png');
            $seo = new Controller();
            $seo->seo_tools(
                $category->meta_title,
                $category->meta_description,
                $category->meta_keyword,
                $image,
                URL::current()
            );

            return view('catalog.pages.article-category',
                compact('pageTitle', 'articles')
            );
        } else {
            return abort('404');
        }
    }

    public function article($category_slug, $slug) {
        if(Article::where('slug', $slug)->exists()) {
            $article = Article::where('slug', $slug)->first();
            // update view
            DB::table('article')
            ->where('id', $article->id)
            ->update(['view' => $article->view + 1]);
            // related posts
            $parentCate = DB::table('article_to_category')->select('category_id')->where('article_id', $article->id)->first();
            $childCate = DB::table('article_category')->select('id')->where('parent_id', $parentCate->category_id)->get();
            $cateArr = array($parentCate->category_id);
            if(count($childCate) > 0) {
                foreach($childCate as $child) {
                    array_push($cateArr, $child->id);
                }
            }
            $relatedPosts = DB::table('article_to_category as atc')
            ->select('a.id as post_id', 'a.title as post_title', 'a.summary as post_summary', 'a.slug as post_slug', 'a.image as post_image', 'ac.slug as category_slug', 'a.created_at as post_created_at')
            ->join('article as a', 'atc.article_id', '=', 'a.id')
            ->join('article_category as ac', 'atc.category_id', '=', 'ac.id')
            ->where('a.id', '<>', $article->id)
            ->whereIn('category_id', $cateArr)
            ->orderBy('a.created_at', 'desc')
            ->take(5)
            ->get();

            // SEO
            $image = (!empty($article->image)) ? asset('storage/app/' . $article->image) : asset('storage/app/uploads/default.png');
            $seo = new Controller();
            $seo->seo_tools(
                $article->meta_title,
                $article->meta_description,
                $article->meta_keyword,
                $image,
                URL::current()
            );

            return view('catalog.pages.article',
                compact('article', 'relatedPosts')
            );
        } else {
            return abort(404);
        }
    }

    public function products() {
        $prdCates = ProductCategory::where('id', '<>', 1)->orderBy('sort_order', 'asc')->get();
        // SEO
        $pageTitle = 'Sản phẩm';
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
        $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());

        return view('catalog.pages.products',
            compact('pageTitle', 'prdCates')
        );
    }

    public function productCategory($category_slug) {
        if(ProductCategory::where('slug', $category_slug)->exists()) {
            // get category by slug
            $category = ProductCategory::where('slug', $category_slug)->first();
            // get all category
            $categories = $this->productCategoryModel->categories($category->id);
            // get sort in url
            $sort = '';
            $sortURL = '';
            if(isset($_GET['sort']) && isset($_GET['sort'])) {
                $sort = $_GET['sort'];
                $sortURL = '?sort='.$_GET['sort'];
            }
            // get products
            switch($sort) {
                case 'postdesc':
                    $products = $this->productModel->getProductByCategoryId($categories, 'created_at', 'desc', 25);
                    break;
                case 'postasc':
                    $products = $this->productModel->getProductByCategoryId($categories, 'created_at', 'asc', 25);
                    break;
                case 'pricedesc':
                    $products = $this->productModel->getProductByCategoryId($categories, 'price', 'desc', 25);
                    break;
                case 'priceasc':
                    $products = $this->productModel->getProductByCategoryId($categories, 'price', 'asc', 25);
                    break;
                default:
                    $products = $this->productModel->getProductByCategoryId($categories, 'created_at', 'asc', 25);
                    break;
            }
            $products->withPath($category_slug.$sortURL);

            // SEO
            $pageTitle = $category->name;
            $image = (!empty($category->image)) ? asset('storage/app/' .$category->image) : asset('storage/app/uploads/default.png');
            $seo = new Controller();
            $seo->seo_tools(
                $category->meta_title,
                $category->meta_description,
                $category->meta_keyword,
                $image,
                URL::current()
            );
            return view('catalog.pages.product-category',
                compact('pageTitle', 'category', 'sort', 'products')
            );
        } else {
            return abort(404);
        }
    }

    public function product($category_slug, $slug) {
        if($productDescription = ProductDescription::where('slug', $slug)->exists()) {
            // get product
            $productDescription = ProductDescription::where('slug', $slug)->first();
            // update view
            $product = Product::where('id', $productDescription->product_id)->first();

            DB::table('product')
            ->where('id', $product->id)
            ->update(['viewed' => $product->viewed + 1]);
            // related products
            $ptc = ProductToCategory::select('category_id')->where('product_id', $product->id)->first();
            $categories = $this->productCategoryModel->categories($ptc->category_id);
            $relatedProducts = $this->productModel->getProductByCategoryIdRandom($categories, 4);
            // viewed products
            RecentlyViewed::add($product);
            $recentlyVieweds = RecentlyViewed::get(Product::class);
            // contact
            $phone = $this->configModel->getConfig('phone');

            // SEO
            $image = (!empty($productDescription->product->image)) ? asset('storage/app/' . $productDescription->product->image) : asset('storage/app/uploads/default.png');
            $seo = new Controller();
            $seo->seo_tools(
                $productDescription->meta_title,
                $productDescription->meta_description,
                $productDescription->meta_keyword,
                $image,
                URL::current()
            );

            return view('catalog.pages.product',
                compact(
                    'productDescription', 
                    'relatedProducts',
                    'recentlyVieweds',
                    'phone',
                )
            );
        } else {
            return abort(404);
        }
    }

    public function getProductByGroup($slug) {
        $group = ProductGroup::where('slug', $slug)->first();

        $groupPivot = ProductToGroup::with(['product' => function ($query) {
            $query->where('status', 1);
        }])
        ->where('group_id', $group->id)
        ->paginate(20);

        $pageTitle = $group->name;
        // SEO
        $image = (!empty($group->image)) ? asset('storage/app/' . $group->image) : asset('storage/app/uploads/default.png');
        $seo = new Controller();
        $seo->seo_tools(
            $group->meta_title,
            $group->meta_description,
            $group->meta_keyword,
            $image,
            URL::current()
        );

        return view('catalog.pages.product-group',
            compact('pageTitle', 'groupPivot')
        );
    }

    public function search() {
        if(isset($_GET['tukhoa']) && $_GET['tukhoa'] != '') {
            $key = $_GET['tukhoa'];
            $products = DB::table('product_description as pd')
            ->where('name', 'like', '%'.$key.'%')
            ->where('p.display', 1)
            ->select('p.id as product_id', 'pd.name as pd_name', 'pd.slug as pd_slug', 'p.original_price as p_o_price', 'p.price as p_price', 'p.image as image')
            ->join('product as p', 'pd.product_id', '=', 'p.id')
            ->orderBy('pd.name', 'asc')
            ->paginate(15);

            $products->withPath('tim-kiem');

            $pageTitle = 'Tìm kiếm';
            $description = $this->configModel->getConfig('meta_description');
            $keyword = $this->configModel->getConfig('meta_keyword');
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());

            return view('catalog.pages.search',
                compact('pageTitle', 'products')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function quickSearch(Request $request) {
        $key = $request->keySearch;
        $products = DB::table('product_description as pd')
        ->where('slug', 'like', '%'.$key.'%')
        ->where('p.display', 1)
        ->select('p.id as product_id', 'pd.name as pd_name', 'pd.slug as pd_slug', 'p.original_price as p_o_price', 'p.price as p_price', 'p.image as image')
        ->join('product as p', 'pd.product_id', '=', 'p.id')
        ->orderBy('pd.name', 'asc')
        ->take(15)
        ->get();

        if(count($products) > 0) {
            $data = array();
            foreach($products as $product) {
                $ptc = ProductToCategory::select('category_id')->where('product_id', $product->product_id)->first();
                $category = ProductCategory::select('slug')->where('id', $ptc->category_id)->first();

                $prd = array(
                    'prd_id'        => $product->product_id,
                    'prd_name'      => $product->pd_name,
                    'prd_o_price'   => $product->p_o_price,
                    'prd_price'     => $product->p_price,
                    'wishlist'      => 0,
                    'review'        => 5,
                    'prd_image'     => (!empty($product->image)) ? asset('storage/app/'.$product->image) : asset('storage/app/uploads/default.png'),
                    'redirect'      => route('catalog.product', [$category->slug, $product->pd_slug]),
                );
                
                array_push($data, $prd);
            }

            return response()->json([
                'status'    => 200,
                'message'   => 'success',
                'data'      => $data
            ]);
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'Không tìm thấy sản phẩm cần tìm',
            ]);
        }
    }
    
    public function gallery($id) {
        $album = Image::where('id', $id)->first();
        $images = ImageDetail::where('image_id', $id)->orderBy('image_sort', 'asc')->get();

        // SEO
        $pageTitle = 'Album: ' . $album->image_name;
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
        $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());

        return view('catalog.pages.gallery',
            compact('pageTitle', 'album', 'images')
        );
    }

    public function getClientLogin() {
        // SEO
        SEOMeta::setTitle('Đăng nhập tài khoản');
        $pageTitle = 'Đăng nhập tài khoản';

        return view('catalog.pages.login',
            compact('pageTitle')
        );
    }

    public function postClientLogin(Request $request) {
        $validated = $request->validate([
            'userLogin'     => 'required||max:100',
            'passwordLogin' => 'required|min:6|max:32',
        ],[
            'userLogin.required'        => 'Email không được bỏ trống!',
            'userLogin.max'             => 'Email tối đa 100 ký tự!',
            'passwordLogin.required'    => 'Mật khẩu không được bỏ trống!',
            'passwordLogin.min'         => 'Mật khẩu ít nhất từ 6 ký tự!',
            'passwordLogin.max'         => 'Mật khẩu tối đã 32 ký tự!',
        ]);

        $checkUserLogin = Customer::where('email', trim($request->userLogin))
        ->where('status', 1)
        ->first();

        if($checkUserLogin) {
            if(Hash::check($request->passwordLogin, $checkUserLogin->password)) {
                // create session user login info
                $request->session()->put('userLogin', $request->userLogin);
                $request->session()->put('nameUserLogin', $checkUserLogin->lastname . ' ' . $checkUserLogin->firstname);
                // set link redirect
                $route = route('client.index');
                if($request->redirect == 'order') {
                    $route = route('catalog.cart.getOrder');
                }

                // redirect to home page
                return response()->json([
                    'status'    => 200,
                    'message'   => 'success',
                    'route'     => $route
                ]);
            } else {
                return response()->json([
                    'status'    => 'E0',
                    'message'   => 'Mật khẩu không đúng!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'Email chưa được đăng ký!',
            ]);
        }
    }

    public function getClientRegister() {
        // SEO
        SEOMeta::setTitle('Đăng ký tài khoản');
        $pageTitle = 'Đăng ký tài khoản';

        return view('catalog.pages.register',
            compact('pageTitle')
        );
    }

    public function postClientRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'tentaikhoan'       => 'required|min:3|max:100',
            'emaildangnhap'     => 'required|min:3|max:150|unique:customer,email',
            'sdt'               => 'required|min:10|max:12',
            'matkhau'           => 'required|min:6|max:32',
            'replymatkhau'      => 'same:matkhau',
        ],[
            'tentaikhoan.required'      => 'Tên của bạn không được bỏ trống!',
            'tentaikhoan.min'           => 'Tên không hợp lệ (tối thiểu từ 3 ký tự)!',
            'tentaikhoan.max'           => 'Tên của bạn quá dài (tối đa 100 ký tự)!',
            'emaildangnhap.required'    => 'Email không được bỏ trống!',
            'emaildangnhap.min'         => 'Email của bạn quá ngắn (tối thiểu từ 3 ký tự)!',
            'emaildangnhap.max'         => 'Email của bạn quá dài (tối thiểu từ 150 ký tự)!',
            'emaildangnhap.unique'      => 'Email đã được đăng ký. Vui lòng chọn email khác!',
            'sdt.required'              => 'Số điện thoại không được bỏ trống!',
            'sdt.min'                   => 'Số điện thoại không hợp lệ!',
            'sdt.max'                   => 'Số điện thoại không hợp lệ!',
            'matkhau.required'          => 'Mật khẩu không được bỏ trống!',
            'matkhau.min'               => 'Mật khẩu ít nhất từ 6 ký tự!',
            'matkhau.max'               => 'Mật khẩu tối đã 20 ký tự!',
            'replymatkhau.same'         => 'Mật khẩu không giống nhau!',
        ]);

        if(!$validator->fails()) {
            DB::table('customer')->insert([
                'email'          => ($request->emaildangnhap),
                'password'       => Hash::make(trim($request->matkhau)),
                'show_password'  => trim($request->matkhau),
                'firstname'      => trim($request->tentaikhoan),
                'lastname'       => '',
                'telephone'      => trim($request->sdt),
                'newsletter'     => 1,
                'address_id'     => 0,
                'address'        => trim($request->diachi),
                'status'         => 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            $request->session()->put('userLogin', trim($request->emaildangnhap));

            return response()->json([
                'status'    => 200,
                'message'   => 'Đăng ký tài khoản thành công',
                'route'     => route('client.index')
            ]);
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'Thiếu thông tin hoặc không hợp lệ!',
                'errors'    => $validator->errors()->toArray(),
            ]);
        }
    }

    public function getClientLogout() {
        if (session()->exists('userLogin') || session()->exists('nameUserLogin')) {
            // destroy session user login
            session()->forget(['userLogin', 'nameUserLogin']);

            // redirect to homepage
            return redirect()->route('catalog.homepage');
        }
    }

    public function payment() {
        if (session()->has('userLogin')) {
            $cart = Cart::content();
            $cartPriceTotal = Cart::priceTotal();

            // SEO
            SEOMeta::setTitle('Thanh toán đơn hàng');
            $pageTitle = 'Thanh toán đơn hàng';

            return view('catalog.pages.payment',
                compact('pageTitle', 'cart', 'cartPriceTotal')
            );
        } else {
            return redirect()->route('catalog.clientLogin')->with('error_msg', 'Bạn phải đăng nhập mới có thể thanh toán đơn hàng');
        }
    }

    public function setSessionInstallment(Request $request) {
        // setup product id for tra_gop session
        session()->put('tra_gop', $request->productId);

        return response()->json([
            'status'    => 200,
            'message'   => 'success',
            'url'       => route('catalog.installment')
        ]);
    }

    public function installment() {

        if(session()->has('tra_gop')) {
            $product = Product::findOrFail(session()->get('tra_gop'));

            $provinces = Province::orderBy('name', 'asc')->get();

            return view('catalog.pages.tra_gop',
                compact('product', 'provinces')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function tienGopThang(Request $request) {
        $product = Product::findOrFail(session()->get('tra_gop'));

        $htmlData = '
        <thead>
            <tr>
                <td class="row-head">Gói trả góp</td>
                <td><strong>6 tháng (Lãi 0%)</strong></td>
                <td><strong>9 tháng</strong></td>
                <td><strong>12 tháng</strong></td>
                <td><strong>18 tháng</strong></td>
            </tr>
        </thead>';

        $htmlData .= '
        <tbody>
            <tr>
                <td class="row-head">Gói sản phẩm</td>
                <td class="text-red">'.number_format($product->price).' đ</td>
                <td class="text-red">'.number_format($product->price).' đ</td>
                <td class="text-red">'.number_format($product->price).' đ</td>
                <td class="text-red">'.number_format($product->price).' đ</td>
            </tr>
            <tr>
                <td class="row-head">Trả trước</td>
                <td class="text-red">'.number_format(tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format(tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format(tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format(tra_truoc($product->price, $request->percent)).' đ</td>
            </tr>
            <tr>
                <td class="row-head">Số tiền vay</td>
                <td class="text-red">'.number_format(so_tien_vay($product->price, tra_truoc($product->price, $request->percent))).' đ</td>
                <td class="text-red">'.number_format(so_tien_vay($product->price, tra_truoc($product->price, $request->percent))).' đ</td>
                <td class="text-red">'.number_format(so_tien_vay($product->price, tra_truoc($product->price, $request->percent))).' đ</td>
                <td class="text-red">'.number_format(so_tien_vay($product->price, tra_truoc($product->price, $request->percent))).' đ</td>
            </tr>
            <tr>
                <td class="row-head">Góp mỗi tháng</td>
                <td class="text-red">'.number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 6)).' đ</td>
                <td class="text-red">'.number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 9)).' đ</td>
                <td class="text-red">'.number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 12)).' đ</td>
                <td class="text-red">'.number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 18)).' đ</td>
            </tr>
            <tr>
                <td class="row-head">Chênh lệch với giá mua thẳng</td>
                <td>'.number_format((((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 6)*6) + tra_truoc($product->price, $request->percent)) - $product->price) + (so_tien_vay($product->price, tra_truoc($product->price, $request->percent))*0.085)).' đ</td>
                <td>'.number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 9)*9) + tra_truoc($product->price, $request->percent)) - $product->price).' đ</td>
                <td>'.number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 12)*12) + tra_truoc($product->price, $request->percent)) - $product->price).' đ</td>
                <td>'.number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 18)*18) + tra_truoc($product->price, $request->percent)) - $product->price).' đ</td>
            </tr>
            <tr>
                <td class="row-head">Giá sản phẩm khi mua trả góp</td>
                <td class="text-red">'.number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 6)*6) + tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 9)*9) + tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 12)*12) + tra_truoc($product->price, $request->percent)).' đ</td>
                <td class="text-red">'.number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, $request->percent)), 18)*18) + tra_truoc($product->price, $request->percent)).' đ</td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="choose-bank" data="'.$request->percent.',6">CHỌN MUA</button></td>
                <td><button type="submit" class="choose-bank" data="'.$request->percent.',9">CHỌN MUA</button></td>
                <td><button type="submit" class="choose-bank" data="'.$request->percent.',12">CHỌN MUA</button></td>
                <td><button type="submit" class="choose-bank" data="'.$request->percent.',18">CHỌN MUA</button></td>
            </tr>
        </tbody>
        <div class="overlay">
            <img src="'. asset('public/catalog/assets/img/refresh.gif') .'" alt="Refresh">
        </div>
        ';

        return response()->json([
            'status'    => 200,
            'message'   => 'success',
            'data'      => $htmlData
        ]);
    }

    public function postTraGop(Request $request) {
        if(!empty($request->tra_gop)) {
            $explore = explode(',', $request->tra_gop);
            $percent = $explore[0];
            $month = $explore[1];
        } else {
            $percent = '';
            $month = '';
        }

        DB::table('tra_gop')->insert([
            'p_name'            => $request->p_name,
            'p_image'           => $request->p_image,
            'customer_name'     => $request->name,
            'customer_card_id'  => $request->card_id,
            'customer_phone'    => $request->phone,
            'customer_email'    => $request->email,
            'province_id'       => $request->province,
            'percent'           => $percent,
            'month'             => $month,
            'note'              => $request->note,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'success'
        ]);
    }

    public function sendComment(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'phone'     => 'required|min:10|max:12',
            'content'   => 'required',
        ],[
            'name.required'     => 'Vui lòng nhập họ tên của bạn!',
            'phone.required'    => 'Nhập số điện thoại của bạn!',
            'phone.min'         => 'Số điện thoại không hợp lệ!',
            'phone.max'         => 'Số điện thoại không hợp lệ!',
            'content.reuqired'  => 'Nhập nội dung góp ý của bạn!'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'E1',
                'message'   => $validator->errors()->toArray(),
            ]);
        } else {
            $excute = DB::table('comments')->insert([
                'customer_name' => trim($request->name),
                'phone'         => trim($request->phone),
                'content'       => trim($request->content),
                'status'        => false,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);;

            if($excute) {
                $lasted = DB::table('comments')->latest()->first();
                
                // send mail
                $mailData = [
                    'name'          => $lasted->customer_name,
                    'phoneNumber'   => $lasted->phone,
                    'content'       => $lasted->content,
                ];
                $user['to'] = $this->configModel->getConfig('mail_receive_feedback');
                Mail::send('catalog.pages.mail.feedback', $mailData, function($message) use ($user) {
                    $message->to($user['to']);
                    $message->subject('Bạn vừa nhận được 1 đóng góp ý kiến từ website '. request()->getHttpHost());
                });
                
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Gửi biểu mẫu thành công. Cám ơn bạn đã góp ý'
                ]);
            } else {
                return response()->json([
                    'status'    => 'E0',
                    'message'   => 'error'
                ]);
            } 
        }
        
    }

    public function getSeller() {
        if(isset($_GET['sdt']) && !empty($_GET['sdt'])) {
            $sdt = $_GET['sdt'];
            if(Seller::where('SoDienThoai', $sdt)->exists()) {
                $seller = Seller::where('SoDienThoai', $sdt)->first();
                // SEO
                $pageTitle = 'Seller '.$seller->TenSeller;
                $description = $this->configModel->getConfig('meta_description');
                $keyword = $this->configModel->getConfig('meta_keyword');
                $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
                $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());

                return view('catalog.pages.seller',
                    compact('pageTitle', 'seller')
                );
            } else {
                echo '<script>
                        alert("Không tìm thấy seller, vui lòng nhập lại số điện thoại!");
                        location.href="'.route('catalog.homepage').'"
                    </script>';
            }
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    // Helpers
    public function analyticsOnline() {
        $tg = time();
        $tgout = 900; //15 phút
        $tgnew = $tg - $tgout; // sau 15 phút không làm gì sẽ không tính là online
        $ip = $_SERVER['REMOTE_ADDR'];
        $local = $_SERVER['HTTP_HOST'];

        DB::table('useronline')->insert([
            'tgtmp'         => $tg,
            'ip'            => $ip,
            'local'         => $local,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('useronline')->where('tgtmp', '<', $tgnew)->delete();

        // $sql = "SELECT DISTINCT ip FROM useronline";
        // $query = mysqli_query(connectDB(), $sql);
        // $user = mysqli_num_rows($query);
        // $num_user = number_format($user);
        // $online =  $num_user * 2;
    }

    public function analyticsAccess() {
        //Kiểm tra xem IP có phải là từ Share Internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //Kiểm tra xem IP có phải là từ Proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //Kiểm tra xem IP có phải là từ Remote Address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        DB::table('truycap')->insert([
            'ip_address' => $ip_address,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
