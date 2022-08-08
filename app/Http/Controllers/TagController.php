<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Repository\Tag\TagInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    private $tags;

    public function __construct(TagInterface $tagRepository)
    {
        $this->tags = $tagRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tags->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tagName' => 'required|unique:tags',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }
        $data = $request->all();
        return $this->tags->storeData($data);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'tagName' => 'required|unique:tags,tagName,' . $request->id,

        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }
        $data = $request->all();
        return $this->tags->updateData($data);
    }

    public function deleteTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }

        $id = $request->id;
        return $this->tags->deleteData($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}