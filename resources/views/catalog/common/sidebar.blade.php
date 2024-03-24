<div class="sidebar-left xs-hidden">
    <h2 class="sidebar-heading">Danh mục sản phẩm</h2>
    @if(count($categories) > 0)
    <ul class="navigate-left">
        @foreach($categories as $parent)
            @if(count($parent->subCategories) > 0)
                <li>
                    <a href="{{ route('catalog.productCategory', [$parent->slug]) }}" title="{{ $parent->name }}">
                        <span>{{ $parent->name }}</span>
                        <i class="fa fa-caret-right"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('catalog.products') }}" title="Tất cả sản phẩm">Tất cả sản phẩm</a></li>
                        @foreach($parent->subCategories as $child)
                            <li><a href="{{ route('catalog.productCategory', [$child->slug]) }}" title="{{ $child->name }}">{{ $child->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li><a href="{{ route('catalog.productCategory', [$parent->slug]) }}" title="{{ $parent->name }}">{{ $parent->name }}</a></li>
            @endif
        @endforeach
    </ul>
    @endif
</div>