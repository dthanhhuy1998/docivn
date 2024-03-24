<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use DB;
use Storage;

class ConfigController extends Controller
{
    protected $configModel = '';

    public function __construct() {
        $this->configModel = new Config();
    }

    public function getUpdate()
    {
        // tab general
        $heading = $this->configModel->getConfig('meta_title');
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $favicon = $this->configModel->getConfig('favicon');
        $logo = $this->configModel->getConfig('logo');
        $contact = $this->configModel->getConfig('contact');
        $copyright = $this->configModel->getConfig('copyright');
        // tab code
        $codeHeader = $this->configModel->getConfig('code_header');
        $codeFooter = $this->configModel->getConfig('code_footer');
        // tab social
        $phone = $this->configModel->getConfig('phone');
        $zalo = $this->configModel->getConfig('zalo');
        $facebook = $this->configModel->getConfig('facebook');
        $youtube = $this->configModel->getConfig('youtube');
        $instagram = $this->configModel->getConfig('instagram');
        $tiktok = $this->configModel->getConfig('tiktok');
        $twitter = $this->configModel->getConfig('twitter');
        $gmail = $this->configModel->getConfig('gmail');
        // other
        $mailReceiveFeedback = $this->configModel->getConfig('mail_receive_feedback');

        $headingTitle = heading('Thiết lập');
        $pageTitle = 'Thiết lập';

        return view('admin.pages.config.update', compact(
            'headingTitle', 'pageTitle',
            'heading', 'description', 'keyword', 'favicon', 'logo', 'contact', 'copyright',
            'codeHeader', 'codeFooter',
            'phone', 'zalo', 'facebook', 'youtube', 'instagram', 'tiktok', 'twitter', 'gmail',
            'mailReceiveFeedback'
        ));
    }

    public function postUpdate(Request $request) {
        // get config
        $favicon = $this->configModel->getConfig('favicon');
        $logo = $this->configModel->getConfig('logo');
        // update generate
        $this->updateData('meta_title', trim($request->heading));
        $this->updateData('meta_description', $request->description);
        $this->updateData('meta_keyword', trim($request->keyword));
        $this->updateData('contact', $request->contact);
        $this->updateData('copyright', $request->copyright);
        if($request->hasFile('favicon')) {
            Storage::delete($favicon);
            $faviconPath = Storage::putFile('uploads/config', $request->file('favicon'));
            $this->updateData('favicon', $faviconPath);
        }
        if($request->hasFile('logo')) {
            Storage::delete($logo);
            $logoPath = Storage::putFile('uploads/config', $request->file('logo'));
            $this->updateData('logo', $logoPath);
        }
        // update code
        $this->updateData('code_header', $request->code_header);
        $this->updateData('code_footer', $request->code_footer);
        // update social
        $this->updateData('phone', trim($request->phone));
        $this->updateData('zalo', trim($request->zalo));
        $this->updateData('facebook', trim($request->facebook));
        $this->updateData('youtube', trim($request->youtube));
        $this->updateData('instagram', trim($request->instagram));
        $this->updateData('tiktok', trim($request->tiktok));
        $this->updateData('twitter', trim($request->twitter));
        $this->updateData('gmail', trim($request->gmail));
        // other
        $this->updateData('mail_receive_feedback', trim($request->mailReceiveFeedback));
        // update API
        $this->updateData('thesieutoc_api_key', trim($request->theSieuTocApiKey));
        $this->updateData('thesieutoc_callback', trim($request->theSieuTocCallback));

        return redirect()->route('admin.system.config.getUpdate')->with('success_msg', 'Lưu thiết lập thành công');
    }

    // Functions
    public function updateData($key, $val) {
        DB::beginTransaction();
        try {
            DB::table('configs')
            ->where('config_key', $key)
            ->update(['config_value' => $val]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return true;
    }
}
