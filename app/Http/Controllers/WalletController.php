<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\History;
use Carbon\Carbon;

class WalletController extends Controller
{
    //
    public function transfer(Request $request)
    {
        $cek_phone_number = User::where('phone_number' , $request->phone_number)->first();
        $user_login_phone_number = auth()->user()->phone_number;
        $message = $request->message;
        if(empty($cek_phone_number)){
            return response()->json(['error' => 'Nomor tersebut tidak ditemukan ']);
        }
        else if($request->phone_number == $user_login_phone_number){
            return response()->json(['error' => 'Nomor tujuan tidak boleh sama dengan nomor user login']);
        }
        else if($request->nominal < 1 || $request->nominal > 1000000){
            return response()->json(['error' => 'Nominal harus diatas Rp 1 - Rp 1.000.000 ']);
        }
        else if($request->nominal > auth()->user()->saldo){
            return response()->json(['error' => 'Nominal yang anda masukkan melebihi dari jumlah saldo yang anda miliki']);
        }
        // return $cek_phone_number;
        $update_saldo_penerima = User::find($cek_phone_number->id)->update(['saldo' => $cek_phone_number->saldo + $request->nominal]);
        $update_saldo_pengirim = User::find(auth()->user()->id)->update(['saldo' => auth()->user()->saldo - $request->nominal ]);

        $create_history_transfer = History::insert([
            'user_id' => auth()->user()->id,
            'nominal' => $request->nominal,
            'message' => $message,
            'status' => 'transfer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $create_history_terima = History::insert([
            'user_id' => $cek_phone_number->id,
            'nominal' => $request->nominal,
            'message' => $message,
            'status' => 'terima',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['status' => 'transfer sukses'], 200);

    }

    public function history(Request $request)
    {
        $history = History::where('user_id' , auth()->user()->id)->get();
        return $history;
    }

    public function detailHistory(Request $request)
    {
        $id = $request->id;
        $history = History::where('id', $id)->where('user_id', auth()->user()->id)->first();
        return $history;
    }

    public function jenisTransaksi(Request $request)
    {
        $status = $request->status;
        $history = History::where('user_id', auth()->user()->id)->where('status' , $status)->get();
        return $history;
    }

    public function sortDateOld(Request $request)
    {
        // $date = $request->date;
        $history = History::where('user_id', auth()->user()->id)->orderBy('created_at' , 'asc')->get();
        return $history;
    }
    public function sortDateNew(Request $request)
    {
        // $date = $request->date;
        $history = History::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return $history;
    }
}
