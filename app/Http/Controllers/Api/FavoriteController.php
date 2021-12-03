<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    protected $Favorites;

    public function favoritesAll() {
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
        $this->Favorites = Favorite::select(
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
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'favorites.restaurant_id', 'group_concat_genles.id');
        return $this;
    }

    public function searchUserID($UserID) {
        if ($UserID) {
            $this->Favorites->where('favorites.user_id', '=', $UserID);
        }
        return $this;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->favoritesAll()
            ->searchUserID($request->user_id);

        if ($request->user_id) {
            return response()->json([
                'favorites' => $this->Favorites->get()
                ], 200);
        }else{
            return response()->json([
                'message' => 'Not found.'
            ], 200);
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
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
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
