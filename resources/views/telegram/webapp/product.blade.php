<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .required {
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <div>
        <img src="https://telegram.povyshev-course.com/storage/products/{{$product->images[0]->file_name}}" alt="">
        <h2>{{$product->name}}</h2>
        <p>{{$product->price}} Руб.</p>
        <input type="text" id="name">
        <input type="text" id="address">
    </div>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        let tg = window.Telegram.WebApp;
        tg.sendData('test');
        {{--document.getElementById('name').value = tg.initDataUnsafe.user.first_name;--}}
        {{--tg.BackButton.isVisible = true;--}}
        {{--tg.BackButton.onClick(function () {--}}
        {{--    location.href = 'https://telegram.povyshev-course.com/webapp/products';--}}
        {{--});--}}
        {{--tg.MainButton.isVisible = true;--}}
        {{--tg.MainButton.text = 'Купить {{$product->price}} руб.'--}}
        {{--tg.MainButton.isActive = true;--}}

        {{--tg.MainButton.onClick(button => {--}}
        {{--   if(!document.getElementById('address').value)--}}
        {{--   {--}}
        {{--       document.getElementById('address').classList.add('required')--}}
        {{--   }--}}
        {{--   else {--}}
        {{--       tg.MainButton.isActive = false;--}}
        {{--       tg.MainButton.showProgress(leaveActive = true);--}}
        {{--        //location.href = 'https://povyshev-course.com/test/payment?product_id={{$product->id}}';--}}
        {{--       tg.sendData('test');--}}
        {{--       //tg.MainButton.hide();--}}
        {{--   }--}}
        {{--});--}}
    </script>
</body>
</html>
