
@extends('layouts.admin.app')
@section('content')
<div class="row ms-15 me-15">
    <div class="mi-card ">
        <div class="mi-header info transparent"> LIST OF PRODUCTS : {{ $category->name_en }}</div>
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
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{optional($catProduct->product)->name}} image">
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
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $catProduct)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            <img class="avatar avatar-lg mr-3" src="{{asset('images/business_category')}}/{{$catProduct->image}}"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{ $catProduct->image }} image">
                        </td>
                        <td><a
                                onclick="return confirm('Are you sure to delete')"
                                href="{{ route('admin.business-category.delete-product',['id'=>$catProduct->id,'type'=>$category->type]) }}"> <button
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
