<b>Новая ошибка</b>
Текст: <i>{{$e->getMessage()}}</i>
Файл: <i>{{$e->getFile()}}</i>
Строка: <i>{{$e->getLine()}}</i>
@if(Auth::user())

Пользователь: {{Auth::user()->firstname}} {{Auth::user()->lastname}}
@endif
