<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->userid) {
            $restaurants = $this->restaurants($request->userid)->get();
        }else{
            $restaurants = $this->restaurants(0)->get();
        }

        if ($restaurants) {
            return response()->json([
                'restaurants' => $restaurants
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found.'
            ], 200);
        }
    }

    private function restaurants(int $UserID)
    {
        $groupConcatGenles = DB::table('restaurant_genles')
            ->select(
                'restaurant_genles.restaurant_id AS id',
                DB::raw('GROUP_CONCAT(genles.genle) AS genles'))
            ->leftjoin('genles', 'restaurant_genles.genle_id', '=', 'genles.id')
            ->groupBy('restaurant_genles.restaurant_id');

        if ($UserID) {
            $favorites = DB::table('favorites')
            ->select(
                'favorites.restaurant_id',
                'favorites.user_id'
            )->where('favorites.user_id', $UserID);

            $restaurants = Restaurant::select(
                'restaurants.id',
                'restaurants.name',
                'areas.area',
                'group_concat_genles.genles',
                DB::raw('CASE WHEN favorites.user_id IS NOT NULL THEN True ELSE False END AS favorite')
            )
            ->leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'restaurants.id', 'group_concat_genles.id')
            ->leftjoinsub($favorites, 'favorites', 'restaurants.id', 'favorites.restaurant_id');
        } else {
            $restaurants = Restaurant::select(
                'restaurants.id',
                'restaurants.name',
                'areas.area',
                'group_concat_genles.genles',
                DB::raw('False AS favorite')
            )
            ->leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'restaurants.id', 'group_concat_genles.id');
        }
        return $restaurants;
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
    public function show(Request $request)
    {
        
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
