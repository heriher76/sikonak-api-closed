<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
  public function fetchMessages()
  {
      try {
          $iam = Auth::user();
          $messages = $iam->family->messages;
          //return successful response
          return response()->json(['messages' => $messages, 'message' => 'Messages Get Succesfully'], 200);
      } catch (\Exception $e) {
          //return error message
          return response()->json(['message' => 'Cannot Get Messages!'], 409);
      }
  }

  public function sendMessage(Request $request)
  {
      //validate incoming request
      $this->validate($request, [
          'message' => 'required|string'
      ]);

      try {
          $iam = Auth::user();
          $message = $iam->family->messages()->create([
            'message' => $request->input('message'),
            'id_user' => $iam->id
          ]);

          //return successful response
          return response()->json(['messages' => $request->all(), 'message' => 'Send Message Succesfully'], 200);
      } catch (\Exception $e) {
          //return error message
          return response()->json(['message' => 'Send Message Failed!'], 409);
      }
  }
}
