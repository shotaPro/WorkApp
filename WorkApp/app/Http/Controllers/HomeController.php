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
use Illuminate\Support\Facades\Redirect;
use App\Models\Reply_message;

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
        $image = $request->image;

        if ($image != NULL) {

            $imagename = time() . '.' . $image->getClientOriginalExtension();
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

        $receive_message_list = Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')
            ->Where('work_consult_messages.sender_id', '=', $user_id)
            ->orWhere('work_consult_messages.receiver_id', '=', $user_id)
            ->select('work_consult_messages.id', 'users.user_name', 'work_consult_messages.consult_message', 'work_consult_messages.work_id', 'work_consult_messages.sender_id', 'work_consult_messages.receiver_id', 'work_consult_messages.task_id')
            ->get();

        $unread_notification_info = notification::where('notificationTo', '=', $user_id)->where('status', '=', NULL)->update(['status' => 1]);


        return view('user.message_list_page', compact('receive_message_list'));
    }

    public function detail_consult_message(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $sender_id = $request->sender_id;
        $sender_id = (int)$sender_id;
        $receiver_id = $request->receiver_id;
        $task_id = $request->task_id;
        $message_id = $id;
        $work_info = Work_consult_message::find($message_id);
        $job_recruit_info = Work::find($work_info->task_id);

        if ($work_info->message_status == 1) {
            //応募ページのからの送信の場合は以下を実行


            ////////////////////////////////////////////////////////////////////////
            ///最初の相談メッセージの送信者の情報は固定
            ////////////////////////////////
            if ($sender_id == $user_id) {

                $sender_info =  Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')
                    ->join('works', 'works.id', 'work_consult_messages.task_id')
                    ->Where('work_consult_messages.task_id', '=', $task_id)
                    ->Where('work_consult_messages.sender_id', '=', $user_id)
                    ->orWhere('work_consult_messages.receiver_id', '=', $user_id)
                    ->Where('work_consult_messages.id', '=', $message_id)
                    ->select('work_consult_messages.id', 'users.user_name', 'users.image', 'work_consult_messages.consult_message', 'work_consult_messages.work_id', 'work_consult_messages.sender_id', 'work_consult_messages.receiver_id', 'work_consult_messages.task_id')
                    ->first();
            } else {

                $sender_info =  Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')
                    ->Where('work_consult_messages.sender_id', '=', $user_id)
                    ->Where('work_consult_messages.id', '=', $message_id)
                    ->orWhere('work_consult_messages.receiver_id', '=', $user_id)
                    ->select('work_consult_messages.id', 'users.user_name', 'users.image', 'work_consult_messages.consult_message', 'work_consult_messages.work_id', 'work_consult_messages.sender_id', 'work_consult_messages.receiver_id', 'work_consult_messages.task_id')
                    ->first();
            }
        } else {

            //応募ページ以外からの場合は以下を実行

            ////////////////////////////////////////////////////////////////////////
            ///最初の相談メッセージの送信者の情報は固定
            ////////////////////////////////
            if ($sender_id != $user_id) {

                $sender_info =  Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')
                    ->Where('work_consult_messages.sender_id', '=', $user_id)
                    ->orWhere('work_consult_messages.receiver_id', '=', $user_id)
                    ->Where('work_consult_messages.id', '=', $message_id)
                    ->select('work_consult_messages.id', 'users.user_name', 'users.image', 'work_consult_messages.consult_message', 'work_consult_messages.work_id', 'work_consult_messages.sender_id', 'work_consult_messages.receiver_id')
                    ->first();
            } else {

                $sender_info =  Work_consult_message::join('users', 'users.id', 'work_consult_messages.sender_id')
                    ->Where('work_consult_messages.sender_id', '=', $user_id)
                    ->Where('work_consult_messages.id', '=', $message_id)
                    ->orWhere('work_consult_messages.receiver_id', '=', $user_id)
                    ->select('work_consult_messages.id', 'users.user_name', 'users.image', 'work_consult_messages.consult_message', 'work_consult_messages.work_id', 'work_consult_messages.sender_id', 'work_consult_messages.receiver_id')
                    ->first();
            }
        }
        ////////////////////////////////////////////////////////////////



        ////////////////////////////////////////////////////////////////
        ///返信メッセージ取得
        ////////////////////////////////////////////////////////////////
        $reply_message = Reply_message::join('users', 'users.id', 'reply_messages.replyBy_id')
            ->Where('reply_id', '=', $message_id)
            ->get();

        if ($work_info->message_status == 1) {

            return view('user.detail_consult_message', compact('sender_info', 'reply_message', 'job_recruit_info'));
        } else {

            $job_recruit_info = NULL;
            return view('user.detail_consult_message', compact('sender_info', 'reply_message', 'job_recruit_info'));
        }
    }

    public function reply_consult_message(Request $request, $id)
    {

        $user_id = Auth::user()->id;
        $message_id = $id;
        $messageFrom_user_id = $request->input('messageFrom_user_id');

        $request->validate([
            'reply_message' => 'required',
        ], [
            'reply_message.required' => 'メッセージが入力されていません。',
        ]);

        ////////////////////////////////////////////////////////////////
        //reply_messageにデータを挿入
        ////////////////////////////////////////////////////////////////
        $reply_message = new Reply_Message();
        $reply_message->reply_id = $message_id;
        $reply_message->reply_message = $request->reply_message;
        $reply_message->replyBy_id = $user_id;
        ////////////////////////////////////////////////////////////////////////

        /////////////////////////////
        //通知機能反映処理
        //////////////////////////////
        $notification_info = new Notification();
        $notification_info->notificationFrom = $user_id;
        $notification_info->notificationTo = $messageFrom_user_id;
        ////////////////////////////////////////////////////////////////

        $reply_message->save();
        $notification_info->save();

        $reply_message = reply_message::join('work_consult_messages', 'work_consult_messages.id', 'reply_messages.reply_id')
            ->join('users', 'users.id', 'work_consult_messages.receiver_id')
            ->Where('work_consult_messages.id', '=', $message_id)
            ->Where('users.id', '=', $user_id)
            ->get();

        return redirect()->back()->with('reply_info', $reply_message);
    }

    public function recruit_work_page()
    {
        $work_data = Work::all();
        $work_info = array();

        foreach ($work_data as $data) {
            $work_info[] = Work::join('users', 'users.id', 'works.order_person_id')
                ->Where('works.order_person_id', '=', $data->order_person_id)
                ->select('works.id', 'works.work_title', 'works.work_contents', 'works.apply_number', 'works.rewards', 'users.user_name', 'users.image')
                ->get();
        }


        return view('user.recruit_work_page', compact('work_info'));
    }

    public function work_detail_info_page($id)
    {
        $user_id = Auth::user()->id;
        $work_detail_info = work::find($id);
        $work_detail_info = Work::join('users', 'users.id', 'works.order_person_id')
            ->Where('works.order_person_id', '=', $work_detail_info->order_person_id)
            ->Where('works.id', '=', $id)
            ->select('works.id', 'works.work_title', 'works.work_contents', 'works.apply_number', 'works.rewards', 'users.user_name', 'users.image')
            ->first();

        ////////////////////////////////////////////////////////////////
        //応募済みフラグ追加
        ////////////////////////////////////////////////////////////////
        $apply_flg = Work_consult_message::join('works', 'works.id', 'work_consult_messages.task_id')
            ->Where('work_consult_messages.task_id', '=', $work_detail_info->id)
            ->Where('work_consult_messages.sender_id', '=', $user_id)
            ->first();
        if (isset($apply_flg)) {

            $apply_flg = $apply_flg->task_id;
        } else {

            $apply_flg = NULL;
        }
        ////////////////////////////////////////////////////////////////

        return view('user.work_detail_info_page', compact('work_detail_info', 'apply_flg'));
    }

    public function apply_job_page($id)
    {
        $work_detail_info = Work::join('users', 'users.id', 'works.order_person_id')
            ->Where('works.id', '=', $id)
            ->select('works.id', 'users.id as u_id', 'works.work_title', 'works.work_contents', 'works.apply_number', 'works.rewards', 'works.category_id', 'users.user_name', 'users.image')
            ->first();

        return view('user.apply_job_page', compact('work_detail_info'));
    }

    public function apply_job(Request $request, $id)
    {

        $request->validate([
            'apply_message' => 'required',
        ], [
            'apply_message.required' => 'メッセージが入力されていません。',
        ]);


        $sender_id = $request->input('sender_id');
        $receiver_id = $request->input('receiver_id');
        $category_id = $request->input('category_id');
        $apply_message = $request->input('apply_message');
        $work_info = Work::find($id);

        if ($work_info->apply_number != NULL) {
            //既に応募者がいる場合は以下の処理を実行

            ////////////////////////////////////////////////////////////////
            ////Work_consult_messageにインサート
            ////////////////////////////////////////////////////////////////
            $work_consult_message = new Work_consult_message();
            $work_consult_message->work_id = $category_id;
            $work_consult_message->sender_id = $sender_id;
            $work_consult_message->receiver_id = $receiver_id;
            $work_consult_message->consult_message = $apply_message;
            $work_consult_message->message_status += 1;
            $work_consult_message->task_id = $work_info->id;
            ////////////////////////////////////////////////////////////////


            ////////////////////////////////////////////////////////////////
            //応募者数追加
            ////////////////////////////////////////////////////////////////
            $work_info->apply_number += 1;
            ////////////////////////////////////////////////////////////////


            ////////////////////////////////////////////////////////////////
            //通知機能処理
            ////////////////////////////////////////////////////////////////
            $notification_info = new Notification();
            $notification_info->notificationFrom = $sender_id;
            $notification_info->notificationTo = $receiver_id;
            ///////////////////////////////////////////////////////////////


        } else {
            //始めての応募者の場合は以下の処理を実行

            ////////////////////////////////////////////////////////////////
            ////Work_consult_messageにインサート
            ////////////////////////////////////////////////////////////////
            $work_consult_message = new Work_consult_message();
            $work_consult_message->work_id = $category_id;
            $work_consult_message->sender_id = $sender_id;
            $work_consult_message->receiver_id = $receiver_id;
            $work_consult_message->consult_message = $apply_message;
            $work_consult_message->message_status = 1;
            $work_consult_message->task_id = $work_info->id;
            ////////////////////////////////////////////////////////////////


            ////////////////////////////////////////////////////////////////
            //応募者数追加
            ////////////////////////////////////////////////////////////////
            $work_info->apply_number = 1;
            ////////////////////////////////////////////////////////////////


            ////////////////////////////////////////////////////////////////
            //通知機能処理
            ////////////////////////////////////////////////////////////////
            $notification_info = new Notification();
            $notification_info->notificationFrom = $sender_id;
            $notification_info->notificationTo = $receiver_id;
            ///////////////////////////////////////////////////////////////

        }


        $work_consult_message->save();
        $work_info->save();
        $notification_info->save();


        return redirect()->back()->with('message', '応募が完了しました。');
    }

    public function choose_applicant(Request $request)
    {
        $applicant_id = $request->input('applicant_id');
        $work_id = $request->input('work_id');
        $work_info = Work::find($work_id);

        ///////////////////////////////////////////////////////////////
        //仕事を依頼する人のデータ反映処理
        ////////////////////////////////
        $work_info->receiver_person_id = $applicant_id;
        ////////////////////////////////

        ///////////////////////////////////////////////////////////////
        //依頼する人にあなたで確定しましたとの旨を伝えるメール送信処理
        ///////////////////////////////////////////////////////////////
        $work_person_info = User::find($applicant_id);
        $work_person_email = $work_person_info->email;

        Mail::to($work_person_email)->send(new MailNotify());
        ////////////////////////////////

        // $work_info->save();

        return redirect()->back()->with('message', '確定処理が完了しました。');

    }
}
