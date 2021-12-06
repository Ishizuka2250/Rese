<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use App\Models\Restaurant;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\VarDumper;

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

    public function searchUserID($UserID)
    {
        if ($UserID) {
            $this->Reserves->where('reserves.user_id', '=', $UserID);
        }
        return $this;
    }

    public function searchRestaurantID($RestaurantID)
    {
        if ($RestaurantID) {
            $this->Reserves->where('reserves.restaurant_id', '=', $RestaurantID);
        }
        return $this;
    }

    public function searchReserveDate($ReserveDate)
    {
        if ($ReserveDate) {
            $this->Reserves->where('reserves.reserve_date', '=', $ReserveDate);
        }
        return $this;
    }

    public function searchReserveTime($ReserveTime)
    {
        if ($ReserveTime) {
            $this->Reserves->where('reserves.reserve_time', '=', $ReserveTime);
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

    public function reservationTotal($RestaurantID = null, $ReserveDate = null, $ReserveTime = null) {
        $this->reservesAll()
            ->searchRestaurantID($RestaurantID)
            ->searchReserveDate($ReserveDate)
            ->searchReserveTime($ReserveTime)
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

    public function currentReservation($RestaurantID, $ReserveDate)
    {
        $reservedTotal = $this->reservationTotal($RestaurantID, $ReserveDate);
        $restaurant = Restaurant::find($RestaurantID);
        $reserve = array();
        if($restaurant)
        {
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
        return $reserve;
    }

    public function reserveDateCheck($RestaurantID, $ReserveDate, $ReserveTime)
    {
        $restaurant = Restaurant::find($RestaurantID);
        if ($restaurant)
        {
            $cNowDate = new Carbon(Carbon::now()->format('Y-m-d'));
            $cReserveDate = new Carbon($ReserveDate);
            $cNowDateTime = Carbon::now();
            $cReserveDateTime = new Carbon($ReserveDate . ' ' . $ReserveTime);

            if ($cNowDate->gt($cReserveDate)) return false;
            if ($cNowDateTime->gt($cReserveDateTime)) return false;
            
            return true;
        }
    }

    public function reserveNumberCheck($RestaurantID, $ReserveDate, $ReserveTime, $ReserveNumber)
    {
        $currentReserve = $this->currentReservation($RestaurantID, $ReserveDate);
        foreach($currentReserve as $reserve)
        {
            if (($reserve['time'] === $ReserveTime) && ($reserve['max_reserve'] >= (int)$ReserveNumber)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->reservesAll()->searchUserID($request->userid);
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
        $validate = Validator::make($request->all(), Reserve::$rules);
        
        if ($validate->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validate->errors()
            ], 400);
        }

        $this->reservesAll()
            ->searchUserID($request->user_id)
            ->searchRestaurantID($request->restaurant_id)
            ->searchReserveDate($request->reserve_date)
            ->searchReserveTime($request->reserve_time);
        
        if ($this->Reserves->get()->count() > 0)
        {
            return response()->json([
                'success' => 0,
                'errorcode' => 2,
                'message' => '同じ時刻で既に予約が入っています.'
            ], 200);
        }

        if (! $this->reserveDateCheck(
            $request->restaurant_id,
            $request->reserve_date,
            $request->reserve_time
            ))
        {
            return response()->json([
                'success' => 0,
                'errorcode' => 3,
                'message' => '指定の時間は予約できません.'
            ], 200);
        }

        if (! $this->reserveNumberCheck(
            $request->restaurant_id,
            $request->reserve_date,
            $request->reserve_time,
            $request->number))
        {
            return response()->json([
                'success' => 0,
                'errorcode' => 4,
                'message' => '満席のため予約できません.'
            ], 200);
        }
        
        Reserve::create($request->all());

        return response()->json([
            'success' => 1,
            'errorcode' => 0,
            'message' => '予約が完了しました.'
        ], 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request, $UserId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $value)
    {
        if ($value == 'allow') {
            return response()->json([
                $value => $this->currentReservation($request->restaurantid, $request->date)
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
    public function destroy(Request $request, $value)
    {
        if($value != 'delete') return;
        $validate = Validator::make($request->all(), [
            'reserve_id' => ['required', 'numeric'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $request->all()
            ], 400);
        }

        $reserve = Reserve::find($request->reserve_id);
        
        if ($reserve) {
            Reserve::destroy($request->reserve_id);
            return response()->json([
                'success' => 1,
                'errorcode' => 0,
                'message' => '対象の予約を削除しました.'
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'errorcode' => 2,
                'message' => '対象の予約が存在しません.',
                'request' => $request->all()
            ]);
        }
        
    }
}
