<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $restaurantAreas = Restaurant::leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->select(
                'restaurants.id',
                'restaurants.name',
                'restaurants.image_file_name',
                'areas.area'
            );
        $groupConcatGenles = DB::table('restaurant_genles')
            ->select(
                'restaurant_genles.restaurant_id as id',
                DB::raw('group_concat(genles.genle) as genles'))
            ->leftjoin('genles', 'restaurant_genles.genle_id', '=', 'genles.id')
            ->groupBy('restaurant_genles.restaurant_id');
        $favorites = Favorite::select(
                'favorites.id',
                'favorites.user_id',
                'favorites.restaurant_id',
                'restaurant_areas.name',
                'restaurant_areas.image_file_name',
                'restaurant_areas.area',
                'group_concat_genles.genles',
                'favorites.created_at',
                'favorites.updated_at')
            ->leftjoinsub($restaurantAreas, 'restaurant_areas', 'favorites.restaurant_id', 'restaurant_areas.id')
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'favorites.restaurant_id', 'group_concat_genles.id')
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
