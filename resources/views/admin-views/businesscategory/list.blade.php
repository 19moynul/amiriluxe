@extends('layouts.admin.app')
@section('content')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
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

<script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
    jQuery.noConflict();
    jQuery(document).ready(function($) {
        $('#bctable').DataTable();

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('business-category.sortable') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
    });



</script>
@endsection
