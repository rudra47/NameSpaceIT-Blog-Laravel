<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use Validator;

class PostController extends Controller
{
    public function getPost()
    {
        $data['posts'] = Post::paginate(5);
        return response()->json($data);
    }
    public function postStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'slug' => 'required', 'unique:posts,slug',
        ]);

        // $sms_notify = $request->sms_notify == true ? 1 : 0;
        // $email_notify = $request->email_notify == true ? 1 : 0;

        if ($validator->passes()) {
            Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'body' => $request->body,
            ]);
            
            return response()->json(['message' => 'Post Create successful', 'type' => 'success'], 200);
        }else{
            return response()->json(['message' => 'Something is wrong', 'type' => 'error'], 200);
        }

    }
    
}
