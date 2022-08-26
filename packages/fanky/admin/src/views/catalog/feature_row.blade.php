<tr id="param{{ $feat->id }}">
    <td>{{ $feat->image }}</td>
    <td>{{ $feat->text }}</td>
    <td>{{ $feat->order }}</td>
    <td>
{{--        <a href="{{ route('admin.catalog.edit_param', [$feat->id]) }}" class="btn btn-default edit-param" onclick="editParam(this, event)">--}}
{{--            <i class="fa fa-pencil text-yellow"></i></a>--}}
{{--        <a href="{{ route('admin.catalog.del_param', [$feat->id]) }}" class="btn btn-default del-param" onclick="delParam(this, event)">--}}
{{--            <i class="fa fa-trash text-red"></i></a>--}}
    </td>
</tr>
