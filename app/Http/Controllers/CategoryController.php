<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStore;
use App\Http\Requests\Category\CategoryUpdate;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Categories::paginate();
        return response()->json([
            'success' => true,
            'message' => 'Show all categories',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $data = $request->only(['name']);
        $catregories = Categories::create($data);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        };
        return response()->json([
            'success' => true,
            'message' => 'Success input data',
            'data' => $catregories,
        ], 200);
    }

    public function show($id)
    {
        $data = Categories::findOrFail($id);

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
        $check = Categories::firstWhere('id', $id);

        if ($check) {
            $validate = Validator::make($request->all(), [
                'name' => 'required|unique:categories,name',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), 400);
            }
            $category = Categories::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Success update data',
                'update' => $category,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data',
            ], 404);
        }
    }

    public function delete($id)
    {
        $check = Categories::firstWhere('id', $id);
        if ($check) {
            Categories::destroy($id);
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
