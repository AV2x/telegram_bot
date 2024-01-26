<b><a href="{{env('APP_URL')}}/orders">Новый заказ №{{$order->id}}</a></b>

<i>Имя клиента:</i> {{$order->client_name}}
<i>Email клиента:</i> {{$order->client_email}}
<i>Телефон клиента:</i> {{$order->client_telephone}}

<i>Менеджер:</i> {{$order->manager->name}}
<i>Статус: </i> {{$order->status->name}}

<i>Список товаров:</i>
@foreach($order->products as $product)
{{$product->name}} - {{$product->order_counts}}
@endforeach

<a href="#s{{$order->id}}">#s{{$order->id}}</a>
