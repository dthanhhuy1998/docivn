@if(count($productVideos) > 0)
    <div class="product-video-list">
        @foreach($productVideos as $video)
            @php
                $thumbnail = data_get($video->metadata, 'thumbnail');
                $thumbnailUrl = !empty($thumbnail['path'])
                    ? Storage::disk($thumbnail['disk'] ?? $video->disk)->url($thumbnail['path'])
                    : null;
            @endphp
            <div class="product-video-item" data-product-video-item="{{ $video->id }}">
                <div class="product-video-preview">
                    @if($thumbnailUrl)
                        <img src="{{ $thumbnailUrl }}" alt="{{ $video->original_name }}">
                    @else
                        <span>Chưa có thumbnail</span>
                    @endif
                </div>
                <div class="product-video-info">
                    <strong>{{ $video->original_name }}</strong>
                    <span>{{ strtoupper($video->extension) }} · {{ number_format($video->size / 1024 / 1024, 2) }} MB</span>
                </div>
                <button
                    type="button"
                    class="btn btn-danger btn-sm js-delete-product-video"
                    data-delete-url="{{ route('admin.product.videos.delete', [$product->id, $video->id]) }}"
                    title="Xóa video"
                >
                    <i class="fa fa-trash"></i> Xóa
                </button>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted product-video-empty">Chưa có video sản phẩm.</p>
@endif
