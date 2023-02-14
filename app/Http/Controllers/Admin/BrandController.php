<?php
namespace App\Http\Controllers\Admin;
use App\Enums\Constant;
use App\Enums\Image;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;
use DB;

class BrandController extends Controller
{
    public $model;
    public function __construct()
    {
        $this->model = new Brand();
    }
    public function create()
    {
        return view('admin-views.brand.store');
    }
    public function list()
    {
        $sort = request('sort') ? request('sort') : 'DESC';
        $limit = request('limit') ? request('limit') : defaultLimit();
        $data = Brand::filter()->orderBy('id', $sort);
        if ($limit) {
            $data = $data->paginate($limit);
        } else {
            $data = $data->get();
        }
        return view('admin-views.brand.list', compact('data'));
    }
    public function edit($id)
    {
        $data = Brand::where('id', $id)->first();
        return view('admin-views.brand.store', compact('data'));
    }
    public function view($id)
    {
        $data = Brand::where('id', $id)->first();
        return view('admin-views.brand.view', compact('data'));
    }

    public function store(BrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = ['name_en' => $request->name_en, 'name_hi' => $request->name_hi, 'name_mr' => $request->name_mr, 'status' => $request->status];
            if ($request->hasFile('image')) {
                if ($request->has('id')) {
                    $image = Brand::where('id', $request->id)->value('image');
                    if ($image) {
                        Image::deleteImage('', $image);
                    }
                }
                $image = Image::imageUpload($request->file('image'), '/brand/');
                $data['image'] = $image;
            }
            if ($request->has('id')) {
                Brand::where('id', $request->id)->update($data);
                $text = 'updated';
            } else {
                Brand::insert($data);
                $text = 'created';
            }
            DB::commit();
            Toastr::success('Brand '.$text.' successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Brand -> store : ' . $e->getMessage());
            Toastr::error('Sorry , Something went wrong. please try later');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $record = Brand::find($id);
        if ($record->delete()) {
            Image::deleteImage('', $record->image);
        }
        Toastr::success('Brand deleted successfully');
        return redirect()->back();
    }
}
