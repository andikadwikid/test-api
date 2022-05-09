<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStore;
use App\Models\Categories;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $data = Post::paginate();
        return response()->json([
            'success'   => true,
            'message'   => 'Success show post',
            'data'      => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $check_category = Categories::where('id', $request->category_id)->first();

        if (!$check_category) {
            return response()->json([
                'message' => 'category is not exist',
            ]);
        }
        // $validate = Validator::make($request->all(), [
        //     'title' => 'required',
        //     'content' => 'required',
        //     'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        //     'status' => 'required',
        // ]);

        // if ($validate->fails()) {
        //     return response()->json($validate->errors(), 400);
        // }

        $data = $request->all();
        $image = $request->file('image');
        $data['image'] = $image->hashName();
        $image->storeAs('public/image', $image->hashName());

        $post = Post::create($data);

        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Success add post',
                'data'      => $post,
            ], 200);
        }
        return response()->json([
            'message' => 'Error'
        ], 400);
    }

    public function show($id)
    {
        $data = Post::findOrFail($id);

        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Success show data',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data',
            ], 409);
        }
    }

    public function update(Request $request, $id)
    {

        $post = Post::findOrFail($id);
        dd($request->all());
        $data = $request->all();
        // dd($post->image);
        if (!$request->file('image')) {
            $post->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Success Update Data',
                'update' => $post
            ], 200);
        } else {
            Storage::delete('public/image/' . $post->image);
            $image = $request->file('image');
            $image->storeAs('public/image', $image->hashName());
            $data['image'] = $image->hashName();
            $post->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Success Update Data',
                'update' => $post
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error',
        ], 404);
    }

    public function delete($id)
    {
        $check = Post::findOrFail($id);
        if ($check) {
            Storage::delete('public/image/' . $check->image);
            Post::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Success delete data',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data',
            ], 404);
        }
    }
}
