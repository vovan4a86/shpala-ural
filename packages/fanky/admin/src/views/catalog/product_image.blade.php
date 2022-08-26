<span class="images_item" data-id="{{ $image->id }}">
	<img class="img-polaroid {{ $image->image == $active ? 'active' : '' }}" src="{{ $image->thumb(2) }}" style="cursor:pointer;" data-image="{{ $image->image }}" onclick="popupImage('{{ $image->src }}')">
	<a class="images_del" href="{{ route('admin.catalog.productImageDel', [$image->id]) }}" onclick="return productImageDel(this)"><span class="glyphicon glyphicon-trash"></span></a>
	<div class="img_check" onclick="return productCheckImage(this)"><span class="glyphicon {{ $image->image == $active ? 'glyphicon-check' : 'glyphicon-unchecked' }}"></span></div>
</span>