<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\W_category;
use App\Models\subcategory;
use App\Models\Work;
use App\Models\Work_consult_message;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        if ($user_id != 1) {

            $notification_info = Notification::Where('notificationTo', '=', $user_id)->Where('status', '=', NULL)->get();

            return view('user.home', compact('notification_info'));
        } else {

            return view('admin.home');
        }
    }

    public function user_profile_page()
    {
        $user_id = Auth::user()->id;
        $profile_data = User::find($user_id);
        return view('user.user_profile_page', compact('user_id', 'profile_data'));
    }

    public function user_profile_register_page()
    {
        $user_id = Auth::user()->id;
        return view('user.user_profile_register_page', compact('user_id'));
    }

    public function user_profile_register(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_info = User::find($user_id);

        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'profile_text' => 'required',
            'skill' => 'required',
        ], [
            'name.required' => 'ユーザーネームは必須です',
            'image.required' => 'プロフィール画像は必須です',
            'profile_text.required' => 'アピール文は必須です',
            'skill.required' => 'スキル文は必須です',
        ]);

        $user_info->user_name = $request->name;

        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('profile_picture', $imagename);
        $user_info->image = $imagename;

        $user_info->profile_text = $request->profile_text;
        $user_info->skill = $request->skill;

        $user_info->save();

        return redirect()->back()->with('message', 'プロフィールの登録が正常に行われしました。');
    }

    public function user_profile_edit_page($id)
    {
        $profile_data = User::find($id);

        return view('user.user_profile_edit_page', compact('profile_data'));
    }

    public function user_profile_edit(Request $request, $id)
    {
        $edit_profile_data = User::find($id);

        $edit_profile_data->user_name = $request->name;
        $edit_profile_data->image = $request->image;

        if ($edit_profile_data->image != NULL) {

            $imagename = time() . '.' . $edit_profile_data->getClientOriginalExtension();
            $request->image->move('profile_picture', $imagename);
            $edit_profile_data->image = $imagename;
        }
        $edit_profile_data->profile_text = $request->profile_text;
        $edit_profile_data->skill = $request->skill;

        $edit_profile_data->save();

        return redirect()->back()->with("message", "編集が正常に完了しました。");
    }

    public function order_work_page()
    {
        return view('user.order_work_page');
    }

    public function select_order_work_category($id)
    {
        $category_info = W_category::all();
        $subcategory_info = subcategory::Where('category_id', '=', $id)->get();

        return view('user.order_work_page', compact('category_info', 'subcategory_info'));
    }

    public function order_work_registration(Request $request)
    {

        $user_id = Auth::user()->id;

        $request->validate([
            'work_category' => 'required',
            'work_title' => 'required',
            'work_detail' => 'required',
            'reward' => 'required',
            'dudate' => 'required',
        ], [
            'work_category.required' => 'カテゴリ選択は必須です',
            'work_title.required' => 'タイトルは必須です。',
            'work_detail.required' => '仕事内容の記載は必須です',
            'reward.required' => '報酬額は必須です',
            'dudate.required' => '期限は必須です',
        ]);


        $work_info = new work();
        $work_info->category_id = $request->input('work_category');
        $work_info->work_title = $request->work_title;
        $work_info->work_contents = $request->work_detail;
        $work_info->rewards = $request->reward;
        $work_info->dudate = $request->dudate;
        $work_info->order_person_id = $user_id;

        $work_info->save();

        return redirect()->back()->with("message", "仕事掲載の登録が正常に完了しました。");
    }

    public function recruit_work_page()
    {
        $work_info = Work::all();

        return view('user.recruit_work_page', compact('work_info'));
    }

    public function worker_list_page()
    {
        $users = User::Where('id', '!=', 1)->get();
        return view('user.worker_list_page', compact('users'));
    }

    public function user_order_consult_page($id)
    {
        $receiver_info = User::find($id);
        $category_info = W_category::all();
        $subcategory_info = subcategory::Where('category_id', '=', $id)->get();

        return view('user.user_order_consult_page', compact('receiver_info', 'category_info', 'subcategory_info'));
    }

    public function select_order_consult_work_category(Request $request, $id)
    {
        $receiver_id = $request->receiver_id;
        $receiver_info = User::find($receiver_id);
        $category_info = W_category::all();
        $subcategory_info = subcategory::Where('category_id', '=', $id)->get();

        return view('user.user_order_consult_page', compact('category_info', 'subcategory_info', 'receiver_info'));
    }

    public function send_order_consult_work_message(Request $request, $id)
    {

        $request->validate([
            'work_category' => 'required',
            'work_consult' => 'required',
        ], [
            'work_category.required' => 'カテゴリ選択は必須です',
            'work_consult.required' => 'メッセージは必須です。',
        ]);

        $sender_id = Auth::user()->id;
        $receiver_info = User::find($id);
        $work_message = new Work_consult_message();
        $notification = new Notification();

        //work_consult_messageにインサート
        $work_message->work_id = $request->work_category;
        $work_message->consult_message = $request->work_consult;
        $work_message->sender_id = $sender_id;
        $work_message->receiver_id = $receiver_info->id;

        //notificationにインサート
        $notification->notificationFrom = $sender_id;
        $notification->notificationTo = $receiver_info->id;

        $work_message->save();
        $notification->save();

        //メール送信処理
        $mail_data = [
            'recipient' => 'test@gmail.com',
            'fromEmail' => 'test@gmail.com',
            'fromName' => 'work_App_admin',
            'subject' => 'This is test email',
            'body' => $request->work_consult
        ];

        Mail::send('email-template', $mail_data, function ($message) use ($mail_data) {
            $message->to($mail_data['recipient'])->from($mail_data['fromEmail'], $mail_data['fromName'])->subject($mail_data['subject']);
        });

        return redirect()->back()->with('message', '送信が完了しました。返事が来るまでお待ちください。');
    }

    public function message_list_page()
    {

        $user_id = Auth::user()->id;
        $receive_message_list = Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')->where('receiver_id', '=', $user_id)->get();
        $unread_notification_info = notification::where('notificationTo', '=', $user_id)->where('status', '=', NULL)->update(['status' => 1]);

        return view('user.message_list_page', compact('receive_message_list'));
    }

    public function detail_consult_message(Request $request, $id)
    {
        $sender_id = $request->sender_id;
        $receiver_id = $request->receiver_id;
        $work_id = $id;

        $detail_message_info = work_consult_message::Where('receiver_id', '=', $receiver_id)->Where('sender_id', '=', $request->sender_id)->Where('work_id', '=', $work_id)->first();

        return view('user.detail_consult_message', compact('detail_message_info'));

    }
}
