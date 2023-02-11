@extends('layouts.admin.app')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<div class="row ms-15 me-15">
    <div class="mi-card">
        <div class="mi-header info transparent"> LIST OF BRANDS </div>
        <div class="mi-body">
            <table class="mi-table table table-bordered table-striped" id="brandTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME EN</th>
                        <th>NAME HI</th>
                        <th>NAME MR</th>
                        <th>IMAGE</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> <?php $i=0; ?> @foreach($data as $item) <tr>
                        <td>{{ ++$i }}</td>
                        <td> {{ $item->name_en}} </td>
                        <td> {{ $item->name_hi}} </td>
                        <td> {{ $item->name_mr}} </td>
                        <td> <a href="{{$item->image_url}}"><img width="70" height="50" src="{{$item->image_url}}"
                                    alt=""></a> </td>
                        <td class="mi-action-button"><a href="{{ route('admin.brand.edit',['id'=>$item->id]) }}">
                                <button class="butn warning transparent"><i class="fa fa-edit"></i></button></a><a
                                onclick="return confirm('Are you sure to delete')"
                                href="{{ route('admin.brand.delete',['id'=>$item->id]) }}"> <button
                                    class="butn danger transparent"><i class="fa fa-trash"></i></button></a> </td>
                    </tr> @endforeach </tbody>
            </table>
        </div>
        <div class="mi-footer">
            <div class="float-right"> </div>
        </div>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

<script>
    $("#brandTable").DataTable({
        dom: 'Blfrtip',
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 75, 100]
    });
</script>
@endsection
