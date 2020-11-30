<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = Item::orderBy('id', 'DESC')->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|unique:items'
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'message' => $validator->errors()], 422);

        try {
            $result  = Item::create(['name' => $request->name]);
            $success = true;
            $message = 'Yay! A item has been successfully created.';
        } catch (Exception $e) {
            $result  = [];
            $success = false;
            $message = 'Oops! Unable to create a new item.';
        }

        return response()->json(['success' => $success, 'data' => $result, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(['success' => true, 'data' => Item::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'completed' => 'required|boolean'
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'message' => $validator->errors()], 422);

        $item = Item::find($id);
        if ($item) {
            $item->completed    = $request->completed ? true : false;
            $item->completed_at = $request->completed ? Carbon::now() : null;
            $item->save();
            return response()->json(['success' => true, 'data' => $item]);
        }

        return response()->json(['success' => false, 'message' => 'Data not found!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Data not found!']);
    }
}
