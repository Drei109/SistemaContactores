<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function sendEmail(){
      
   }

   public function htmlEmail() {
      $data = array('name'=>"Test Name");
      Mail::send('Mail.mail', $data, function($message) {
         $message->to('drei.rar@gmail.com', 'Name Test')->subject
            ('Test Subject');
         $message->from('AdmiWebOnline@gmail.com','From Test');
      });
      echo "HTML Email Sent. Check your inbox.";
   }

   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}