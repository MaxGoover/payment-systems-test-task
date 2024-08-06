# payment-systems-test-task

В данном репозитории представлено решение тестового задания для ООО "Расчетные системы"

<h6>Задание:</h6>

<details> 
  <summary>Задача</summary>
  <ul>
    <li>Используя фреймворк Symfony(полный стэк и инфраструктура на Ваш выбор) реализовать REST сервис отправки писем.</li>
    <li>Сервис должен иметь 2 метода send и status.</li>
    <li>Необходимо предусмотреть высокую доступность сервиса и проблемы отправки дублей(как от инициатора, так и по вине самого сервиса).</li>
    <li>Проблему попадания писем в спам у получателя решать не нужно.</li>
    <li>Для запуска сервиса используйте docker.</li>
    <li>Обязательно покрыть тестами, где это целесообразно и возможно.</li>
  </ul>
</details>

<details>
  <summary>Критерии оценки</summary>
  <ul>
    <li>Будет оцениваться качество кода, цикломатическая сложность методов, стиль кода и суть предложенных решений.</li>
    <li>Если Вы не доделали задачу — покажите, что сделали, объясните, что планировалось и на чем застряли(если застряли).</li>
  </ul>
</details>

<details>
  <summary>Итог работы</summary>
  <ul>
    <li>Ваш код должен быть выгружен в любой общедоступный репозиторий и снабжен README-файлом, в котором опишете свою работу и инструкции, как запустить Ваш проект.</li>
    <li>Тестовые задания в виде архивов, ссылок на файловые хостинги и подобном (то есть не репозиторий) рассматриваться не будут.</li>
    <li>Ваша история коммитов покажет, как Вы работали над заданием: к примеру, один коммит с заголовком, не отражающим сути работы, является недостатком.</li>
  </ul>
</details>

<h6>Решение:</h6>

<details>
  <summary>Требования к локальной машине</summary>
  <ol>
    <li>Установленная ОС Linux</li>
    <li>Установленный docker compose</li>
  </ol>
</details>

<details>
  <summary>Пошаговая инструкция</summary>
  <ol>
    <li>Склонировать текущий репозиторий</li>
    <li>Открыть в IDE папку с проектом payment-systems-test-task</li>
    <li>Открыть терминал</li>
    <li>Создать переменную окружения .env из копии файла .env.example командой:
      <br>
      <code>
        cp .env.example .env
      </code>
    </li>
    <li>Перейти в папку docker командой:
      <br>
      <code>
        cd docker
      </code>
    </li>
    <li>Здесь тоже создать переменную окружения .env из копии файла .env.example командой:
      <br>
      <code>
        cp .env.example .env
      </code>
    </li>
    <li>Собрать приложение командой:
      <br>
      <code>
        docker compose build && docker compose up
      </code>
    </li>
    <li>Зайти /bash консоль контейнера php-fpm командой:
      <br>
      <code>
        docker compose exec -u www-data php-fpm bash
      </code>
      <ul>
        <li>Внутри контейнера необходимо установить зависимости проекта командой:
          <br>
          <code>
            composer install
          </code>
        </li>
        <li>Запускаем миграции командой:
          <br>
          <code>
            bin/console doctrine:migrations:migrate
          </code>
        </li>
        <li>Запускаем фикстуры командой:
          <br>
          <code>
            bin/console doctrine:fixtures:load
          </code>
        </li>
        <li>Запускаем обменник messengers в rabbitmq командой:
          <br>
          <code>
            bin/console messenger:setup-transports
          </code>
        </li>
        <li>Запускаем слушателя для rabbitmq командой:
          <br>
          <code>
            bin/console messenger:consume rabbitmq
          </code>
        </li>
        <li>Далее, нужно создать cronjob, который будет отправлять наши письма в очередь:
          <br>
          <code>
            bin/console cron:create
          </code>
          <br>
          name: <code>RunSendEmailMessage</code>
          <br>
          command: <code>app:rabbitmq:send-email-message</code>
          <br>
          schedule: <code>* * * * *</code>
          <br>
          description: <code>Send email into rabbitmq</code>
          <br>
          enabled: <code>true</code>
          <br>
          confirm
        </li>
      </ul>
      Готово! Оставаюсь в контейнере, давайте попробуем запустить тесты командой:
      <br>
      <code>bin/phpunit --testdox</code>
      Надеюсь, у Вас получилось
    </li>
    <li>Открыть браузер и перейти на вкладку с url: <a href="http://localhost:888">http://localhost:888</a></li>
    <li>Должна появиться стартовая страница фреймворка Symfony</li>
  </ol>
</details>

<h6>Описание сервиса:</h6>

<details>
  <summary>Общее описание</summary>
  Есть консольная команда (запускается cron`ом), которая раз в минуту пробегается по таблице emails<br>
  Эта команда находит те письма, у которых стоит статус "New" и отправляет их в очередь (rabbitmq)<br>
  Консюмеры очередей получают эти письма и отправляют их адресанту<br>
</details>

<details>
  <summary>Эндпоинты</summary>
  Сервис содержит всего два эндпоинта:
  <br>
  <code>/api/send</code> - методом POST сюда мы передаем (в теле запроса) email, который хотим отправить.
  <p>Обязательные поля:</p>
  <ul>
    <li>Array $addresses - список (массив) email-адресов, на который мы хотим разослать наш email (email-адреса должны быть уникальны между собой)</li>
    <li>String $theme - тема письма</li>
    <li>String $content - содержание письма</li>
  </ul>
  <br>
  <code>/api/status</code> - методом GET сюда мы передаем (в параметрах запроса) id`шник того email`a, статус которого хотим получить.
  <p>Обязательные поля:</p>
  <ul>
    <li>String $id - идентификатор email`a</li>
  </ul>
</details>

<details>
  <summary>Техническое описание</summary>
  <ul>
    <li>Каждый email, который поступает в эндпоинт '/api/send', сохраняется в таблице emails со статусом "new"</li>
    <li>
      Раз в минуту (по умолчанию) cron запускает консольную команду, которая пробегается по таблице emails.<br>
      Эта команда находит те письма, у которых стоит статус "new":<br>
      (Yes) Если да, тогда идентификатор этого письма отправляется в очередь (rabbitmq), а этому email`у ставится статус "in_queue"
    </li>
    <li>
      Когда консюмер в брокере доходит до сообщения, он извлекает из него emailId и делает запрос в БД (findById), чтобы получить модель email.<br>
      Получив модель email`а он проверяет, что у email`a до сих пор статус "in_queue":<br>
      (Yes) Этот email отправляется адресанту
    </li>
    <li>
      Вот так происходит отправка email`a адресанту:<br>
      (Yes) Если отправка произошла успешно, отправленному email`у присваивается статус "sent", сообщение с emailId из очереди удаляется<br>
      (No) Если отправка письма не удалась, email`у присваивается статус "sending_error", сообщение с emailId из очереди также удаляется
    </li>
  </ul>
</details>

<details>
  <summary>Примеры запросов</summary>
  Для send (POST):
  <code>http://localhost:888/api/send</code>
  <br>
  <code>{
    "addresses": [
        "asd@gmail.com",
        "zxc@gmail.com",
        "qwe@mail.com"
    ],
    "theme": "test theme",
    "content": "test content"
    }
  </code>
  <br>
  Для status (GET):
  <code>http://localhost:888/api/status?id=01J4HS77EAV0ZHBHE3BE1409NQ</code>
</details>

<details>
  <summary>Идеи для добавления в сервис</summary>
  <ul>
    <li>Можно добавить поле - кол-во попыток отправки (каждое ошибочное действие + 1)</li>
    <li>Написать демона, который проверяет, что если у письма стоит статус "in_queue" (например, больше 5-ти минут - вынести в конфиг), тогда ему ставим статус "bus_error"</li>
    <li>Написать демона, который считает email`ы со статусом ошибок (bus_error или sending_error). Если превышает какое-то число (вынести в конфиг), кидать алерт разрабу - "Сервис не работает"</li>
    <li>Написать демона, который делает повторную отправку письмам с ошибками (bus_error или sending_error), исходя из их updatedAt с прогрессирующим интервалом</li>
    <li>Написать демона, который проверяет поля createdAt нового сообщения, и если оно больше, чем, например, 5 минут, тогда кидать алерт разрабу - "Новые email`ы не отправляются"</li>
  </ul>
</details>