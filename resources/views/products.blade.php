<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авто</title>
</head>
<body>
<style>
    header span{
        font-size: 20px;
        margin: 15px;
        margin-top: 25px;
    }
    body {
        background-color: #ddd;
        margin: 0;
    }
    body div,header {
        background-color: white;
    }
</style>
    <header style="width: 100%; height: 75px; box-shadow: 1px 1px 5px #ddd">
        <span>Главная</span>
        <span>Автомобили</span>
    </header>
    <div style="width: 80%; margin: auto;box-shadow: 1px 1px 5px #ddd; height: 70vh;margin-top: 15px;">
        <div>
            <h1>{{$product->title}}</h1>
        </div>
        <div style="max-height: 150px;">
            @foreach($product->images as $image)
                <img src="/storage/images/{{$image->file_name}}" height="150" alt="">
            @endforeach
        </div>
        <div style="padding-top: 15px;">
            <span>Цена: {{$product->price}} руб.</span>
        </div>
        <div>
            <p>{{$product->description}}</p>
        </div>
        <div>
            <a href="https://t.me/testpovyshevbot?start=product_id={{$product->id ?? ''}}" target="_blank"> Заказать </a>
        </div>
    </div>
</body>
</html>
