
@extends('layouts.admin.app')
@section('content')
<?php
    use App\Models\Store;
    use App\Models\Item;
?>
<div class="row ms-15 me-15">
    <div class="mi-card ">
        <div class="mi-header info transparent"> LIST OF {{ $category->type==1? 'BANNER':'PRODUCTS'}} : {{ $category->name_en }}</div>
        <div class="mi-body">
            @if($category->type==2)
            <table class="mi-table table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IMAGE</th>
                        <th>PRODUCT NAME</th>
                        <th>STOCK</th>
                        <th>PRICE</th>
                        <th>DISCOUNT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $catProduct)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{optional($catProduct->product)->image}}"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{optional($catProduct->product)->name}} image"width="300px" height="auto">
                                        </td>
                        <td>{{ optional($catProduct->product)->name }}</td>
                        <td>{{ optional($catProduct->product)->stock }}</td>
                        <td>{{ optional($catProduct->product)->price }} INR</td>
                        <td>{{ optional($catProduct->product)->discount }} {{ optional($catProduct->product)->discount_type=='percent'?'%':'INR' }}</td>
                        <td><a
                                onclick="return confirm('Are you sure to delete')"
                                href="{{ route('admin.business-category.delete-product',['id'=>$catProduct->id,'type'=>$category->type]) }}"> <button
                                    class="butn danger transparent"><i class="fa fa-trash"></i></button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <table class="mi-table table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IMAGE</th>
                        <th>TYPE</th>
                        <th>STORE/ITEM</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $banner)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            <img class="avatar avatar-lg mr-3" src="{{ $banner->image_url }}"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{ $banner->image }} image">
                        </td>
                        <td>{{ $banner->type }}</td>
                        <td>
                            <?php
                                if($banner->type=='store'){
                                    echo Store::where('id',$banner->data_id)->first()->value('name');
                                }
                                if($banner->type=='item'){
                                    echo Item::where('id',$banner->data_id)->first()->value('name');
                                }
                            ?>
                        </td>

                        <td><a
                                onclick="return confirm('Are you sure to delete')"
                                href="{{ route('admin.business-category.delete-product',['id'=>$banner->id,'type'=>$category->type]) }}"> <button
                                    class="butn danger transparent"><i class="fa fa-trash"></i></button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
