@section('page_name')
    <h1>Каталог
        <small>{{ $catalog->name }}</small>
    </h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.catalog') }}"><i class="fa fa-list"></i> Каталог</a></li>
        @foreach($catalog->getParents(false, true) as $parent)
            <li><a href="{{ route('admin.catalog.products', [$parent->id]) }}">{{ $parent->name }}</a></li>
        @endforeach
        <li class="active">{{ $catalog->name}}</li>
    </ol>
@stop

<div class="box box-solid">
    <div class="box-body">
            <a href="{{ route('admin.catalog.productEdit').'?catalog='.$catalog->id }}" onclick="return catalogContent(this)">Добавить товар</a>

            @if (count($products))
                <table class="table table-striped table-v-middle">
                    <thead>
                    <tr>
                        <th width="40"></th>
                        <th width="100"></th>
                        <th>Название</th>
                        {{--<th width="120">Цена</th>--}}
                        <th width="50"></th>
                    </tr>
                    </thead>
                    <tbody id="catalog-products">
                    @foreach ($products as $item)
                        <tr data-id="{{ $item->id }}">
                            <td><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ $item->thumb(1) }}">
                                @endif
                            </td>
                            <td><a href="{{ route('admin.catalog.productEdit', [$item->id]) }}" onclick="return catalogContent(this)" style="{{ $item->published != 1 ? 'text-decoration:line-through;' : '' }}">{{ $item->name }}</a></td>
                            {{--                        <td>{{ number_format($item->price, 0, '.', ' ') }}</td>--}}
                            <td>
                                <a class="glyphicon glyphicon-trash" href="{{ route('admin.catalog.productDel', [$item->id]) }}" style="font-size:20px; color:red;" title="Удалить" onclick="return productDel(this)"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <script type="text/javascript">
                    $("#catalog-products").sortable({
                        update: function(event, ui) {
                            var url = "{{ route('admin.catalog.productReorder') }}";
                            var data = {};
                            data.sorted = $('#catalog-products').sortable("toArray", {attribute: 'data-id'} );
                            sendAjax(url, data);
                            //console.log(data);
                        },
                    }).disableSelection();
                </script>
            @else
                <p class="text-yellow">В разделе нет товаров!</p>
            @endif

    </div>
</div>
