<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Restaurant;
use App\Models\Genle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    protected $restaurants;

    private function restaurantsAll(int $UserID = 0)
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
                'favorites.id',
                'favorites.restaurant_id',
                'favorites.user_id'
            )->where('favorites.user_id', $UserID);

            $this->restaurants = Restaurant::select(
                'restaurants.id',
                'restaurants.name',
                'restaurants.detail',
                'restaurants.image_file_name',
                'areas.area',
                'restaurants.open_time',
                'restaurants.close_time',
                'restaurants.max_reserve',
                'group_concat_genles.genles',
                DB::raw('CASE WHEN favorites.id IS NOT NULL THEN favorites.id ELSE 0 END AS favorite_id')
            )
            ->leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'restaurants.id', 'group_concat_genles.id')
            ->leftjoinsub($favorites, 'favorites', 'restaurants.id', 'favorites.restaurant_id');
        } else {
            $this->restaurants = Restaurant::select(
                'restaurants.id',
                'restaurants.name',
                'restaurants.detail',
                'restaurants.image_file_name',
                'areas.area',
                'restaurants.open_time',
                'restaurants.close_time',
                'restaurants.max_reserve',
                'group_concat_genles.genles',
                DB::raw('0 AS favorite_id')
            )
            ->leftjoin('areas', 'restaurants.area_id', '=', 'areas.id')
            ->leftjoinsub($groupConcatGenles, 'group_concat_genles', 'restaurants.id', 'group_concat_genles.id');
        }
        return $this;
    }

    private function searchRestaurantID(Request $request) {
        if ($request->has('id')) {
            $this->restaurants->where('restaurants.id', '=', $request->id);
        }
        return $this;
    }
    private function searchRestaurantName(Request $request)
    {
        if ($request->has('search')) {
            $this->restaurants->where('name', 'like', "%$request->search%");
        }
        return $this;
    }

    private function searchArea(Request $request)
    {
        if (($request->has('area')) && ($request->area != 'All Area')) {
            $this->restaurants->where('area', '=', $request->area);
        }
        return $this;
    }

    private function searchGenle($request)
    {
        if (($request->has('genle')) && ($request->genle != 'All Genle')) {
            $this->restaurants->where('genles', 'like', "%$request->genle%");
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
        if($request->has('userid')) {
            $this->restaurantsAll($request->userid);
        }else{
            $this->restaurantsAll(0);
        }
        $this->searchArea($request)
            ->searchGenle($request)
            ->searchRestaurantName($request);

        if ($this->restaurants) {
            return response()->json([
                'restaurants'
                    => $this->restaurants
                        ->orderby('restaurants.id')
                        ->get()
            ], 200);
        } else {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $value)
    {
        if ($value == 'genles') {
            $response = Genle::select('genle')->get();
        } elseif($value == 'areas') {
            $response = Area::select('area')->get();
        } elseif($value == 'details') {
            $this->restaurantsAll()->searchRestaurantID($request);
            $response = $this->restaurants->get();
        } else {
            $response = null;
        }

        if ($response) {
            return response()->json([
                $value => $response
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not found.'
            ]);
        }
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
