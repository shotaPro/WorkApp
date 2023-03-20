<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\W_category;
use App\Models\SubCategory;
use App\Models\Admin_news;

class AdminController extends Controller
{

    public function category_register_page()
    {
        $category_info = W_category::all();

        return view('admin.category_register_page', compact('category_info'));
    }

    public function register_category(Request $request)
    {
        $category = new W_category();

        if ($request->category_name != NULL) {

            $category->category_name = $request->category_name;
            $category->save();

            return redirect()->back()->with('message', 'カテゴリ登録が正常に行われました。');
        } else {

            return redirect()->back()->with('error', '新規カテゴリを入力してください。');
        }
    }

    public function register_subcategory(Request $request)
    {
        $subcategory = new Subcategory();
        $main_category_id = $request->input("subcategory");
        $subcategory_name = $request->subcategory_name;

        if ($main_category_id != NULL && $subcategory_name != NULL) {

            $subcategory->category_id = $main_category_id;
            $subcategory->subcategory_name = $subcategory_name;
            $subcategory->save();

            return redirect()->back()->with('message', 'サブカテゴリ登録が正常に完了しました。');
        } else {

            return redirect()->back()->with('error', 'メインカテゴリまたはサブカテゴリ名が入力されていません。');
        }
    }

    public function post_new_page()
    {

        ////////////////////////////////////////////////////////////////
        //お知らせ一覧のデータ取得
        ////////////////////////////////
        $all_news_info = Admin_news::all();
        ////////////////////////////////////////////////////////////////


        return view('admin.post_new_page', compact('all_news_info'));
        
    }

    public function admin_news_post(Request $request)
    {
        $post_text = $request->input('news_text');
        $admin_news_info = new Admin_news;

        if($post_text == NULL){

            return redirect()->back()->with('error', '投稿内容を入力してください');

        }else {

            $admin_news_info->admin_news_text = $post_text;

        }

        $admin_news_info->save();

        return redirect()->back()->with('message', 'お知らせの投稿が、正常に完了しました。');

    }
}
