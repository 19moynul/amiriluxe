@extends('layouts.admin.app')
@section('content')
<div class="row">
    <div class="mi-card">
        <div class="mi-header"> LIST OF BUSINESSCATEGORYS </div>
        <div class="mi-body">
            <table class="mi-table table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME ENGLISH</th>
                        <th>SELECT MODULE</th>
                        <th>TYPE</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> <?php $i=0; ?> @foreach($data as $item) <tr>
                        <td>{{ ++$i }}</td>
                        <td> {{ $item->name_en}} </td>
                        <td> {{ $item->module->module_name}} </td>
                        <td> <?php if($item->type == '1'){ echo 'Slider'; }else if($item->type == '2'){ echo 'Category' } ?>
                        </td>
                        <td class="mi-action-button"><a href="{{ route('admin.business-category.edit',['id'=>$item->id]) }}">
                                <button class="butn warning transparent"><i class="fa fa-edit"></i></button></a><a
                                onclick="return confirm('Are you sure to delete')"
                                href="{{ route('admin.business-category.delete',['id'=>$item->id]) }}"> <button
                                    class="butn danger transparent"><i class="fa fa-trash"></i></button></a> </td>
                    </tr> @endforeach </tbody>
            </table>
        </div>
        <div class="mi-footer">
            <div class="float-right"> </div>
        </div>
    </div>
</div>
@endsection
