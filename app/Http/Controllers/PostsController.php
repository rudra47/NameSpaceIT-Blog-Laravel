<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = Post::paginate(5);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['posts'] = Post::where('id', $id)->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'slug' => 'required', 'unique:posts,slug',
        ]);

        // $sms_notify = $request->sms_notify == true ? 1 : 0;
        // $email_notify = $request->email_notify == true ? 1 : 0;

        if ($validator->passes()) {
            Post::where('id', $id)->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'body' => $request->body,
            ]);
            
            return response()->json(['message' => 'Post Update successful', 'type' => 'success'], 200);
        }else{
            return response()->json(['message' => 'Something is wrong', 'type' => 'error'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        if($post->delete()){
            return response()->json(['message' => 'Post Delete successful', 'type' => 'success'], 200);
        }else{
            return response()->json(['message' => 'Something is wrong', 'type' => 'error'], 200);
        }
    }
}
