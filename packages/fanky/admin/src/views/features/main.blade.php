<script type="text/javascript" src="/adminlte/interface_news.js"></script>

<a href="{{ route('admin.catalog.addFeature', [$catalog->id])  }}">Добавить преимущество</a>


<div class="box box-solid">
	<div class="box-body">
		@if (count($items))
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Иконка</th>
						<th>Название</th>
						<th width="50"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($items as $item)
						<tr>
							<td><span>
								{!! Html::image(\Fanky\Admin\Models\CatalogFeature::UPLOAD_URL . $item->image) !!}
								</span>
							</td>
							<td><span>{{ $item->text }}</span></td>
{{--							<td><a href="{{ route('admin.catalog.productEdit', [$item->id]) }}">{{ $item->text }}</a></td>--}}
							<td>
								<a class="glyphicon glyphicon-trash"
								   href="{{ route('admin.catalog.delFeature', [$item->id]) }}"
								   style="font-size:20px; color:red;" title="Удалить" onclick="return newsDel(this)"></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<p>Нет преимуществ</p>
		@endif
	</div>
</div>

