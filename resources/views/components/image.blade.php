@if ($imagePath)
    <img src="{{ asset($imagePath) }}" alt="画像">
@else
    <img src="{{ asset('images/no_image.jpg') }}" alt="画像がありません">
@endif