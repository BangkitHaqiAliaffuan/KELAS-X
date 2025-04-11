<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim');
    }

      /**
     * Display a listing of the messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function showmessage()
    {
        $messages = Contact::orderBy('created_at', 'desc')->get();
        return view('admin.messages', [
            'messages' => $messages,
            'activeMessage' => null
        ]);
    }

    /**
     * Display the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activeMessage = Contact::findOrFail($id);
        $messages = Contact::orderBy('created_at', 'desc')->get();

        // Mark message as read using session
        $readMessages = session('read_messages', []);
        if (!in_array($id, $readMessages)) {
            $readMessages[] = $id;
            session(['read_messages' => $readMessages]);
        }

        return view('admin.messages', [
            'messages' => $messages,
            'activeMessage' => $activeMessage
        ]);
    }

    /**
     * Show the reply form for the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showReplyForm($id)
    {
        $activeMessage = Contact::findOrFail($id);
        $messages = Contact::orderBy('created_at', 'desc')->get();

        return view('admin.messages', [
            'messages' => $messages,
            'activeMessage' => $activeMessage
        ])->with('replyForm', true);
    }

    /**
     * Reply to the specified message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $message = Contact::findOrFail($id);

        $request->validate([
            'reply' => 'required|string'
        ]);

        // Here you would typically send an email with the reply
        // For example:
        /*
        Mail::to($message->email)->send(new ReplyMail(
            $message,
            $request->reply
        ));
        */

        // For now, we'll just redirect with a success message
        return redirect()->route('admin.messages.show', $id)
            ->with('replySuccess', 'Your reply has been sent successfully!');
    }

    /**
     * Delete the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $message = Contact::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully!');
    }
}
