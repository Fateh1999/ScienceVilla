<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\InquiryFormMail;
use App\Mail\ContactAutoReplyMail;
use App\Mail\InquiryAutoReplyMail;

class ContactController extends Controller
{
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255','regex:/^[A-Za-z\s\'\.\-]+$/'],
            'email' => ['required','email:rfc,dns','max:255'],
            'phone' => ['nullable','regex:/^[0-9+\-\s]{7,15}$/'],
            'message' => ['required','string','min:10','max:2000'],
        ]);

        try {
            // Send admin notification
            Mail::to('gurfatehsingh890@gmail.com')->send(new ContactFormMail($request->all()));
            // Send auto-reply to sender
            Mail::to($request->email)->send(new ContactAutoReplyMail(array_merge($request->all(), ['country'=>$request->route('country')])));

            if($request->expectsJson()){
                return response()->json(['message'=>'Thank you for your message! We\'ll get back to you within 24 hours.']);
            }
            return back()->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
        } catch (\Exception $e) {
            if($request->expectsJson()){
                return response()->json(['message'=>'Unable to send at the moment'],500);
            }
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again or contact us directly.');
        }
    }

    public function submitInquiry(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255','regex:/^[A-Za-z\s\'\.\-]+$/'],
            'email' => ['required','email:rfc,dns','max:255'],
            'phone' => ['nullable','regex:/^[0-9+\-\s]{7,15}$/'],
            'message' => ['nullable','string','max:2000'],
        ]);

        try {
            // Send admin notification
            Mail::to('gurfatehsingh890@gmail.com')->send(new InquiryFormMail($request->all()));
            // Send auto-reply to sender
            Mail::to($request->email)->send(new InquiryAutoReplyMail(array_merge($request->all(), ['country'=>$request->route('country')])));

            if($request->expectsJson()){
                return response()->json(['message'=>'Thank you for your inquiry! We\'ll contact you within 24 hours to schedule your free demo.']);
            }
            return back()->with('success', 'Thank you for your inquiry! We\'ll contact you within 24 hours to schedule your free demo.');
        } catch (\Exception $e) {
            if($request->expectsJson()){
                return response()->json(['message'=>'Unable to submit at the moment'],500);
            }
            return back()->with('error', 'Sorry, there was an error submitting your inquiry. Please try again or contact us directly.');
        }
    }
}
