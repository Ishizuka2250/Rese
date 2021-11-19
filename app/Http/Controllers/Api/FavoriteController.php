<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Request $reserve, $UserId)
    {
        $subRestaurants = Restaurant::leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->select(
                'restaurants.id',
                'restaurants.name',
                'areas.area'
            );
        $favorites = Favorite::select(
                'favorites.id',
                'favorites.user_id',
                'favorites.restaurant_id',
                'sub_restaurants.name',
                'sub_restaurants.area',
                'favorites.created_at',
                'favorites.updated_at')
            ->leftjoinsub($subRestaurants, 'sub_restaurants', 'favorites.restaurant_id', 'sub_restaurants.id')
            ->where('favorites.user_id', $UserId)
            ->get();
        if ($favorites) {
            return response()->json([
                'favorites' => $favorites
                ], 200);
        }else{
            return response()->json([
                'message' => 'Not found.'
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
