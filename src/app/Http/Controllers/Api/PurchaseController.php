<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class PurchaseController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $product = Purchase::where('user_id', $user->id)
                ->with('product:sku,name')
                ->get()
                ->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'user_id' => $data->user_id,
                        'product_sku' => $data->product_sku,
                        'product_name' => $data->product->name,
                        'created_at' => $data->created_at
                    ];
                });

            return $this->sendResponse($product, 'Product retrieved successfully.');
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['product_sku' => 'required|exists:products,sku']);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }


            $purchaseChecker = Purchase::where('product_sku', $request->input('product_sku'))
                ->where('user_id', Auth::user()->id)
                ->exists(); //check if a user has already purchased a product and prevent the user from buying twice

            if ($purchaseChecker) {
                return $this->sendError('Purchase Error.', 'You already have this item purchased.', 422);
            }


            $product = Purchase::create($request->all());

            return $this->sendResponse($product, 'Purchase recorded attached successfully.', 201);
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($productSku)
    {
        try {

            $validator = Validator::make(['product_sku' => $productSku], ['product_sku' => 'required|exists:purchases,product_sku']);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $purchase = Purchase::where('product_sku', $productSku)
                ->where('user_id', Auth::user()->id);

            if (!$purchase->exists()) { //prevent user from attempting to delete product they have not purchased

                return $this->sendError('Purchase Error.', 'You do not have this item purchased.', 422);
            }

            $purchase = $purchase->delete();

            return $this->sendResponse([], 'Purchase Record detached successfully.');
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }
}
