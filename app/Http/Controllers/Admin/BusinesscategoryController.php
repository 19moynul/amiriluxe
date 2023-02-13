<?php
            namespace App\Http\Controllers\Admin;
            use App\Enums\Constant;
            use App\Enums\Image;
            use App\Http\Requests\BusinesscategoryRequest ;
            use App\Models\Businesscategory;
            use App\Models\Module;
            use Illuminate\Http\Request;
            use App\Http\Controllers\Controller;
            use Illuminate\Support\Facades\Log;
            use DB;


            class BusinesscategoryController extends Controller
{
public $model; public function __construct() { $this->model = new Businesscategory();  }
  public function create(){  $modules = Module::get(); return view('admin-views.businesscategory.create' ,compact('modules') );  }
 public function list(){  $sort = request('sort')?request('sort'):'DESC'; $limit = request('limit')?request('limit'):defaultLimit(); $data = Businesscategory::filter()->orderBy('id',$sort); if($limit){  $data = $data->paginate($limit);  }else{  $data = $data->get();  }  return view('admin-views.businesscategory.list',compact('data'));  } public function edit($id){  $modules = Module::get(); $data = Businesscategory::where('id',$id)->first(); return view('admin-views.businesscategory.edit',compact('data','modules'));  }  public function view($id){  $data = Businesscategory::where('id',$id)->first(); return view('admin-views.businesscategory.view',compact('data'));  }


 public function store(BusinesscategoryRequest $request){ DB::beginTransaction(); try{ $data = [ 'name_en'=>$request->name_en ,'name_hi'=>$request->name_hi ,'name_mr'=>$request->name_mr ,'module_id'=>$request->module_id ,'type'=>$request->type ,'sort'=>$request->sort ,'status'=>$request->status , ];  if($request->has('id')){ Businesscategory::where('id', $request->id)->update($data); $text = 'updated'; }else{ Businesscategory::insert($data); $text = 'created'; } DB::commit(); return redirect()->back()->with('success','business_category has been ' . $text . ' successfully'); }catch(\Exception $e){ DB::rollback(); Log::error('Businesscategory -> store : '.$e->getMessage());return redirect()->back()->with('error', serverError()); } }

 public function delete($id){  Businesscategory::find($id)->delete() ; return redirect()->back()->with('success','Data Deleted Successfully');  }
}
