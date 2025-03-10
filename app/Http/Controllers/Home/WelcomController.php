<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromotedDealer;
use App\Models\Newsletter;
use App\Models\Categorey;
use App\Models\Currenccy;
use App\Models\Offer;

class WelcomController extends Controller
{
    public function index()
    {   
        $sub_categoreys = Categorey::where('sub_categoreys','>','0')->get();

        $offer          = Offer::latest()->first();

        $offers         = Offer::count();

        $promoted_from_inside  = PromotedDealer::where('from_inside','1')->get();
        $promoted_from_unnside = PromotedDealer::where('from_inside','0')->get();

        return view('home.welcome',compact('sub_categoreys','offer','offers',
                                            'promoted_from_inside','promoted_from_unnside'));

    }//end of index

    public function count_call_phone(PromotedDealer $PromotedDealer)
    {
        
        $PromotedDealer->update([
            'count_call_phone' => $PromotedDealer->count_call_phone + 1
        ]);

        return $PromotedDealer->count_call_phone;

    }//end of count call phone


    public function count_call_email(PromotedDealer $PromotedDealer)
    {
        
        $PromotedDealer->update([
            'count_call_email' => $PromotedDealer->count_call_email + 1
        ]);

        return $PromotedDealer->count_call_email;

    }//end of count call email

    public function newsletter(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
        ]);

        $newsletter = Newsletter::where('email', $request->email)->first();
        $local      = app()->getLocale();

        if ($newsletter) {

            return response()->json(['success' => false, 'local'=> $local]);

        } else {

            Newsletter::create($request->all());

            return response()->json(['success' => true, 'local'=> $local]);

        }//end of if

    }//end of newsletter


    public function amount(Request $request)
    {
        $currency  = Currenccy::first(); 
        
        session()->put('product-price', $request->price);

        if ($request->price == null) {

            $totle = number_format(preg_replace('/,/', '', 1 * $currency->amount),2);

            
        } else {

            $totle = number_format(preg_replace('/,/', '', $request->price * $currency->amount),2);

        }//end of if

        session()->put('product-totle_price', $currency);

        $cry = app()->getLocale() == 'ar' ? 'ج س' : 'SDG';

        return response()->json(['price' => $totle , 'cry' => $cry]);

    }//end of amount


    public function amountDecount(Request $request)
    {
        $currency  = Currenccy::first(); 
        
        session()->put('product-decount-price', $request->price);

        if ($request->price == null) {

            $totle = number_format(preg_replace('/,/', '', 1 * $currency->amount),2);

            
        } else {

            $totle = number_format(preg_replace('/,/', '', $request->price * $currency->amount),2);

        }//end of if

        session()->put('product-totle_price', $currency);

        $cry = app()->getLocale() == 'ar' ? 'ج س' : 'SDG';

        return response()->json(['price' => $totle , 'cry' => $cry]);

    }//end of amount decount
    
}//end of controller
