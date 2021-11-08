<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductController extends BaseController
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $product = Product::all();

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

            $input = $request->all(); //instantiate request

            $validator = Validator::make($input, [
                'name' => 'required|unique:products,name,' . $input['name'],
            ]);

            $input['sku'] = createSku($input['name']); //set sku

            if ($validator->fails()) {
                
                return $this->sendError('Validation Error.', $validator->errors(),422);
            }

            $product = Product::create($input);

            return $this->sendResponse($product, 'Product retrieved successfully.' ,201);
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }
}
