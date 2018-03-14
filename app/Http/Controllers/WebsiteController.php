<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\website;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $website_data = website::all();
        return view('admin.websites.index',compact('website_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.websites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $website = $request->all();
        // 2.luu
        website::create([
            //'field' trong database =>'name tu view'
            'domainName' => $website['domainName'],//lay du lieu tu view co ten la title do vao filled title trong model
            'menuTag' =>$website['menuTag'],
            'numberPage'=>$website['numberPage'],
            'limitOfOnePage'=>$website['limitOfOnePage'],
            'stringFirstPage'=>$website['stringFirstPage'],
            'stringLastPage'=>$website['stringLastPage'],
            'active'=>$website['active'],
            'bodyTag'=>$website['bodyTag']
        ]);
     
         return redirect()->route('website.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $webupdate = website::findOrFail($id);
         return view('admin.websites.edit', compact('webupdate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $webupdate = website::findOrFail($id);

        $webupdate->fill($request->all());

        $webupdate->save();
        return redirect()->route('website.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {// nhut oi cho tao hoi ta ko biet bo mau//
        // cho ta hoi luc minh create song thi lam sao cho no quay lai trang list luon trang index ay
      // kiem tra cai id con ton tai hay khong
            $website_delete= website::findOrFail($id);
        // xoa// no ko lay het kia//findorfail moi lay het chu
            $website_delete->delete();
        // message - Thong diep
            return back();
    }
}
