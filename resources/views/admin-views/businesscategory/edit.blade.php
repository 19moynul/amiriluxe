@extends('layouts.admin.app')
@section('content')
<div class="row">
    <style>
        .select2-selection--multiple{
            overflow: hidden !important;
            height: auto !important;
        }
    </style>
    <div class="col-sm-7 m-auto">
        <div class="mi-card">
            <!--start of mi-card-->
            <div class="mi-header info transparent">
                <!--mi card header started-->EDIT BUSINESS CATEGORY </div>
            <!--end of mi card header-->
            <form action="{{ route('admin.business-category.store') }}" method="POST" enctype="multipart/form-data">
                <div class="mi-body">
                    @include('layouts.admin.toaster')
                    <!--mi-card body started--> <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group ">
                        <label>TYPE (CAN'T CHANGE)<b class="text-danger">*</b> </label>
                        <select class="form-control" id="type" name="type" id="type" required>
                            <option selected>SELECT ONE </option>
                            <option value="1" {{ $data->type==1?'selected':'' }} >Slider</option>
                            <option value="2" {{ $data->type==2?'selected':'' }}>Category</option>
                        </select> </div>

                    <div class="form-group all-fields">
                        <nav class="mi-tab">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">NAME ENGLISH </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">NAME HINDI</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                    role="tab" aria-controls="nav-contact" aria-selected="false">NAME MARATHI</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="form-group ">
                                    <label for="">NAME ENGLISH <b
                                        class="text-danger">*</b></label>
                                    <input type="text" placeholder="NAME ENGLISH" name="name_en" id="name_en"
                                        class="form-control" value="{{ $data->name_en }}" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <div class="form-group ">
                                    <label for="">NAME HINDI</label>
                                    <input type="text" placeholder="NAME HINDI" name="name_hi" id="name_hi"
                                        class="form-control" value="{{ $data->name_hi }}">

                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
                                <div class="form-group ">
                                    <label for="">NAME MARATHI</label>
                                    <input type="text" placeholder="NAME MRATHI" name="name_mr" id="name_mr"
                                        class="form-control" value="{{ $data->name_mr }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>SELECT MODULE (CAN'T CHANGE) <b class="text-danger">*</b> </label>
                            <select class="form-control" id="module_id" name="module_id" required>
                                <option selected>SELECT ONE </option>
                                @foreach($modules as $option)
                                <option value="{{ $option->id }}" {{ $option->id==$data->module_id?'selected':'' }}>{{ $option->module_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="products" style="display:none">
                            <div class="form-group" >
                                <label for="">PRODUCTS</label>
                                <select name="products[]" multiple class="form-control" id="products-field">
                                    <option value="select one"></option>
                                    @foreach($moduleProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="images" style="display:none">
                            <label for="">IMAGES</label>
                            <input type="file" name="images[]" id="image" class="form-control" multiple>
                        </div>

                        <div class="form-group">
                            <label>STATUS</label>
                            <select class="form-control" id="status" name="status">
                                <option selected>SELECT ONE </option>
                                <option value="1" {{ $data->status==1?'selected':'' }}>Active</option>
                                <option value="0" {{ $data->status==0?'selected':'' }}>Inactive</option>
                            </select> </div>
                    </div>
                    <!--end of mi-card-body-->
                    <div class="mi-footer">
                        <!--mi-card footer started-->
                        <div class="row">
                            <div class="col-sm-4 m-auto"> <button type="submit" class="butn info w-100"> Create
                                </button> </div>
                        </div>
                    </div>
                    <!--end of mi-card-footer-->
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        var type = <?= $data->type ?>;

        if(type==1){
            $('#images').css('display', 'block');
        }else{
            $('#products').css('display', 'block');
             $('#products-field').select2({});
            var selectedProducts = <?= json_encode($products); ?>;
            $('#products-field').val(selectedProducts).change();
        }

        $('#module_id').select2({}).enable(false);
        $('#type').select2({}).enable(false);

    })


</script>
<!--end of mi-card-->
@endsection
