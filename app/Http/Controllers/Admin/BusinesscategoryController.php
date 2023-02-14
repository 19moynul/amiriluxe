<?php
namespace App\Http\Controllers\Admin;
use App\Enums\Constant;
use App\Enums\Image;
use App\Http\Requests\BusinesscategoryRequest;
use App\Models\Businesscategory;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessBanner;
use App\Models\BusinessCategoryImage;
use App\Models\BusinessCategoryProduct;
use App\Models\Item;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;
use DB;

class BusinesscategoryController extends Controller
{
    public $model;
    public function __construct()
    {
        $this->model = new Businesscategory();
    }
    public function create()
    {
        $modules = Module::get();
        return view('admin-views.businesscategory.create', compact('modules'));
    }
    public function list()
    {
        $sort = request('sort') ? request('sort') : 'DESC';
        $limit = request('limit') ? request('limit') : defaultLimit();
        $data = Businesscategory::filter()->orderBy('id', $sort);
        if ($limit) {
            $data = $data->paginate($limit);
        } else {
            $data = $data->get();
        }
        return view('admin-views.businesscategory.list', compact('data'));
    }
    public function edit($id)
    {
        $modules = Module::get();
        $data = Businesscategory::with('products')->where('id', $id)->first();
        if($data->type == 2){
            $products = BusinessCategoryProduct::where('category_id',$data->id)->pluck('product_id');
        }else{
            $products = [];
        }

        $moduleProducts = Item::where('module_id',$data->module_id)->get();
        return view('admin-views.businesscategory.edit', compact('data', 'modules','products','moduleProducts'));
    }
    public function view($id)
    {
        $data = Businesscategory::where('id', $id)->first();
        return view('admin-views.businesscategory.view', compact('data'));
    }

    public function store(BusinesscategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = ['name_en' => $request->name_en, 'name_hi' => $request->name_hi, 'name_mr' => $request->name_mr, 'module_id' => $request->module_id, 'type' => $request->type, 'sort' => $request->sort, 'status' => $request->status];

            if ($request->has('id')) {
                $bCategory = Businesscategory::where('id', $request->id)->update($data);
                $text = 'updated';
            } else {
                $bCategory = Businesscategory::create($data);
                $text = 'created';
            }

            if($request->type==1){
                if($request->hasFile('images')){
                    $images = [];
                    if ($request->has('id')) {
                        $allImages = BusinessBanner::where(['category_id'=>$request->id])->pluck('image');
                        foreach($allImages as $image){
                            $path = url('/images/brand/').$image;
                            if(file_exists($path)){
                                unlink($path);
                            }
                        }
                    }
                    foreach($request->file('images') as $file){
                        $image = Image::imageUpload($file, '/business_category/');
                        $images[]=['image'=>$image,'category_id'=>$bCategory->id];
                    }
                    BusinessBanner::insert($images);

                }
            }else if($request->type==2){
                if($request->has('id')){
                    BusinessCategoryProduct::where('category_id',$request->id)->delete();
                }
                $products = [];
                foreach($request->products as $product){
                    $products[]=['category_id'=>$bCategory->id,'product_id'=>$product];
                }
                BusinessCategoryProduct::insert($products);
            }

            DB::commit();
            Toastr::success('Data saved successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            Log::error('Businesscategory -> store : ' . $e->getMessage());
            Toastr::error('Sorry something went wrong with server . please try later');
            return redirect()
                ->back()
                ->with('error', serverError());
        }
    }

    public function delete($id)
    {
        Businesscategory::find($id)->delete();
        return redirect()
            ->back()
            ->with('success', 'Data Deleted Successfully');
    }
}
