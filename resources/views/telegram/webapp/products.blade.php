<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>webapp</title>
    <style>
        .cards {
            display: grid;
            /* Автоматически заполняем на всю ширину grid-контейнера */
            grid-template-columns: repeat(auto-fill, 225px);
            width: 100%;
            max-width: 1000px; /* Ширина grid-контейнера */
            justify-content: center;
            justify-items: center; /* Размещаем карточку по центру */
            column-gap: 30px; /* Отступ между колонками */
            row-gap: 40px; /* Отступ между рядами */
            margin: 0 auto;
        }
        .card {
            width: 225px;
            min-height: 350px;
            box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column; /* Размещаем элементы в колонку */
            border-radius: 4px;
            transition: 0.2s;
            position: relative;
        }

        /* При наведении на карточку - меняем цвет тени */
        .card:hover {
            box-shadow: 4px 8px 16px rgba(255, 102, 51, 0.2);
        }

        .card__top {
            flex: 0 0 220px; /* Задаем высоту 220px, запрещаем расширение и сужение по высоте */
            position: relative;
            overflow: hidden; /* Скрываем, что выходит за пределы */
        }

        /* Контейнер для картинки */
        .card__image {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .card__image > img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Встраиваем картинку в контейнер card__image */
            transition: 0.2s;
        }

        /* При наведении - увеличиваем картинку */
        .card__image:hover > img {
            transform: scale(1.1);
        }

        /* Размещаем скидку на товар относительно изображения */
        .card__label {
            padding: 4px 8px;
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: #ff6633;
            border-radius: 4px;
            font-weight: 400;
            font-size: 16px;
            color: var(--tg-theme-text-color);;
        }

        .card__bottom {
            display: flex;
            flex-direction: column;
            flex: 1 0 auto; /* Занимаем всю оставшуюся высоту карточки */
            padding: 10px;
        }

        .card__prices {
            display: flex;
            margin-bottom: 10px;
        }

        .card__price::after {
            content: "₽";
            margin-left: 4px;
            position: relative;
        }

        .card__price--discount {
            font-weight: 700;
            font-size: 19px;
            color: var(--tg-theme-text-color);
            display: flex;
            flex-wrap: wrap-reverse;
        }

        .card__price--discount::before {
            font-weight: 400;
            font-size: 13px;
            color: var(--tg-theme-text-color);;
        }

        .card__price--common {
            font-weight: 400;
            font-size: 17px;
            color: var(--tg-theme-text-color);;
            display: flex;
            flex-wrap: wrap-reverse;
            justify-content: flex-end;
        }

        .card__price--common::before {
            content: "Обычная";
            font-weight: 400;
            font-size: 13px;
            color: var(--tg-theme-text-color);;
        }

        .card__title {
            display: block;
            margin-bottom: 10px;
            font-weight: 400;
            font-size: 17px;
            line-height: 150%;
            color: var(--tg-theme-text-color);;
        }

        .card__title:hover {
            color: var(--tg-theme-text-color);;
        }

        .card__add {
            display: block;
            width: 100%;
            font-weight: 400;
            font-size: 17px;
            color: var(--tg-theme-button-text-color);
            background-color: var(--tg-theme-button-color);
            padding: 10px;
            text-align: center;
            border: 1px solid #70c05b;
            border-radius: 4px;
            cursor: pointer; /* Меняем курсор при наведении */
            transition: 0.2s;
            margin-top: auto; /* Прижимаем кнопку к низу карточки */
        }

        .card__add:hover {
            border: 1px solid #ff6633;
            background-color: #ff6633;
            color: var(--tg-theme-text-color);;
        }

        body {
            background-color: var(--tg-theme-secondary-bg-color);
            color: var(--tg-theme-text-color);
        }
        .card {
            background-color: var(--tg-theme-bg-color);
        }
    </style>
</head>
<body>
<div class="cards">
{{--    <div id="user">--}}

{{--    </div>--}}
    @foreach($products as $product)
        <div class="card">
            <div class="card__top">
                <a href="#" class="card__image">
                    <img
                        src="https://telegram.povyshev-course.com/storage/products/{{$product->images[0]->file_name}}"
                    />
                </a>
            </div>
            <div class="card__bottom">
                <div class="card__prices">
                    <div class="card__price card__price--discount">{{$product->price}}</div>
                </div>
                <a href="#" class="card__title">
                    {{$product->name}}
                </a>
                <a href="/webapp/product/{{$product->id}}" class="card__add">Купить</a>
            </div>
        </div>

    @endforeach
</div>
<script src="https://telegram.org/js/telegram-web-app.js"></script>
<script>
    let tg = window.Telegram.WebApp;
    //document.getElementById('user').innerText = tg.initDataUnsafe.user.first_name;
    tg.BackButton.hide();
</script>
</body>
</html>
