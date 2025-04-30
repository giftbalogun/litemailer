<?php

namespace App\Http\Controllers;

use App\EmailList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| EmailController
|--------------------------------------------------------------------------
*/
class EmailController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | web-view add email
    |--------------------------------------------------------------------------
    */
    public function showAddEmailForm()
    {
        return view('add-email');
    }
    
    /*
    |--------------------------------------------------------------------------
    | web-view add email
    |--------------------------------------------------------------------------
    */
    public function showEmailList()
    {
        $emails = EmailList::all();
        return view('list-email', compact('emails'));
    }

    /*
    |--------------------------------------------------------------------------
    | web-view save email
    |--------------------------------------------------------------------------
    */
    public function saveEmail()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|max:255|unique:email_lists,email',
        ]);

        EmailList::create($data);

        return redirect()->back()->with('message', 'Your email was added successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | web-view show send mail form
    |--------------------------------------------------------------------------
    */
    public function showSendEmailForm()
    {
        return view('send-email');
    }

    /*
    |--------------------------------------------------------------------------
    | web-view send mail
    |--------------------------------------------------------------------------
    */
    public function sendEmail()
    {
        request()->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        //data we are passing to our email blade template
        $data = [
            'title' => request('subject'),
            'body' => request('message'),
        ];

        // return an array of all the emails in our database
        $emails = EmailList::all('email')->pluck('email')->toArray();

        // send out email
        Mail::send('emails.welcome', $data, function ($message) use ($emails) {
            $message->to($emails);
            $message->subject('LiteMailer Bulk Email');
        });

        return redirect()->back()->with('message', 'Your bulk email was sent successfully');
    }
}
