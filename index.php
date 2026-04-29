<?php
header('Content-Type: text/html; charset=UTF-8');

// Если запрос GET - показываем форму
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    $errors = array();
    
    // Проверяем наличие сохранённой успешной отправки
    if (!empty($_COOKIE['save'])) {
        $messages[] = '<div class="success">Спасибо, данные успешно сохранены.</div>';
        setcookie('save', '', 100000); // удаляем после отображения
    }
    
    // Считываем ошибки из Cookies (время жизни - до конца сессии)
    $errors['FIO'] = !empty($_COOKIE['FIO_error']);
    $errors['telep'] = !empty($_COOKIE['telep_error']);
    $errors['mail'] = !empty($_COOKIE['mail_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['sex'] = !empty($_COOKIE['sex_error']);
    $errors['language'] = !empty($_COOKIE['language_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['agreement'] = !empty($_COOKIE['agreement_error']);
    
    // Формируем сообщения об ошибках и удаляем использованные Cookies
    $error_messages = array();
    
    if ($errors['FIO']) {
        $error_messages['FIO'] = $_COOKIE['FIO_msg'] ?? 'Ошибка в поле ФИО';
        setcookie('FIO_error', '', 100000);
        setcookie('FIO_msg', '', 100000);
    }
    
    if ($errors['telep']) {
        $error_messages['telep'] = $_COOKIE['telep_msg'] ?? 'Ошибка в поле Телефон';
        setcookie('telep_error', '', 100000);
        setcookie('telep_msg', '', 100000);
    }
    
    if ($errors['mail']) {
        $error_messages['mail'] = $_COOKIE['mail_msg'] ?? 'Ошибка в поле Email';
        setcookie('mail_error', '', 100000);
        setcookie('mail_msg', '', 100000);
    }
    
    if ($errors['date']) {
        $error_messages['date'] = $_COOKIE['date_msg'] ?? 'Ошибка в поле Дата рождения';
        setcookie('date_error', '', 100000);
        setcookie('date_msg', '', 100000);
    }
    
    if ($errors['sex']) {
        $error_messages['sex'] = $_COOKIE['sex_msg'] ?? 'Ошибка в поле Пол';
        setcookie('sex_error', '', 100000);
        setcookie('sex_msg', '', 100000);
    }
    
    if ($errors['language']) {
        $error_messages['language'] = $_COOKIE['language_msg'] ?? 'Ошибка в поле Языки программирования';
        setcookie('language_error', '', 100000);
        setcookie('language_msg', '', 100000);
    }
    
    if ($errors['bio']) {
        $error_messages['bio'] = $_COOKIE['bio_msg'] ?? 'Ошибка в поле Биография';
        setcookie('bio_error', '', 100000);
        setcookie('bio_msg', '', 100000);
    }
    
    if ($errors['agreement']) {
        $error_messages['agreement'] = $_COOKIE['agreement_msg'] ?? 'Необходимо подтвердить согласие';
        setcookie('agreement_error', '', 100000);
        setcookie('agreement_msg', '', 100000);
    }
    
    // Загружаем ранее введённые значения (на 1 год при успехе, на сессию при ошибке)
    $values = array();
    $values['FIO'] = $_COOKIE['FIO_value'] ?? '';
    $values['telep'] = $_COOKIE['telep_value'] ?? '';
    $values['mail'] = $_COOKIE['mail_value'] ?? '';
    $values['date'] = $_COOKIE['date_value'] ?? '';
    $values['sex'] = $_COOKIE['sex_value'] ?? '';
    $values['language'] = empty($_COOKIE['language_value']) ? array() : explode('|', $_COOKIE['language_value']);
    $values['bio'] = $_COOKIE['bio_value'] ?? '';
    $values['agreement'] = $_COOKIE['agreement_value'] ?? '';
    
    // Подключаем форму
    include('form.php');
}
// Если запрос POST - проверяем и сохраняем данные
else {
    $errors = false;
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ ФИО ==========
    if (empty($_POST['FIO'])) {
        setcookie('FIO_error', '1', 0);
        setcookie('FIO_msg', 'ФИО обязательно для заполнения. Допустимы: буквы, пробелы, дефис.', 0);
        $errors = true;
    } elseif (strlen($_POST['FIO']) > 150) {
        setcookie('FIO_error', '1', 0);
        setcookie('FIO_msg', 'ФИО слишком длинное (максимум 150 символов)', 0);
        $errors = true;
    } elseif (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $_POST['FIO'])) {
        setcookie('FIO_error', '1', 0);
        setcookie('FIO_msg', 'В ФИО допустимы только буквы, пробелы и дефис', 0);
        $errors = true;
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ ТЕЛЕФОН ==========
    if (empty($_POST['telep'])) {
        setcookie('telep_error', '1', 0);
        setcookie('telep_msg', 'Номер телефона обязателен для заполнения. Допустимый формат: +7 (999) 123-45-67', 0);
        $errors = true;
    } elseif (!preg_match('/^[\+\d\s\-\(\)]{6,20}$/', $_POST['telep'])) {
        setcookie('telep_error', '1', 0);
        setcookie('telep_msg', 'Телефон введён некорректно. Допустимые символы: +, цифры, пробелы, скобки, дефис. Длина: 6-20 символов', 0);
        $errors = true;
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ EMAIL ==========
    if (empty($_POST['mail'])) {
        setcookie('mail_error', '1', 0);
        setcookie('mail_msg', 'Email обязателен для заполнения. Формат: name@domain.ru', 0);
        $errors = true;
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        setcookie('mail_error', '1', 0);
        setcookie('mail_msg', 'Email введён неправильно. Допустимый формат: user@example.com', 0);
        $errors = true;
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ ДАТА ==========
    if (empty($_POST['date'])) {
        setcookie('date_error', '1', 0);
        setcookie('date_msg', 'Дата рождения обязательна для заполнения. Формат: ГГГГ-ММ-ДД', 0);
        $errors = true;
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date'])) {
        setcookie('date_error', '1', 0);
        setcookie('date_msg', 'Дата рождения должна быть в формате ГГГГ-ММ-ДД', 0);
        $errors = true;
    } else {
        $date_parts = explode('-', $_POST['date']);
        if (!checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            setcookie('date_error', '1', 0);
            setcookie('date_msg', 'Дата рождения некорректна (проверьте число и месяц)', 0);
            $errors = true;
        }
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ ПОЛ ==========
    if (empty($_POST['sex'])) {
        setcookie('sex_error', '1', 0);
        setcookie('sex_msg', 'Необходимо выбрать пол', 0);
        $errors = true;
    } elseif (!in_array($_POST['sex'], array('Male', 'Female'))) {
        setcookie('sex_error', '1', 0);
        setcookie('sex_msg', 'Выбрано недопустимое значение пола', 0);
        $errors = true;
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ ЯЗЫКИ ==========
    $allowed_languages = array('PHP', 'Python', 'Java', 'JavaScript', 'C++', 'Go');
    if (empty($_POST['language'])) {
        setcookie('language_error', '1', 0);
        setcookie('language_msg', 'Выберите хотя бы один язык программирования', 0);
        $errors = true;
    } else {
        foreach ($_POST['language'] as $lang) {
            if (!in_array($lang, $allowed_languages)) {
                setcookie('language_error', '1', 0);
                setcookie('language_msg', 'Выбран недопустимый язык программирования. Допустимы: PHP, Python, Java, JavaScript, C++, Go', 0);
                $errors = true;
                break;
            }
        }
    }
    
    // ========== ВАЛИДАЦИЯ ПОЛЯ БИОГРАФИЯ ==========
    if (empty($_POST['bio'])) {
        setcookie('bio_error', '1', 0);
        setcookie('bio_msg', 'Биография обязательна для заполнения', 0);
        $errors = true;
    } elseif (strlen($_POST['bio']) > 1000) {
        setcookie('bio_error', '1', 0);
        setcookie('bio_msg', 'Биография не должна превышать 1000 символов', 0);
        $errors = true;
    } elseif (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9\s\.,!?\-:;\'"]+$/u', $_POST['bio'])) {
        setcookie('bio_error', '1', 0);
        setcookie('bio_msg', 'Биография содержит недопустимые символы. Допустимы: буквы, цифры, пробелы, знаки препинания (.,!?-:;\'")', 0);
        $errors = true;
    }
    
    // ========== ВАЛИДАЦИЯ СОГЛАСИЯ ==========
    if (empty($_POST['agreement'])) {
        setcookie('agreement_error', '1', 0);
        setcookie('agreement_msg', 'Необходимо подтвердить согласие с контрактом', 0);
        $errors = true;
    } elseif ($_POST['agreement'] !== 'on') {
        setcookie('agreement_error', '1', 0);
        setcookie('agreement_msg', 'Необходимо отметить согласие с контрактом', 0);
        $errors = true;
    }
    
    // ВСЕГДА сохраняем введённые значения (на время сессии)
    setcookie('FIO_value', $_POST['FIO'], 0);
    setcookie('telep_value', $_POST['telep'], 0);
    setcookie('mail_value', $_POST['mail'], 0);
    setcookie('date_value', $_POST['date'], 0);
    setcookie('sex_value', $_POST['sex'], 0);
    if (!empty($_POST['language'])) {
        setcookie('language_value', implode('|', $_POST['language']), 0);
    }
    setcookie('bio_value', $_POST['bio'], 0);
    setcookie('agreement_value', $_POST['agreement'], 0);
    
    // Если есть ошибки - редирект на GET
    if ($errors) {
        header('Location: index.php');
        exit();
    }
    
    // ========== УСПЕШНОЕ СОХРАНЕНИЕ ==========
    // Удаляем Cookies ошибок
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
    setcookie('agreement_error', '', 100000);
    setcookie('agreement_msg', '', 100000);
    
    // Сохраняем значения на 1 ГОД (как значения по умолчанию)
    setcookie('FIO_value', $_POST['FIO'], time() + 365 * 24 * 60 * 60);
    setcookie('telep_value', $_POST['telep'], time() + 365 * 24 * 60 * 60);
    setcookie('mail_value', $_POST['mail'], time() + 365 * 24 * 60 * 60);
    setcookie('date_value', $_POST['date'], time() + 365 * 24 * 60 * 60);
    setcookie('sex_value', $_POST['sex'], time() + 365 * 24 * 60 * 60);
    if (!empty($_POST['language'])) {
        setcookie('language_value', implode('|', $_POST['language']), time() + 365 * 24 * 60 * 60);
    }
    setcookie('bio_value', $_POST['bio'], time() + 365 * 24 * 60 * 60);
    setcookie('agreement_value', $_POST['agreement'], time() + 365 * 24 * 60 * 60);
    
    // Сохраняем признак успешной отправки
    setcookie('save', '1', time() + 365 * 24 * 60 * 60);
    
    try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8", 
        $config['user'], 
        $config['pass']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->beginTransaction();


    $stmt = $db->prepare("INSERT INTO Frequest (name, tel, email, dateborn, sex, bio, agree) 
                          VALUES (:name, :tel, :email, :dateborn, :sex, :bio, :agree)");
    $stmt->execute([
        ':name' => $name,
        ':tel' => $tel,
        ':email' => $email,
        ':dateborn' => $dateborn,
        ':sex' => $sex,
        ':bio' => $bio,
        ':agree' => $agreement ? 1 : 0
    ]);
    
    // Редирект на GET
    header('Location: index.php');
    exit();
}
?>
