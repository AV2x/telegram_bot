<table>
    <thead>
    <tr>
        <th>id</th>
        <th style="width: 150px">Товары</th>
        <th style="width: 150px">Количество</th>
        <th style="width: 150px">Менеджер</th>
        <th style="width: 150px">Имя клиента</th>
        <th style="width: 150px">Email клиента</th>
        <th style="width: 150px">Телефон клиента</th>
        <th style="width: 150px">Статус</th>
    </tr>
    </thead>
    <tbody>

    @foreach($orders as $order)
        @foreach($order->products as $key => $product)
            <tr>
                <td >@if($key == 0){{$order->id}}@endif</td>
                              <td>{{$product->name}}</td>
                              <td>{{$product->order_counts}}</td>
                <td>@if($key == 0){{$order->manager->name}}@endif</td>
                <td>@if($key == 0){{$order->client_name}}@endif</td>
                <td>@if($key == 0){{$order->client_email}}@endif</td>
                <td>@if($key == 0){{$order->client_telephone}}@endif</td>
                <td>@if($key == 0){{$order->status->name}}@endif</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
