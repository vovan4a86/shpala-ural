<span class="images_item" data-id="{{ $image->id }}">
	<img class="img-polaroid" src="{{ $image->thumb(1) }}" style="cursor:pointer;" data-image="{{ $image->image_src }}" onclick="popupImage('{{ $image->image_src }}')">
	<a class="images_del" href="{{ route('admin.catalog.catalogImageDel', [$image->id]) }}" onclick="return productImageDel(this)"><span class="glyphicon glyphicon-trash"></span></a>
</span>