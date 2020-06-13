<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\OfferTrait;
use App\Models\Offer;
use LaravelLocalization;
use App\Http\Requests\OfferRequest;

class OfferController extends Controller
{
	use OfferTrait;


	public function all()
    {
    	$offers = Offer::select('id', 
    		'price',
    		'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
    	)->get();

    	return view('ajaxoffers.all', compact('offers'));
    }

    public function create()
    {
    	return view('ajaxoffers.create');
    }

    public function store(OfferRequest $request)
    {
    	$file_name = $this->saveImage($request->photo, 'images/offers');
    	
        $offer = Offer::create([
            'photo' => $file_name,
            'name_ar' => $request->name_ar,
            'name_en' =>   $request->name_en,
            'price' =>  $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
        ]);

        if ($offer)
            return response()->json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
            ]);

        else
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
    }

    public function delete(Request $request){

        $offer = Offer::find($request->id);   // Offer::where('id','$offer_id') -> first();

        if (!$offer)
            return redirect()->back()->with(['error' => __('messages.offer not exist')]);

        $offer->delete();

        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح',
            'id' =>  $request->id
        ]);

    }

    public function edit(Request $request)
    {
    	$offer = Offer::find($request->offer_id);  // search in given table id only
        if (!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'غير موجود',
            ]);

        $offer = Offer::select('id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')->find($request->offer_id);

        return view('ajaxoffers.edit', compact('offer'));
    }

    public function update(Request $request)
    {
    	$offer = Offer::find($request->id);
        if (!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'غير موجود',
            ]);

        //update data

        $offer->update($request->all());

        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح',
        ]);
    }

}
