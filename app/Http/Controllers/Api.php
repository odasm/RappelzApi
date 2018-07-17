<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CharInfo;
use App\Models\PAuth;
use Illuminate\Support\Facades\DB;

class Api extends Controller
{
    function DeleteUser(Request $req)
    {
        if ($data = PAuth::where('account', $req->name)->first()) {
            $data->update(['account' => "@$data->account"]);
            return response(['status' => true], 200);
        }
        return response(['status' => false, 'msg' => 'الحساب غير موجود'], 200);
    }

    function unDeleteUser(Request $req)
    {
        if ($data = PAuth::where('account', "@$req->name")->first()) {
            $data->update(['account' => $req->name]);
            return response(['status' => true], 200);
        }
        return response(['status' => false, 'msg' => 'الحساب غير موجود'], 200);
    }

    function GetShopPoint(Request $req)
    {
        $data = PAuth::where('account', $req->name)->first();
        return response(['status' => true, 'data' => $data ? $data->point : 0], 200);
    }

    public function PlayerShopPoint(Request $req)
    {
        if ($data = PAuth::where('account', $req->name)->first()) {
            $data->point += $req->take == 'true' ? -intval($req->point) : intval($req->point);
            $data->update(['point' => $data->point]);
            return response(['status' => true], 200);
        }
        return response(['status' => false, 'msg' => 'الحساب غير موجود'], 200);
    }

    public function CreateUser(Request $req)
    {
        $profile = ['account' => $req->username, 'email' => $req->email, 'password' => $req->password];
        if ($data = PAuth::create($profile))
            return response(['status' => true, 'msg' => $data], 200);
        return response(['status' => false], 200);
    }

    public function GetItemInfo(Request $req)
    {
        if ($data = DB::connection('arcadiadb')->table('ItemResource')->where('id', $req->id)->first()) {
            $string = DB::connection('arcadiadb')->table('StringResource')->select('value')->where('code', $data->name_id)->first();
            $stringEn = DB::connection('arcadiadb')->table('StringResource_en')->select('value')->where('code', $data->name_id)->first();
            $dt = [
                'icon' => $data->icon_file_name,
                'ar' => $string ? $string->value : "لم يتم العثور علي الاسم",
                'en' => $stringEn ? $stringEn->value : 'Name not found',
                'type' => $data->type
            ];
            return response(['status' => true, 'data' => $dt], 200);
        }
        return response(['status' => false], 200);
    }

    public function BuyAllItem(Request $req)
    {
        if ($id = PAuth::where('account', $req->name)->first()) {
            foreach ($req->items as $item) {
                $data = DB::connection('billingdb')->table("PaidItem")->insert([
                    'buy_id' => 1,
                    'account_id' => $id->account_id,
                    'avatar_id' => 0,
                    'taken_account_id' => $id->account_id,
                    'taken_avatar_id' => 0,
                    'item_code' => $item['code'],
                    'item_count' => $item['count'],
                    'type' => 1,
                    'rest_item_count' => $item['count'],
                    'confirmed' => 1,
                    'isCancel' => 0
                ]);
            }
            return response(['status' => true], 200);
        }
        return response(['status' => false], 200);
    }

    public function UpdatePassword(Request $req)
    {
        if ($auth = PAuth::where('account', $req->username)->where('email', $req->email)->first()) {
            if ($auth->update(['password' => $req->password]))
                return response(['status' => true], 200);
        }
        return response(['status' => false], 200);
    }

    public function UpdateUserInfo(Request $req)
    {
        if ($auth = PAuth::where('account_id', $req->id)->first()) {
            if ($auth->update(['account' => $req->username, 'email' => $req->email]))
                return response(['status' => true], 200);
        }
        return response(['status' => false], 200);
    }

    function OnlineNow()
    {
        return DB::connection('telecasterdb')->table('Character')->whereRaw('login_time > logout_time')->count();
    }

    function GetPlayersRank($limit = 100)
    {
        $players = CharInfo::where('name', 'not like', '%@%')->where('permission', '!=', 100)->orderBy('lv', 'desc')->take($limit)
            ->orderBy('exp', 'desc')
            ->orderBy('pkc', 'desc')
            ->get();
        return response(['status' => true, 'data' => $players], 200);
    }

    function GetPlayers()
    {
        $data = PAuth::orderBy('account_id', 'asc')->get();
        return response(['status' => true, 'data' => $data], 200);
    }

    function ServerStatue()
    {
        return !(@$f = fsockopen(env('game_ip'), env('game_port'), $errno, $errstr, 30)) ? "لا يعمل" : "يعمل";
    }

    function gethomedata()
    {
        $players = CharInfo::where('name', 'not like', '%@%')
            ->where('permission', '!=', 100)
            ->orderBy('lv', 'desc')->take(10)
            ->orderBy('exp', 'desc')
            ->orderBy('pkc', 'desc')
            ->select('name', 'lv', 'job')->get();
        $fired = PAuth::where('account', 'like', '@')->count();
        return response([
            'Server' => $this->ServerStatue(),
            'online' => $this->OnlineNow(),
            'Accounts' => PAuth::where('account', 'not like', '@')->count(),
            'Characters' => CharInfo::where('name', 'not like', '@')->count(),
            'Ranks' => $players,
            'fired' => $fired,
        ], 200);
    }
}
