<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Ед изм.</th>
            <th>Название характеристики</th>
            <th>Значение характеристики</th>
            <th>Картинки</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        @if($product->images > $product->properties)
            @foreach($product->images as $key => $image)
                <tr>
                    <td>@if($key == 0){{$product->id}}@endif</td>
                    <td>@if($key == 0){{$product->name}}@endif</td>
                    <td>@if($key == 0){{$product->category->name}}@endif</td>
                    <td>@if($key == 0){{$product->price}}@endif</td>
                    <td>@if($key == 0){{$product->counts}}@endif</td>
                    <td>@if($key == 0){{$product->count_type}}@endif</td>
                    <td>@isset($product->properties[$key])
                            {{$product->properties[$key]->name}}
                        @endisset
                    </td>
                    <td>@isset($product->properties[$key])
                            {{$product->properties[$key]->value}}
                        @endisset
                    </td>
                    <td>{{$image->file_name}}</td>
                </tr>
            @endforeach
        @else
            @foreach($product->properties as $key => $property)
                <tr>
                    <td>@if($key == 0){{$product->id}}@endif</td>
                    <td>@if($key == 0){{$product->name}}@endif</td>
                    <td>@if($key == 0){{$product->category->name}}@endif</td>
                    <td>@if($key == 0){{$product->price}}@endif</td>
                    <td>@if($key == 0){{$product->counts}}@endif</td>
                    <td>@if($key == 0){{$product->count_type}}@endif</td>
                    <td>{{$property->name}}</td>
                    <td>{{$property->value}}
                    </td>
                    <td>@isset($product->images[$key])
                            {{$product->images[$key]->file_name}}
                        @endisset</td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
