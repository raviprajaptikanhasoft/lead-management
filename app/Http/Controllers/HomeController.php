<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = Information::with('user')->orderBy('id', 'DESC');
        
        if (Auth::user()->isadmin === 0) {
            $query->where('user_id', Auth::id());
        }
       
        $infoData = $query->get();

        return view('home', ["data" => $infoData]);
    }

    public function storeRecords(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'text1' => 'required',
                'text2' => 'required',
                'text3' => 'required',
                'text4' => 'required',
            ]);
            Information::create([
                'text1' => $request->text1,
                'text2' => $request->text2,
                'text3' => $request->text3,
                'text4' => $request->text4,
                'text5' => $request->text5,
                'text6' => $request->text6,
                'text7' => $request->text7,
                'text8' => $request->text8,
                'text9' => $request->text9,
                'user_id' => Auth::user()->id,
            ]);
            Session::flash('status', 'Information added successfully');
            return redirect(route("home"));
        } catch (Exception $e) {
            print_r($e->getMessage());
            exit;
        }
    }
}
