<?php

use Illuminate\Support\Facades\Route;

// ================ Controller Class ================ //
use App\Http\Controllers\TestController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SlideProductController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TraGopController;
use App\Http\Controllers\ProductReviewsController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ImageController;

// ================ Catalog Route ================ //
Route::get(
    '/',
    [CatalogController::class, 'homepage']
)->name('catalog.homepage');

// Route::get(
//     'bai-viet',
//     [CatalogController::class, 'articles']
// )->name('catalog.articles');

// Route::get(
//     'bai-viet/{category_slug}',
//     [CatalogController::class, 'articleCategory']
// )->name('catalog.articleCategory');

// Route::get(
//     'bai-viet/{category_slug}/{post_slug}',
//     [CatalogController::class, 'article']
// )->name('catalog.article');

// Route::get(
//     'san-pham',
//     [CatalogController::class, 'products']
// )->name('catalog.products');

// Route::get(
//     'san-pham/{category_slug}',
//     [CatalogController::class, 'productCategory']
// )->name('catalog.productCategory');

// Route::get(
//     'san-pham/{category_slug}/{product_slug}',
//     [CatalogController::class, 'product']
// )->name('catalog.product');

// Route::get(
//     'loai/{slug}',
//     [CatalogController::class, 'getProductByGroup']
// )->name('catalog.product.getProductByGroup');

// Route::get('tim-kiem', [CatalogController::class, 'search'])->name('catalog.search');
// Route::post('quick_search', [CatalogController::class, 'quickSearch'])->name('catalog.quickSearch');

// Route::get(
//     'gallery/{id}',
//     [CatalogController::class, 'gallery']
// )->name('catalog.gallery');

// // Route::post(
// //     'set-session-installment',
// //     [CatalogController::class, 'setSessionInstallment']
// // )->name('catalog.setSessionInstallment');

// // Route::get(
// //     'tra-gop',
// //     [CatalogController::class, 'installment']
// // )->name('catalog.installment');

// // Route::post(
// //     'tien-gop-thang',
// //     [CatalogController::class, 'tienGopThang']
// // )->name('catalog.tienGopThang');

// // Route::post(
// //     'post-tra-gop',
// //     [CatalogController::class, 'postTraGop']
// // )->name('catalog.postTraGop');

// Route::post('send_comment', [CatalogController::class, 'sendComment'])->name('catalog.sendComment');
// Route::get('seller', [CatalogController::class, 'getSeller'])->name('catalog.getSeller');

// // ================ Client Account Route ================ //
// Route::get(
//     'dang-nhap',
//     [CatalogController::class, 'getClientLogin']
// )->name('catalog.clientLogin');

// Route::post(
//     'login-user',
//     [CatalogController::class, 'postClientLogin']
// )->name('catalog.postClientLogin');

// Route::get(
//     'dang-ky',
//     [CatalogController::class, 'getClientRegister']
// )->name('catalog.getClientRegister');

// Route::post(
//     'register',
//     [CatalogController::class, 'postClientRegister']
// )->name('catalog.postClientRegister');

// Route::get(
//     'dang-xuat',
//     [CatalogController::class, 'getClientLogout']
// )->name('catalog.getClientLogout');

// Route::prefix('tai-khoan')->middleware('userLogin')->group(function () {
//     Route::get(
//         'thong-tin',
//         [ClientController::class, 'index']
//     )->name('client.index');

//     Route::post(
//         'edit-info',
//         [ClientController::class, 'postEditInfo']
//     )->name('client.postEditInfo');

//     Route::get(
//         'doi-mat-khau',
//         [ClientController::class, 'getResetPassword']
//     )->name('client.getResetPassword');

//     Route::post(
//         'reset-password',
//         [ClientController::class, 'postResetPassword']
//     )->name('client.postResetPassword');

//     Route::get('don-hang', [ClientController::class, 'getInvoice'])->name('client.getInvoice');
//     Route::prefix('don-hang')->group(function () {
//         Route::get('chi-tiet/{invoiceId}', [ClientController::class, 'getInvoiceDetail'])->name('client.getInvoiceDetail');
//         Route::post('cancel_invoice', [ClientController::class, 'postCancelInvoice'])->name('client.postCancelInvoice');
//     });
    
//     Route::get(
//         'dia-chi',
//         [ClientController::class, 'getAddress']
//     )->name('client.getAddress');

//     Route::prefix('address')->group(function () {
//         Route::post(
//             'list',
//             [ClientController::class, 'addressList']
//         )->name('client.addressList');

//         Route::post(
//             'add',
//             [ClientController::class, 'addAddress']
//         )->name('client.addAddress');

//         Route::get(
//             'edit/{addressId}',
//             [ClientController::class, 'getEdit']
//         )->name('client.address.getEdit');

//         Route::post(
//             'edit',
//             [ClientController::class, 'postEditAddress']
//         )->name('client.address.postEditAddress');

//         Route::post(
//             'delete',
//             [ClientController::class, 'deleteAddress']
//         )->name('client.deleteAddress');
//     });
// });

// Route::get('gio-hang',[CartController::class, 'getCartList'])->name('catalog.cart.getCartList');
// Route::prefix('gio-hang')->group(function () {
//     Route::post('cart', [CartController::class, 'postCart'])->name('catalog.cart.postCart');
//     Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('catalog.cart.addToCart');
//     Route::get('destroy', [CartController::class, 'getCartDestroy'])->name('catalog.cart.getCartDestroy');
//     Route::post('remove', [CartController::class, 'getCartRemove'])->name('catalog.cart.getCartRemove');
//     Route::post('update-cart', [CartController::class, 'postUpdateCart'])->name('catalog.cart.postUpdateCart');
//     Route::post('add_to_cart_option', [CartController::class, 'addToCartOption'])->name('catalog.cart.addToCartOption');
// });
// Route::get('dat-hang', [CartController::class, 'getOrder'])->name('catalog.cart.getOrder');
// Route::post('order', [CartController::class, 'order'])->name('catalog.cart.order');

// // ================ Admin Route ================ //
Route::get(
    'auth',
    [UserController::class, 'getAdminLogin']
)->middleware('autoLogin')->name('getAdminLogin');

Route::post(
    'login',
    [UserController::class, 'postAdminLogin']
)->name('postAdminLogin');

Route::prefix('admin')->middleware('auth')->group(function () {
    // Logout
    Route::get('logout', [UserController::class, 'logout'])->name('admin.logout');

    Route::get('index', [IndexController::class, 'index'])->name('admin.index');

    Route::prefix('system')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get(
                'list',
                [UserController::class, 'getList']
            )->name('admin.user.getList');

            Route::get(
                'add',
                [UserController::class, 'getAdd']
            )->name('admin.user.getAdd');

            Route::post(
                'add',
                [UserController::class, 'postAdd']
            )->name('admin.user.postAdd');

            Route::get(
                'edit/{user_id}',
                [UserController::class, 'getEdit']
            )->name('admin.user.getEdit');

            Route::post(
                'edit',
                [UserController::class, 'postEdit']
            )->name('admin.user.postEdit');

            Route::get(
                'delete/{user_id}',
                [UserController::class, 'getDelete']
            )->name('admin.user.getDelete');

            Route::get(
                'reset-pass/{user_id}',
                [UserController::class, 'getResetPass']
            )->name('admin.user.getResetPass');

            Route::post(
                'reset-pass',
                [UserController::class, 'postResetPass']
            )->name('admin.user.postResetPass');
        });
        Route::prefix('config')->group(function () {
            Route::get('update', [ConfigController::class, 'getUpdate'])->name('admin.system.config.getUpdate');
            Route::post('update', [ConfigController::class, 'postUpdate'])->name('admin.system.config.postUpdate');
        });
    });

    Route::prefix('article')->group(function () {
        Route::get(
            'list',
            [ArticleController::class, 'getList']
        )->name('admin.article.getList');

        Route::get(
            'add',
            [ArticleController::class, 'getAdd']
        )->name('admin.article.getAdd');

        Route::post(
            'add',
            [ArticleController::class, 'postAdd']
        )->name('admin.article.postAdd');

        Route::get(
            'edit/{article_id}',
            [ArticleController::class, 'getEdit']
        )->name('admin.article.getEdit');

        Route::post(
            'edit',
            [ArticleController::class, 'postEdit']
        )->name('admin.article.postEdit');

        Route::get(
            'delete/{article_id}',
            [ArticleController::class, 'getDelete']
        )->name('admin.article.getDelete');

        // Category
        Route::prefix('category')->group(function () {
            Route::get(
                'list',
                [ArticleCategoryController::class, 'getList']
            )->name('admin.article.category.getList');

            Route::get(
                'add',
                [ArticleCategoryController::class, 'getAdd']
            )->name('admin.article.category.getAdd');

            Route::post(
                'add',
                [ArticleCategoryController::class, 'postAdd']
            )->name('admin.article.category.postAdd');

            Route::get(
                'edit/{article_category_id}',
                [ArticleCategoryController::class, 'getEdit']
            )->name('admin.article.category.getEdit');

            Route::post(
                'edit',
                [ArticleCategoryController::class, 'postEdit']
            )->name('admin.article.category.postEdit');

            Route::get(
                'delete/{article_category_id}',
                [ArticleCategoryController::class, 'getDelete']
            )->name('admin.article.category.getDelete');
        });
    });

    Route::prefix('product')->group(function () {
        Route::get(
            'list',
            [ProductController::class, 'getList']
        )->name('admin.product.getList');

        Route::get(
            'add',
            [ProductController::class, 'getAdd']
        )->name('admin.product.getAdd');

        Route::post(
            'add',
            [ProductController::class, 'postAdd']
        )->name('admin.product.postAdd');

        Route::get(
            'edit/{product_id}',
            [ProductController::class, 'getEdit']
        )->name('admin.product.getEdit');

        Route::post(
            'edit',
            [ProductController::class, 'postEdit']
        )->name('admin.product.postEdit');

        Route::get(
            'delete/{product_id}',
            [ProductController::class, 'getDelete']
        )->name('admin.product.getDelete');

        // Additional Image
        Route::prefix('image')->group(function () {
            Route::get(
                'add/{productId}',
                [ProductController::class, 'getAddImage']
            )->name('admin.product.image.getAddImage');

            Route::post(
                'add',
                [ProductController::class, 'postAddImage']
            )->name('admin.product.image.postAddImage');

            Route::get(
                'edit/{productId}/{imageId}',
                [ProductController::class, 'getEditImage']
            )->name('admin.product.image.getEditImage');

            Route::post(
                'edit',
                [ProductController::class, 'postEditImage']
            )->name('admin.product.image.postEditImage');

            Route::get(
                'delete/{imageId}',
                [ProductController::class, 'getDeleteImage']
            )->name('admin.product.image.getDeleteImage');
        });

        // Category
        Route::prefix('category')->group(function () {
            Route::get(
                'list',
                [ProductCategoryController::class, 'getList']
            )->name('admin.product.category.getList');

            Route::get(
                'add',
                [ProductCategoryController::class, 'getAdd']
            )->name('admin.product.category.getAdd');

            Route::post(
                'add',
                [ProductCategoryController::class, 'postAdd']
            )->name('admin.product.category.postAdd');

            Route::get(
                'edit/{category_id}',
                [ProductCategoryController::class, 'getEdit']
            )->name('admin.product.category.getEdit');

            Route::post(
                'edit',
                [ProductCategoryController::class, 'postEdit']
            )->name('admin.product.category.postEdit');

            Route::get(
                'delete/{category_id}',
                [ProductCategoryController::class, 'getDelete']
            )->name('admin.product.category.getDelete');
        });

        // Group
        Route::prefix('group')->group(function () {
            Route::get(
                'list',
                [ProductGroupController::class, 'getList']
            )->name('admin.product.group.getList');

            Route::get(
                'add',
                [ProductGroupController::class, 'getAdd']
            )->name('admin.product.group.getAdd');

            Route::post(
                'add',
                [ProductGroupController::class, 'postAdd']
            )->name('admin.product.group.postAdd');

            Route::get(
                'edit/{category_id}',
                [ProductGroupController::class, 'getEdit']
            )->name('admin.product.group.getEdit');

            Route::post(
                'edit',
                [ProductGroupController::class, 'postEdit']
            )->name('admin.product.group.postEdit');

            Route::get(
                'delete/{category_id}',
                [ProductGroupController::class, 'getDelete']
            )->name('admin.product.group.getDelete');
        });

        // Attribute
        Route::prefix('attribute')->group(function () {
            Route::get(
                'index/{product_id}',
                [ProductController::class, 'getAttribute']
            )->name('admin.product.attribute.getAttribute');

            Route::post(
                'add',
                [ProductController::class, 'postAddAttribute']
            )->name('admin.product.attribute.postAddAttribute');

            Route::get(
                'edit/{product_id}/{attr_id}',
                [ProductController::class, 'getEditAttribute']
            )->name('admin.product.attribute.getEditAttribute');

            Route::post(
                'edit',
                [ProductController::class, 'postEditAttribute']
            )->name('admin.product.attribute.postEditAttribute');

            Route::get(
                'delete/{attribute_id}',
                [ProductController::class, 'getDeleteAttribute']
            )->name('admin.product.attribute.getDeleteAttribute');
        });

        // Reviews
        Route::prefix('reviews')->group(function () {
            Route::get(
                'list',
                [ProductReviewsController::class, 'getList']
            )->name('admin.product.reviews.getList');

            Route::get(
                'accept_review/{reviewId}',
                [ProductReviewsController::class, 'getAcceptReview']
            )->name('admin.product.reviews.getAcceptReview');

            Route::get(
                'delete_review/{reviewId}',
                [ProductReviewsController::class, 'getDeleteReview']
            )->name('admin.product.reviews.getDeleteReview');
        });
    });

    Route::prefix('customer')->group(function () {
        Route::get('list', [CustomerController::class, 'getList'])->name('admin.customer.getList');
        Route::get('toggle/{customerId}', [CustomerController::class, 'getToggle'])->name('admin.customer.getToggle');

        Route::get(
            'reviews',
            [CustomerController::class, 'getReviews']
        )->name('admin.customer.getReviews');

        Route::get(
            'add_review',
            [CustomerController::class, 'getAddReview']
        )->name('admin.customer.getAddReview');

        Route::post(
            'add_review',
            [CustomerController::class, 'postAddReview']
        )->name('admin.customer.postAddReview');

        Route::get(
            'edit_review/{customerReviewId}',
            [CustomerController::class, 'getEditReview']
        )->name('admin.customer.getEditReview');

        Route::post(
            'edit_review',
            [CustomerController::class, 'postEditReview']
        )->name('admin.customer.postEditReview');

        Route::get(
            'delete_review/{customerReviewId}',
            [CustomerController::class, 'getDeleteReview']
        )->name('admin.customer.getDeleteReview');
    });

    Route::prefix('invoice')->group(function () {
        Route::get('list', [InvoiceController::class, 'getList'])->name('admin.invoice.getList');
        Route::get('detail/{invoiceId}', [InvoiceController::class, 'getInvoiceDetail'])->name('admin.invoice.getInvoiceDetail');
        Route::post('toggle_status', [InvoiceController::class, 'toggleStatus'])->name('admin.invoice.toggleStatus');
        Route::get('delete/{invoiceId}', [InvoiceController::class, 'delete'])->name('admin.invoice.delete');
    });

    Route::prefix('slide')->group(function () {
        Route::get(
            'list',
            [SlideController::class, 'getList']
        )->name('admin.slide.getList');

        Route::get(
            'add',
            [SlideController::class, 'getAdd']
        )->name('admin.slide.getAdd');

        Route::post(
            'add',
            [SlideController::class, 'postAdd']
        )->name('admin.slide.postAdd');

        Route::get(
            'edit/{slideId}',
            [SlideController::class, 'getEdit']
        )->name('admin.slide.getEdit');

        Route::post(
            'edit',
            [SlideController::class, 'postEdit']
        )->name('admin.slide.postEdit');

        Route::get(
            'delete/{slideId}',
            [SlideController::class, 'getDelete']
        )->name('admin.slide.getDelete');

        Route::prefix('product')->group(function () {
            Route::get(
                'list',
                [SlideProductController::class, 'getList']
            )->name('admin.slide.product.getList');
    
            Route::get(
                'add',
                [SlideProductController::class, 'getAdd']
            )->name('admin.slide.product.getAdd');
    
            Route::post(
                'add',
                [SlideProductController::class, 'postAdd']
            )->name('admin.slide.product.postAdd');
    
            Route::get(
                'edit/{slideId}',
                [SlideProductController::class, 'getEdit']
            )->name('admin.slide.product.getEdit');
    
            Route::post(
                'edit',
                [SlideProductController::class, 'postEdit']
            )->name('admin.slide.product.postEdit');
    
            Route::get(
                'delete/{slideId}',
                [SlideProductController::class, 'getDelete']
            )->name('admin.slide.product.getDelete');
        });
    });

    Route::prefix('partner')->group(function () {
        Route::get(
            'list',
            [PartnerController::class, 'getList']
        )->name('admin.partner.getList');

        Route::get(
            'add',
            [PartnerController::class, 'getAdd']
        )->name('admin.partner.getAdd');

        Route::post(
            'add',
            [PartnerController::class, 'postAdd']
        )->name('admin.partner.postAdd');

        Route::get(
            'edit/{partnerId}',
            [PartnerController::class, 'getEdit']
        )->name('admin.partner.getEdit');

        Route::post(
            'edit',
            [PartnerController::class, 'postEdit']
        )->name('admin.partner.postEdit');

        Route::get(
            'delete/{partnerId}',
            [PartnerController::class, 'getDelete']
        )->name('admin.partner.getDelete');
    });

    Route::prefix('tra-gop')->group(function () {
        Route::get(
            'list',
            [TraGopController::class, 'getList']
        )->name('admin.tra-gop.getList');

        Route::get(
            'delete/{traGopId}',
            [TraGopController::class, 'getDelete']
        )->name('admin.tra-gop.getDelete');
    });

    Route::prefix('comment')->group(function () {
        Route::get( 'list', [CommentController::class, 'getList'])->name('admin.comment.getList');
    });

    Route::prefix('video')->group(function () {
        Route::get('list', [VideoController::class, 'getList'])->name('admin.video.getList');
        Route::get('add', [VideoController::class, 'getAdd'])->name('admin.video.getAdd');
        Route::post('add', [VideoController::class, 'postAdd'])->name('admin.video.postAdd');
        Route::get('edit/{videoId}', [VideoController::class, 'getEdit'])->name('admin.video.getEdit');
        Route::post('edit', [VideoController::class, 'postEdit'])->name('admin.video.postEdit');
        Route::get('delete/{videoId}', [VideoController::class, 'getDelete'])->name('admin.video.getDelete');
    });

    Route::prefix('gallery')->group(function () {
        Route::get('index', [ImageController::class, 'index'])->name('admin.gallery.index');
        Route::get('create', [ImageController::class, 'create'])->name('admin.gallery.create');
        Route::post('store', [ImageController::class, 'store'])->name('admin.gallery.store');
        Route::get('edit/{id}', [ImageController::class, 'edit'])->name('admin.gallery.edit');
        Route::post('update', [ImageController::class, 'update'])->name('admin.gallery.update');
        Route::get('destroy/{id}', [ImageController::class, 'destroy'])->name('admin.gallery.destroy');
        Route::get('show/{id}', [ImageController::class, 'show'])->name('admin.gallery.show');
        Route::prefix('detail')->group(function () {
            Route::get('create', [ImageController::class, 'createDetail'])->name('admin.gallery.detail.create');
            Route::post('store', [ImageController::class, 'storeDetail'])->name('admin.gallery.detail.storeDetail');
            Route::get('edit/{image_id}/{id}', [ImageController::class, 'showImageDetail'])->name('admin.gallery.detail.show');
            Route::post('update', [ImageController::class, 'updateImageDetail'])->name('admin.gallery.detail.update');
            Route::get('destroy/{id}', [ImageController::class, 'destroyDetail'])->name('admin.gallery.detail.destroyDetail');
        });
    });

    Route::prefix('seller')->group(function () {
        Route::get('list', [SellerController::class, 'getList'])->name('admin.seller.getList');
        Route::get('add', [SellerController::class, 'getAdd'])->name('admin.seller.getAdd');
        Route::post('add', [SellerController::class, 'postAdd'])->name('admin.seller.postAdd');
        Route::get('edit/{id}', [SellerController::class, 'getEdit'])->name('admin.seller.getEdit');
        Route::post('edit', [SellerController::class, 'postEdit'])->name('admin.seller.postEdit');
        Route::get('delete/{id}', [SellerController::class, 'getDelete'])->name('admin.seller.getDelete');
    });

    // ================ File Manager Route ================ //
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});

// ================ Ajax Route ================ //
Route::prefix('ajax')->group(function () {
    Route::post(
        'districts',
        [ProvinceController::class, 'getDistrictByProvinceId']
    )->name('ajax.getDistrictByProvinceId');

    Route::post(
        'wards',
        [ProvinceController::class, 'getWardByDistrictId']
    )->name('ajax.getWardByDistrictId');
});

// ================ Route Clear Cache ================ //
Route::get('config/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'Clear All Cache Successfully';
});
