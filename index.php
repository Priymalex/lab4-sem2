<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

    $errors = array();
    $errors['FIO'] = !empty($_COOKIE['FIO_error']);
    $errors['telep'] = !empty($_COOKIE['telep_error']);
    $errors['mail'] = !empty($_COOKIE['mail_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['sex'] = !empty($_COOKIE['sex_error']);
    $errors['language'] = !empty($_COOKIE['language_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['Agreement'] = !empty($_COOKIE['agree_error']);

  // Выдаем сообщения об ошибках.
  if ($errors['FIO']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('FIO_error', '', 100000);
    setcookie('FIO_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }

  if($errors['telep']){
    setcookie('telep_error', '', 100000);
    setcookie('telep_value', '', 100000);
    $messages[] = '<div class="error">Заполните поле телефон.</div>';
  }

  if($errors['mail']){
    setcookie('mail_error', '', 100000);
    setcookie('mail_value', '', 100000);
    $messages[] = '<div class="error">Заполните поле электронной почты.</div>';
  }

  if($errors['date']){
    setcookie('date_error', '', 100000);
    setcookie('date_value', '', 100000);
    $messages[] = '<div class="error">Заполните поле даты рождения.</div>';
  }

  if($errors['sex']){
    setcookie('sex_error', '', 100000);
    setcookie('sex_value', '', 100000);
    $messages[] = '<div class="error">Отметьте свой пол.</div>';
  }

  if($errors['language']){
    setcookie('language_error', '', 100000);
    setcookie('language_value', '', 100000);
    $messages[] = '<div class="error">Выберите свои языки программирования.</div>';
  }

  if($errors['bio']){
    setcookie('bio_error', '', 100000);
    setcookie('bio_value', '', 100000);
    $messages[] = '<div class="error">Заполните свою биографию.</div>';
  }

  if($errors['Agreement']){
    setcookie('agree_error', '', 100000);
    setcookie('agree_value', '', 100000);
    $messages[] = '<div class="error">Отметить своё согласие.</div>';
  }


  

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['FIO'] = empty($_COOKIE['FIO_value']) ? '' : $_COOKIE['FIO_value'];
  $values['telep'] = empty($_COOKIE['telep_value']) ? '' : $_COOKIE['telep_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['fio'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
  // ...

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}