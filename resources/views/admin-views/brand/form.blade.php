@extends('layouts.admin.app')
@section('content')
<div class="row">
    <div class="col-sm-6 m-auto">
        <div class="mi-card">
            <!--start of mi-fc-card-->
            <div class="mi-header {{ $status }} transparent">
                <!--mi card header started-->{{ $title }} BRAND </div>
            <!--end of mi card header-->
            <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                <div class="mi-body">
                    <!--mi-card body started--> <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    @if(isset($data)) <input name="id" type="hidden" value="{{ $data->id }}"> @endif
                        <div class="form-group"><label>NAME ENGLISH <b class="text-danger">*</b> </label><input
                                type="text" placeholder="NAME ENGLISH" name="name_en" id="name_en" class="form-control"
                                value="{{ isset($data)?$data->name_en:old('name_en') }}" required> </div>
                        <div class="form-group"><label>NAME HINDI<i class="fas fa-hand-holding-seedling    "></i> </label><input type="text" placeholder="NAME HINDI"
                                name="name_hi" id="name_hi" class="form-control"
                                value="{{ isset($data)?$data->name_hi:old('name_hi') }}"> </div>
                        <div class="form-group"><label>NAME MARATI </label><input type="text" placeholder="NAME MARATI"
                                name="name_mr" id="name_mr" class="form-control"
                                value="{{ isset($data)?$data->name_mr:old('name_mr') }}"> </div>
                        <div class="form-group position-relative"><label>IMAGE <b class="text-danger">*</b> </label>
                            @if(isset($data)) <div class="edit-image"> <a href="{{asset('images'.$data->image)}}"><img
                                        src="{{asset('images'.$data->image)}}" alt=""></a> </div> @endif <input
                                type="file" name="image" id="image" class="form-control {{ $image_class }} "> </div>
                        <div class="form-group col-sm-"><label>STATUS <b class="text-danger">*</b> </label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1" {{ isset($data)?($data->status==1?'selected':''):old('status') }}>Active</option>
                                <option value="0" {{ isset($data)?($data->status==0?'selected':''):old('status') }}>Inactive</option>
                            </select>
                            </div>
                </div>
                <!--end of mi-card-body-->
                <div class="mi-footer">
                    <!--mi-card footer started-->
                    <div class="row">
                        <div class="col-sm-4 m-auto"> <button type="submit" class="butn {{ $status }} w-100">
                                {{ $button_name }} </button> </div>
                    </div>
                </div>
                <!--end of mi-card-footer-->
            </form>
        </div>
        <!--end of mi-fc-card-->
    </div>
</div>
@endsection
