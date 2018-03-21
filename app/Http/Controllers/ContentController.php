<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\RSS;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content= Content::all();
        return view('admin.contents.index',compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rsss = RSS::pluck('domainName', 'domainName');
        return view('admin.contents.create', compact('rsss'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $con= new content();
        $con->fill($request->except('pubDate'));
        $con->pubDate = date('Y-m-d H:i:s');
        $con->save();
        return redirect()->route('content.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rsss = RSS::pluck('domainName', 'domainName');
        $edit = content::findorfail($id);
        return view('admin.contents.edit',compact('edit', 'rsss'));
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
        $edit = content::findorfail($id);
        $edit->fill($request->except('pubDate'));
        $edit->save();
        return redirect()->route('content.index');

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
    public function destroy($id, Request $request)
    {
        $ids = $request->input('idCheckbox');
        if($ids != null)
            Content::whereIn('id', $ids)->delete(); 
        return back();
    }

    public function active(Request $request) {
        $id = $request->input('id');
        $model = Content::findorfail($id);
        $model->active = !$model->active;
        $model->save();
    }
}
