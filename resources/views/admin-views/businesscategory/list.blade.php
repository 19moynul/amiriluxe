@extends('layouts.admin.app')
@section('content')
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/> --}}
 {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/> --}}
<div class="row ms-15 me-15">
    <div class="mi-card ">
        <div class="mi-header info transparent"> LIST OF BUSINESS CATEGORIES </div>
        <div class="mi-body">
            <table class="mi-table table table-bordered table-striped" id="bctable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME ENGLISH</th>
                        <th>SELECT MODULE</th>
                        <th>TYPE</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tablecontents"> <?php $i=0; ?>
                    @foreach($data as $item)
                    <tr class="row1" data-id="{{ $item->id }}">
                        <td>{{ ++$i }}</td>
                        <td> {{ $item->name_en}} </td>
                        <td> {{ optional($item->module)->module_name}} </td>
                        <td> <?php if($item->type == '1'){ echo 'Slider'; }else if($item->type == '2'){ echo 'Category'; } ?>
                        </td>
                        <td class="mi-action-button">
                            <a href="{{ route('admin.business-category.view',['id'=>$item->id]) }}">
                                <button class="butn info transparent"><i class="fa fa-eye"></i></button></a>
                            <a href="{{ route('admin.business-category.edit',['id'=>$item->id]) }}">
                                <button class="butn warning transparent"><i class="fa fa-edit"></i></button></a>
                                <a
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

{{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> --}}
<script>
    $(function () {
        // $('#bctable').DataTable();

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {
            console.log('call api');
        }
    })



</script>
@endsection
