<h3>CRM Prime Engine</h3>
<p>CRM/CMS для интернет магазинов. Посмотреть можно по ссылке: <a href="https://primeengine.ru/">https://primeengine.ru/</a></p>
<h3>Установка</h3>
<p>Скачать файлы из репозитория:</p>

```
git clone https://github.com/AV2x/CRM-Prime-Engine.git
```

```
cd CRM-Prime-Engine
```

<p>Установить и запустить через <a target="_blank" href="https://docs.docker.com/desktop/install/windows-install/">docker</a>:</p>

```Bash
composer start
``` 
<p>Проект будет доступен по <a href="http://localhost" target="_blank">localhost</a></p>
<br>
<h4>Если у вас свой компилятор, создаете .env</h4>

```
cp .env.example .env
```
<p>Подключаете к своей базе, потом выполняете:</p>

```
composer start -l
```
<p>Минимальные требования:</p>

- **PHP не ниже 8.1 версии**
- **Node не ниже 17 версии**

<br><br>

<h3>Внести свой вклад</h3>
<p>Смотришь задачи <a href="https://github.com/AV2x/CRM-Prime-Engine/issues">задачи</a>, выбераешь, в assignee подписываешь на себя, создаешь новую ветку из dev версии, пулиш в нее изменения, делаешь merge request с веткой dev.</p>
