<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
    protected $Reserves;

    public function reservesAll()
    {
        $this->Reserves = Reserve::leftjoin('restaurants', 'reserves.restaurant_id', '=', 'restaurants.id')
            ->select(
                'reserves.id',
                'reserves.user_id',
                'reserves.restaurant_id',
                'restaurants.name',
                'reserves.number',
                'reserves.reserve_date',
                'reserves.reserve_time',
                'reserves.created_at',
                'reserves.updated_at');
        return $this;
    }

    public function searchUserID(Request $request)
    {
        if ($request->has('userid')) {
            $this->Reserves->where('reserves.user_id', '=', $request->userid);
        }
        return $this;
    }

    public function searchRestaurantID(Request $request)
    {
        if ($request->has('restaurantid')) {
            $this->Reserves->where('reserves.restaurant_id', '=', $request->restaurantid);
        }
        return $this;
    }

    public function searchReserveDate(Request $request)
    {
        if ($request->has('date')) {
            $this->Reserves->where('reserves.reserve_date', '=', $request->date);
        }
        return $this;
    }

    public function searchReserveTime(Request $request)
    {
        if ($request->has('time')) {
            $this->Reserves->where('reserves.reserve_time', '=', $request->time);
        }
        return $this;
    }

    public function groupBySum($groupKeys, $targetKey)
    {
        $selectColumns = $groupKeys;
        array_push($selectColumns, DB::raw('SUM(' . $targetKey . ') AS total_reserve'));
        $this->Reserves->select($selectColumns)->groupBy($groupKeys);
        return $this;
    }

    public function reservedTotal(Request $request) {
        $this->reservesAll()
            ->searchRestaurantID($request)
            ->searchReserveDate($request)
            ->searchReserveTime($request)
            ->groupBySum([
                'reserves.restaurant_id',
                'reserves.reserve_date',
                'reserves.reserve_time'], 'reserves.number');
        return $this->Reserves->get();
    }

    public function remaingReservation($targetReserveTime, $reservedTotal, $maxReserve)
    {
        foreach($reservedTotal as $reserved)
        {
            if ($targetReserveTime === $reserved->reserve_time)
            {
                return (int)$maxReserve - (int)$reserved->total_reserve;
            }
        }
        return $maxReserve;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->reservesAll()->searchUserID($request);
        return response()->json([
            'reserves' => $this->Reserves->get()
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
    public function show(Request $request, $value)
    {
        if($value === 'allow') {
            $reservedTotal = $this->reservedTotal($request);
            $restaurant = Restaurant::find($request->restaurantid);
            $reserve = array();
            $open = explode(':', $restaurant->open_time)[0];
            $close = explode(':', $restaurant->close_time)[0];
            for ($hour = $open; $hour <= $close; $hour++)
            {
                array_push($reserve,
                    array(
                        'time' => ($hour . ':00'),
                        'max_reserve' => $this->remaingReservation(
                            ($hour . ':00:00'),
                            $reservedTotal,
                            $restaurant->max_reserve)));
            }
        }

        if ($value) {
            return response()->json([
                $value => $reserve
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
