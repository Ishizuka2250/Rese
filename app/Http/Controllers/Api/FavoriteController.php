<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function searchRestaurantID($RestaurantID) {
        if ($RestaurantID) {
            $this->Favorites->where('favorites.restaurant_id', '=', $RestaurantID);
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
            ->searchUserID($request->user_id)
            ->searchRestaurantID($request->restaurant_id);

        if ($request->user_id) {
            return response()->json([
                'favorites' => $this->Favorites->get()
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
        $validate = Validator::make($request->all(), Favorite::$rules);

        if ($validate->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validate->errors()
            ], 400);
        }

        $this->favoritesAll()
            ->searchUserID($request->user_id)
            ->searchRestaurantID($request->restaurant_id);

        if ($this->Favorites->get()->count() > 0) {
            return response()->json([
                'success' => 0,
                'errorcode' => 2,
                'message' => '既にお気に入り登録されています.'
            ], 200);
        }

        Favorite::create($request->all());

        return response()->json([
            'success' => 1,
            'errorcode' => 0,
            'message' => 'お気に入り登録が完了しました.'
        ], 201);
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
    public function destroy(Request $request, $value)
    {
        if ($value != 'delete') return;
        $validate = Validator::make($request->all(), [
            'favorite_id' => ['required', 'numeric']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validate->errors()
            ], 400);
        }

        $favorite = Favorite::find($request->favorite_id);

        if ($favorite) {
            Favorite::destroy($request->favorite_id);
            return response()->json([
                'success' => 1,
                'errorcode' => 0,
                'message' => '対象のお気に入りを削除しました.'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'errorcode' => 2,
                'message' => '対象のお気に入りが存在しません.'
            ], 200);
        }
    }
}
