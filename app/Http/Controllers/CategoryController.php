<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Category Crude
 *
 * APIs for managing categories in the system.
 */
class CategoryController extends Controller
{
    /**
     * All Categories
     *
     * Retrieves all category data.
     *
     * @authenticated
     * @header Authorization Bearer {token}
     *
     * @response 200 {
     *     "status": true,
     *     "message": "All Category Data Fetched Successfully",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "Category 01",
     *             "description": "Description data..",
     *         },
     *         {
     *             "id": 2,
     *             "name": "Category 02",
     *             "description": "Description data..",
     *         }
     *     ]
     * }
     */
    public function index() :JsonResponse
    {
        try {
            $categories = Category::all();
    
            return response()->json([
                'status' => true,
                'message' => 'All categories fetched successfully.',
                'data' => CategoryResource::collection($categories)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong!',
            ]);
        }
    }

    /**
     * Create Category
     *
     * @authenticated
     * @header Authorization Bearer {token}
     * 
     * @bodyParam name string required The name of the category. Example: "Technology"
     * @bodyParam description string The description of the category. Example: "All things related to technology"
     *
     * @response 201 {
     *     "status": true,
     *     "message": "Category Created successfully.",
     *     "data": {
     *         "id": 1,
     *         "name": "Technology",
     *         "description": "All things related to technology",
     *         "created_at": "2025-03-03T10:00:00",
     *         "updated_at": "2025-03-03T10:00:00"
     *     }
     * }
     * @response 400 {
     *     "status": false,
     *     "message": "The name field is required."
     * }
     */
    public function store(CategoryRequest $request) :JsonResponse
    {
        $data = $request->validated();

        try {
            $category = Category::create($data);
    
            return response()->json([
                'status' => true,
                'message' => 'Category Created successfully.',
                'data' => new CategoryResource($category)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong!',
            ]);
        }

    }

    /**
     * Show Category
     * 
     * @authenticated
     * @header Authorization Bearer {token}
     *
     * @urlParam id integer required The ID of the get.
     * 
     * @response 200 {
     *     "status": true,
     *     "message": "Category Fetched successfully.",
     *     "data": {
     *         "id": 1,
     *         "name": "Technology",
     *         "description": "All things related to technology",
     *         "created_at": "2025-03-03T10:00:00",
     *         "updated_at": "2025-03-03T10:00:00"
     *     }
     * }
     * @response 404 {
     *     "status": false,
     *     "message": "Category Not Found!",
     * }
     */
    public function show(int $id) :JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
    
            return response()->json([
                'status' => true,
                'message' => 'Category Fetched successfully.',
                'data' => new CategoryResource($category)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Category Not Found!",
            ]);
        }
    }

    /**
     * Update Category
     *
     * @authenticated
     * @header Authorization Bearer {token}
     * 
     * @urlParam id integer required The ID of the get.
     * 
     * @bodyParam name string The updated name of the category. Example: "Science"
     * @bodyParam description string The updated description of the category. Example: "All things related to science"
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Category Updated successfully.",
     *     "data": {
     *         "id": 1,
     *         "name": "Science",
     *         "description": "All things related to science",
     *         "created_at": "2025-03-03T10:00:00",
     *         "updated_at": "2025-03-03T10:00:00"
     *     }
     * }
     */
    public function update(CategoryRequest $request, int $id) :JsonResponse
    {
        $data = $request->validated();

        try {
            $category = Category::findOrFail($id);
            $category->update($data);
    
            return response()->json([
                'status' => true,
                'message' => 'Category Updated successfully.',
                'data' => new CategoryResource($category)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }

    }

    /**
     * Remove Category
     *
     * @authenticated
     * @header Authorization Bearer {token}
     * 
     * @urlParam id integer required The ID of the get.
     * 
     * @response 200 {
     *     "status": true,
     *     "message": "Category Deleted successfully."
     * }
     */
    public function destroy(int $id) :JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Category Deleted successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' =>  'No Data Found!',
            ]);
        }
    }
}
