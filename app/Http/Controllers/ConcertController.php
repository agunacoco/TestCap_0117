<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConcertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // query()는 쿼리스트링에서만 값을 조회.
        $query = Concert::query();
        $query = applyDefaultFSW($request,$query);
        dd($query);
        
        // $q = $request->get('search');
        // // Fulltext * 부분 제외 -  " " 로 묶으면 단어 합치기
        // if($q){
        //     $query->whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", $q);
        // }

        // return new ShopCollection($query->paginate($request->get('per_page') ?: 50));
        return response()->json($concerts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $this->validate($request,[
        //     'category_id' => 'required',
        //     'startDate' => 'required', 
        //     'endDate' => 'required',
        //     'title' => 'required',
        //     'poster' => 'required',
        //     'desc' => 'required|min:3', 
        //     'artist' => 'required',
        //     'price' => 'required',
        //     'openDate' => 'required',
        //     'closeDate' => 'required',
        //     'playTime' => 'required',
        //     'reEndDate' => 'required',
        // ]);

        // $request->merge([
        //     // category_id는 임의로 설정함.
        //     'category_id' => 1 
        // ]);

        if($request->file('poster')){
            // $fileName = $request->title.'_'.$request->file('poster')->getClientOriginalName(); // poster 이름 변경
            $path = $request->file('poster')->store('posters', 's3'); // s3에 image 저장.
            $path = Storage::disk('s3')->url($path);
        }

        dd($path);
        $input = array_merge($request->all(), ['poster'=>$path]);

        $concert = Concert::create($input);

        return response()->json($concert, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Concert $concert)
    {
        return response()->json($concert);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Concert $concert)
    {
        // 수정해야함.
        return response()->json($concert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concert $concert)
    {
        $concert->delete();

        return response()->json($concert);
    }
}
