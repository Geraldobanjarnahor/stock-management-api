<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('api_key');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(), 'code' => 400], 400);
        }

        $item = Item::find($request->item_id);
        if ($request->type === 'OUT' && $item->quantity < $request->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Insufficient stock', 'code' => 400], 400);
        }

        DB::beginTransaction();
        try {
            $transaction = StockTransaction::create($request->all());
            if ($request->type === 'IN') {
                $item->quantity += $request->quantity;
            } else {
                $item->quantity -= $request->quantity;
            }
            $item->save();
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $transaction], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Transaction failed', 'code' => 500], 500);
        }
    }

    public function index(Request $request)
    {
        $query = StockTransaction::query();
        if ($request->has('item_id')) {
            $query->where('item_id', $request->item_id);
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $transactions = $query->get();
        return response()->json(['status' => 'success', 'data' => $transactions], 200);
    }

    public function stockReport()
    {
        $items = Item::select('id', 'name', 'quantity', 'unit_price')
            ->get()
            ->map(function ($item) {
                $item->total_value = $item->quantity * $item->unit_price;
                return $item;
            });
        return response()->json(['status' => 'success', 'data' => $items], 200);
    }
}