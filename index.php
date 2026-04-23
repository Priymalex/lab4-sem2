<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
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
  $values['language'] = empty($_COOKIE['language_value']) ? [] : $_COOKIE['language_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? [] : $_COOKIE['bio_value'];
  
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['FIO'])) {
    setcookie('FIO_error', '1', time() + 24 * 60 * 60);
    setcookie('FIO_msg', 'ФИО обязательно для заполнения.', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  elseif (strlen($_POST['FIO']) > 150) {
    setcookie('FIO_error', '1', time() + 24 * 60 * 60);
    setcookie('FIO_msg', 'ФИО слишком длинное', time() + 24 * 60 * 60);
    $errors = TRUE;
  }  
  elseif (!preg_match('/^[a-zA-Zа-яёА-ЯЁ ]+$/u',$_POST['FIO'])){
    setcookie('FIO_error', '1', time() + 24 * 60 * 60);
    setcookie('FIO_msg', 'В ФИО можно только буквы и пробелы', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('FIO_value', $_POST['FIO'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['telep'])) {
    setcookie('telep_error', '1', time() + 24 * 60 * 60);
    setcookie('telep_msg', 'Номер телефона обязателен для заполнения.', time() + 24 * 60 * 60);
    $errors = TRUE;
  } 
  elseif (!preg_match('/^[\+\d\s\-\(\)]+$/', $_POST['telep'])) {
    setcookie('telep_error', '1', time() + 24 * 60 * 60);
    setcookie('telep_msg', 'Телефон введен некорректно.', time() + 24 * 60 * 60);
    $errors = TRUE;
}  
  elseif (strlen($_POST['telep']) < 6 || strlen($_POST['telep']) > 20) {
    setcookie('telep_error', '1', time() + 24 * 60 * 60);
    setcookie('telep_msg', 'Телефон должен содержать от 6 до 20 символов.', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('telep_value', $_POST['telep'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['mail'])) {
    setcookie('mail_error', '1', time() + 24 * 60 * 60);
    setcookie('mail_msg', 'Адрес электронной почты обязателен для заполнения.', time() + 24 * 60 * 60);
    $errors = TRUE;
  } 
  elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    setcookie('mail_error', '1', time() + 24 * 60 * 60);
    setcookie('mail_msg', 'Почта введена неправильно', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['date'])) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    setcookie('date_msg', 'Дата рождения обязательна для заполнения', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  elseif (!empty($_POST['date']) && !strtotime($_POST['date'])) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    setcookie('date_msg', 'Дата рождения указана некорректно.', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['sex'])) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    setcookie('sex_msg', 'Пол обязателен для заполнения', time() + 24 * 60 * 60);
    $errors = TRUE;
  } elseif (!in_array($_POST['sex'], ['Male', 'Female'])) { 
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    setcookie('sex_msg', 'Выбран недопустимый пол.', time() + 24 * 60 * 60);
    $errors = TRUE;
}
  setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['language'])) {
    setcookie('language_error', '1', time() + 24 * 60 * 60);
    setcookie('language_msg', 'Языки обязательно надо указать', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('language_value', $_POST['language'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    setcookie('bio_msg', 'Биографию обязательно надо указать', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['Agreement'])) {
    setcookie('Agreement_error', '1', time() + 24 * 60 * 60);
     setcookie('Agreement_msg', 'Согласие обязательно', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('Agreement_value', $_POST['Agreement'], time() + 30 * 24 * 60 * 60);

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('FIO_error', '', 100000);
    setcookie('FIO_msg', '', 100000);
    setcookie('telep_error', '', 100000);
    setcookie('telep_msg', '', 100000);
    setcookie('mail_error', '', 100000);
    setcookie('mail_msg', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('date_msg', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('sex_msg', '', 100000);
    setcookie('language_error', '', 100000);
    setcookie('language_msg', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('bio_msg', '', 100000);
    setcookie('Agreement_error', '', 100000);
    setcookie('Agreement_msg', '', 100000);
  }

  // Сохранение в БД.
  // ...
  
  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
?>
