<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ImageUploadRequest;
use App\Repository\Category\CategoryInterface;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ImageUploadTrait;

    private $categories;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->categories->getAllData();
    }


    public function imgUpload(ImageUploadRequest $request)
    {
        return $this->CategoryImageUpload($request->file);//Passing file as parameter to trait   
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }

    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path().$fileName;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        return $this->categories->storeData($data);
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
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        return $this->categories->updateData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->deleteFileFromServer($request->iconImage);
        $id = $request->id;
        return $this->categories->deleteData($id);
    }
}