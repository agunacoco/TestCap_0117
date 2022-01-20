<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConcertController extends Controller
{
    public function create(){

        return view('concerts.create');
    }

    public function store(Request $request){

        $this->validate($request,[
            'category_id' => 'required',
            'startDate' => 'required', 
            'endDate' => 'required',
            'title' => 'required',
            'desc' => 'required|min:3', 
            'artist' => 'required',
            'price' => 'required',
            'openDate' => 'required',
            'closeDate' => 'required',
            'playTime' => 'required',
            'reEndDate' => 'required',
        ]);

        // 이미지가 없어서 파일이름이나 고칠게 없음.
        // 바로 create 메소드 사용.
        // category_id는 임의로 지정.
        $input = array_merge($request->all(), ['category_id'=>1]);
        Concert::create($input);

        return redirect()->route('concerts.index');
    }
       
    public function index(){

        $concert = Concert::all();

        return view('concerts.index', ['concerts'=>$concert]);
    }

    public function show($id){

        $concert = Concert::find($id);

        return view('concerts.show', ['concert'=>$concert]);
    }
  
}
