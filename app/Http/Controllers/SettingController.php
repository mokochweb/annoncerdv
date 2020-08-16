<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $data = array();
        if($request->has('receive_new_post_email'))
        {
            $data['receive_new_post_email'] = 'yes';
        } 
        else 
        {
            $data['receive_new_post_email'] = 'no';
        }

        \Auth()->user()->settings()->update($data);
        toastr()->success('Settings updated successfully.');
        
        return back();
    }
}
