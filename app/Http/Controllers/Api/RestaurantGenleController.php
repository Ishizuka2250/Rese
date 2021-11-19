<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantGenle;
use Illuminate\Http\Request;

class RestaurantGenleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($restaurantID)
    {
        $restaurantGenles = RestaurantGenle::
            leftjoin('genles', 'restaurant_genles.genle_id', '=', 'genles.id')
            ->select(
                'restaurant_genles.id',
                'restaurant_genles.restaurant_id',
                'genles.genle',
                'restaurant_genles.created_at',
                'restaurant_genles.updated_at')
            ->where('restaurant_genles.restaurant_id', $restaurantID)
            ->get();
        if ($restaurantGenles) {
            return response()->json([
                'restaurant_genles' => $restaurantGenles
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not found'
            ], 400);
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
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
