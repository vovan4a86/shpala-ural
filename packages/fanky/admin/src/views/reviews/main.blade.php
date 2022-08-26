@extends('admin::template')

@section('scripts')
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/adminlte/interface_reviews.js"></script>
@stop

@section('page_name')
	<h1>Отзывы
		<small><a href="{{ route('admin.reviews.edit') }}">Добавить отзыв</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Отзывы</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($reviews))
				<table class="table table-striped table-v-middle">
					<tbody id="reviews-list">
						@foreach ($reviews as $item)
							<tr data-id="{{ $item->id }}">
                                <td width="40">
                                    <i class="fa fa-eye{{ $item->published ? ' text-green':'-slash text-red' }}"></i>
                                </td>
								<td>{{ $item->dateFormat() }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->text }}</td>
								<td><a class="glyphicon glyphicon-edit" href="{{ route('admin.reviews.edit', [$item->id]) }}" style="font-size:20px; color:orange;"></a></td>
								<td>
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.reviews.del', [$item->id]) }}" style="font-size:20px; color:red;" onclick="reviewsDel(this, event)"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<script type="text/javascript">
					$("#reviews-list").sortable({
						update: function( event, ui ) {
							var url = "{{ route('admin.reviews.reorder') }}";
							var data = {};
							data.sorted = ui.item.closest('#reviews-list').sortable( "toArray", {attribute: 'data-id'} );
							sendAjax(url, data);
						}
					}).disableSelection();
				</script>
			@else
				<p>Нет отзывов!</p>
			@endif
		</div>
	</div>
@stop