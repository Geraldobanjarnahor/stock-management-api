<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('api_key');
    }

    public function index()
    {
        $items = Item::all();
        return response()->json(['status' => 'success', 'data' => $items], 200);
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found', 'code' => 404], 404);
        }
        return response()->json(['status' => 'success', 'data' => $item], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(), 'code' => 400], 400);
        }

        $item = Item::create($request->only(['name', 'quantity', 'unit_price']));
        return response()->json(['status' => 'success', 'data' => $item], 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found', 'code' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(), 'code' => 400], 400);
        }

        $item->update($request->only(['name', 'quantity', 'unit_price']));
        return response()->json(['status' => 'success', 'data' => $item], 200);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found', 'code' => 404], 404);
        }

        $item->delete();
        return response()->json(['status' => 'success', 'message' => 'Item deleted successfully'], 200);
    }
}