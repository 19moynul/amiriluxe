@extends('layouts.admin.app')
@section('content')
<div class="row">
    <style>
        .select2-selection--multiple{
            overflow: hidden !important;
            height: auto !important;
        }
    </style>
    <div class="col-sm-12 m-auto">
        <div class="mi-card">
            <!--start of mi-card-->
            <div class="mi-header info transparent">
                <!--mi card header started-->EDIT BUSINESS CATEGORY </div>
            <!--end of mi card header-->
            <form action="{{ route('admin.business-category.store') }}" method="POST" enctype="multipart/form-data">
                <div class="mi-body">
                    @include('layouts.admin.toaster')
                    <!--mi-card body started--> <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <!--mi-card body started-->
                    <input name="id" type="hidden" value="{{ $data->id }}">
                    <input name="type" type="hidden" value="{{ $data->type }}">

                    <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="input-label" for="title">{{ translate('messages.zone') }} <span class="text-danger">*</span> </label>
                                    <select name="zone_id" id="zone" class="form-control js-select2-custom" required>
                                        <option disabled selected>---{{ translate('messages.select') }}---</option>
                                        @php($zones = \App\Models\Zone::active()->get())
                                        @foreach ($zones as $zone)
                                            <option value="{{ $zone['id'] }}" {{ $data->zone_id==$zone->id?'selected':'' }}>{{ $zone['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="input-label">{{ translate('messages.module') }} <span class="text-danger">*</span></label>
                                    <select name="module_id" required class="form-control js-select2-custom"
                                        data-placeholder="{{ translate('messages.select') }} {{ translate('messages.module') }}"
                                        id="module_select" required>
                                        <option value="" selected disabled>{{ translate('messages.select') }}
                                            {{ translate('messages.module') }}</option>
                                        @foreach (\App\Models\Module::notParcel()->get() as $module)
                                            <option value="{{ $module->id }}" {{ $data->module_id==$module->id?'selected':'' }}>{{ $module->module_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                    <div class="form-group all-fields">
                        <div class="row">
                            <div class="form-group col-sm-8">
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
                            </div>
                            <div class="col-sm-4 m-auto">
                                 <div class="form-group">
                            <label style="margin-top:30px">STATUS</label>
                            <select class="form-control" id="status" name="status">
                                <option selected>SELECT ONE </option>
                                <option value="1" {{ $data->status==1?'selected':'' }}>Active</option>
                                <option value="0" {{ $data->status==0?'selected':'' }}>Inactive</option>
                            </select> </div>
                            </div>
                        </div>

                        <div id="products" class="col-sm-12" style="display:none">
                            <div class="form-group">
                                <label for="">PRODUCTS</label>
                                <select name="products[]" multiple class="form-control choice_item" id="products-field">
                                </select>
                            </div>
                        </div>


                        <div id="images" style="display:none">
                            @for ($i = 0; $i < 3; $i++)
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label for="">IMAGES {{ $i+1 }} </label>
                                                <input type="file" name="images[]" class="form-control">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ translate('messages.banner') }}
                                                    {{ translate('messages.type') }}</label>
                                                <select name="banner_type[]" id="banner_type_{{ $i }}"
                                                    data-id="{{ $i }}" class="form-control"
                                                    onchange="banner_type_change(this.value,this.id)">
                                                    <option value="store">{{ translate('messages.store') }}
                                                        {{ translate('messages.wise') }}</option>
                                                    <option value="item">{{ translate('messages.item') }}
                                                        {{ translate('messages.wise') }}</option>
                                                    <option value="default">{{ translate('messages.default') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4 store_wise"
                                                id="store_wise_{{ $i }}">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ translate('messages.store') }}<span
                                                        class="input-label-secondary"></span></label>
                                                <select name="store_id_{{ $i }}" id="store_id_{{ $i }}"
                                                    class="js-data-example-ajax form-control store_id"
                                                    title="Select Store">

                                                </select>
                                            </div>

                                            <div class="form-group col-sm-4" id="item_wise_{{ $i }}"
                                                style="display:none">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ translate('messages.select') }}
                                                    {{ translate('messages.item') }}</label>
                                                <select name="item_id_{{ $i }}" id="choice_item_{{ $i }}"
                                                    class="form-control js-select2-custom choice_item"
                                                    placeholder="{{ translate('messages.select_item') }}">

                                                </select>
                                            </div>
                                        </div>
                                    @endfor
                        </div>
                        {{-- <div class="form-group">
                            <label for="">IMAGES</label>
                            <input type="file" name="images[]" id="image" class="form-control" multiple>
                        </div> --}}


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


 @push('script_2')
        <script>
            $('#products-field').select2();
            var ZoneId = <?= json_encode($data->zone_id) ?>;
            var zone_id = ZoneId;
            var module_id = <?= json_encode($data->module_id) ?>;

            console.log(zone_id);
            console.log(module_id);

            get_items(true);


            function get_items(intialLoad=false) {
                var nurl = '/admin/item/get-items?module_id=' + module_id;

                if (!Array.isArray(zone_id)) {
                    nurl += '&zone_id=' + zone_id;
                }

                $.get({
                    url: nurl,
                    dataType: 'json',
                    success: function(data) {
                        $('.choice_item').empty().append(data.options);
                        if(intialLoad){
                            var selectedProducts = <?= json_encode($products); ?>;
                            $('#products-field').val(selectedProducts).change();
                        }
                    }
                });
            }



            $(document).on('ready', function() {
                $('#module_select').on('change', function() {
                    if ($(this).val()) {
                        module_id = $(this).val();
                        get_items();
                    }
                });

                $('#zone').on('change', function() {
                    if ($(this).val()) {
                        zone_id = $(this).val();
                        get_items();
                    } else {
                        zone_id = [];
                    }
                });

                $('.js-data-example-ajax').select2({
                    ajax: {
                        url: '/admin/store/get-stores',
                        data: function(params) {
                            return {
                                q: params.term, // search term
                                zone_ids: [zone_id],
                                page: params.page,
                                module_id: module_id
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        __port: function(params, success, failure) {
                            var $request = $.ajax(params);

                            $request.then(success);
                            $request.fail(failure);

                            return $request;
                        }
                    }
                });
                // INITIALIZATION OF DATATABLES
                // =======================================================

                // INITIALIZATION OF SELECT2
                // =======================================================
                // $('.js-select2-custom').each(function () {
                //     var select2 = $.HSCore.components.HSSelect2.init($(this));
                // });
            });
            $('.item_wise').hide();
            $('#default').hide();

            function banner_type_change(order_type, id) {
                var index = $('#' + id).data('id');
                console.log(index);
                if (order_type == 'item') {
                    $('#store_wise_' + index).hide();
                    $('#item_wise_' + index).show();
                    $('#default').hide();
                } else if (order_type == 'store') {
                    $('#store_wise_' + index).show();
                    $('#item_wise_' + index).hide();
                    $('#default').hide();
                } else if (order_type == 'default') {
                    $('#default').show();
                    $('#store_wise_' + index).hide();
                    $('#item_wise_' + index).hide();
                } else {
                    $('#item_wise_' + index).hide();
                    $('#store_wise_' + index).hide();
                    $('#default').hide();
                }
            }
        </script>

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

        // $('#module_id').select2({}).enable(false);
        // $('#type').select2({}).enable(false);

    })


</script>
    @endpush
@endsection
