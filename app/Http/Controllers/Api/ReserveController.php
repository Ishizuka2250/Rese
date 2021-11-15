<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reserves = Reserve::all();
        return response()->json([
            'reserves' => $reserves
        ], 200);
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
     * @param  \Illuminate\Http\Request  $request, $UserId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $reserve, $UserId)
    {
        $reserves = Reserve::leftjoin('restaurants', 'reserves.restaurant_id', '=', 'restaurants.id')
                    ->select(
                        'reserves.id',
                        'reserves.user_id',
                        'restaurants.name',
                        'reserves.number',
                        'reserves.reserve_date',
                        'reserves.created_at',
                        'reserves.updated_at')
                    ->where('user_id', $UserId)
                    ->get();
        if ($reserves) {
            return response()->json([
                'reserves' => $reserves
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserve $reserve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserve $reserve)
    {
        //
    }
}
