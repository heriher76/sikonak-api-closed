<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Family;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
  public function store(Request $request)
  {
      //validate incoming request
      $this->validate($request, [
          'name' => 'required|string'
      ]);

      try {
          $user = Auth::user();
          if ($user->id_family == null) {
            $family = new Family;
            $family->name = $request->input('name');

            $family->save();

            $user->update([
              'id_family' => $family->id
            ]);
            //return successful response
            return response()->json(['family' => $family, 'message' => 'Family Created'], 201);
          }else{
            return response()->json(['message' => 'Error, Already Have Family!'], 409);
          }

      } catch (\Exception $e) {
          //return error message
          return response()->json(['message' => 'Family Registration Failed!'], 409);
      }
  }
}
