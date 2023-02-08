<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\W_category;
use App\Models\SubCategory;

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

        if($main_category_id != NULL && $subcategory_name != NULL) {

            $subcategory->category_id = $main_category_id;
            $subcategory->subcategory_name = $subcategory_name;
            $subcategory->save();

            return redirect()->back()->with('message', 'サブカテゴリ登録が正常に完了しました。');

        }else {

            return redirect()->back()->with('error', 'メインカテゴリまたはサブカテゴリ名が入力されていません。');

        }
    }
}
