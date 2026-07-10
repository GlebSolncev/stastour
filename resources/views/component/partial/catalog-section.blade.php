@foreach($items as $item)
    @include('component.partial.catalog-item', ['item' => $item, 'grid' => 'col-24 col-sm-12 col-md-8'])
@endforeach

