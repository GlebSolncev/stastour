<div class="catalog-item {{$grid}}"{{isset($row) ? ' data-row='.$row : ''}} {{isset($js_element) ? ' js-element='.$js_element : ''}}>
    <div class="catalog-item__head">
                    <span
                        class="catalog-item__type catalog-item__type--{{$item?->image?->color ?: 'green'}}">{{$item->image->type}}</span>
        <img src="{{$item->image->src}}" js-module="parallax">
    </div>
    <div class="catalog-item__title">
        <a href="{{$item->href}}">{{$item->title}}</a>
        <div class="catalog-item__properties">
            @foreach($item?->properties as $property)
                <span
                    class="catalog-item__property catalog-item__property--{{$property?->type ?: 'none'}}">{{isset($property?->label) ? $property?->label : ''}}</span>
            @endforeach
        </div>
    </div>

    <div class="catalog-item__description">
        {{$item->description}}
    </div>

    <div class="catalog-item__footer">
        <span class="catalog-item__price">{{$item->price}} €</span>
        <a href="{{$item->href}}" class="button button--primary button--tiny catalog-item__action">Find
            more</a>
    </div>
</div>
