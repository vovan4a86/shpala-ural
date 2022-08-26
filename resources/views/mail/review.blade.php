<html>
<body>
<p>Новый отзыв с сайта</p>
<p>Имя: {{ $review->name }}</p>
<p>Текст: {{ $review->text }}</p>
<p><a href="{{ route('admin.reviews.edit', [$review->id]) }}">Модерация</a></p>
</body>
</html>
