
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрационная форма</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            line-height: 1.6;
        }
        
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .form-container {
          width: 100%;
            max-width: 600px;
        }
        
        fieldset {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        legend {
            font-size: 1.2em;
            font-weight: bold;
            padding: 0 10px;
            color: #333;
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        label {
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        /* Стиль для полей с ошибкой */
        input.error,
        select.error,
        textarea.error {
            border: 2px solid red !important;
            background-color: #fff0f0;
        }
        
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        select[multiple] {
            height: 120px;
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }
        
        .radio-group label {
            font-weight: normal;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group label {
            font-weight: normal;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .form-container {
                max-width: 100%;
            }
            
            fieldset {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="form-container">
            <fieldset>
                <legend>Регистрационная форма</legend>
                
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <?php echo $message; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <!-- Поле ФИО -->
                    <div class="form-group">
                        <label for="FIO">ФИО:</label>
                        <input type="text" id="FIO" name="FIO" placeholder="Иванов Иван Иванович" 
                               <?php echo !empty($errors['FIO']) ? 'class="error"' : ''; ?> 
                               value="<?php echo htmlspecialchars($values['FIO'] ?? ''); ?>" />
                               <?php if (!empty($errors['FIO']) && !empty($error_messages['FIO'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['FIO']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Телефон -->
                    <div class="form-group">
                        <label for="telep">Телефон:</label>
                        <input type="tel" id="telep" name="telep" placeholder="+7 (999) 123-45-67" 
                               <?php echo !empty($errors['telep']) ? 'class="error"' : ''; ?> 
                               value="<?php echo htmlspecialchars($values['telep'] ?? ''); ?>" />
                        <?php if (!empty($errors['telep']) && !empty($error_messages['telep'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['telep']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Email -->
                    <div class="form-group">
                        <label for="mail">Электронная почта:</label>
                        <input type="email" id="mail" name="mail" placeholder="yourmail@mail.ru" 
                               <?php echo !empty($errors['mail']) ? 'class="error"' : ''; ?> 
                               value="<?php echo htmlspecialchars($values['mail'] ?? ''); ?>" />
                        <?php if (!empty($errors['mail']) && !empty($error_messages['mail'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['mail']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Дата -->
                    <div class="form-group">
                        <label for="date">Дата рождения:</label>
                        <input type="date" id="date" name="date" 
                               <?php echo !empty($errors['date']) ? 'class="error"' : ''; ?> 
                               value="<?php echo htmlspecialchars($values['date'] ?? ''); ?>" />
                        <?php if (!empty($errors['date']) && !empty($error_messages['date'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['date']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Пол -->
                    <div class="form-group">
                        <label>Пол:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="sex" value="Male" 
                                  <?php echo (($values['sex'] ?? '') == 'Male') ? 'checked' : ''; ?> /> Мужской</label>
                            <label><input type="radio" name="sex" value="Female" 
                                  <?php echo (($values['sex'] ?? '') == 'Female') ? 'checked' : ''; ?> /> Женский</label>
                        </div>
                        <?php if (!empty($errors['sex']) && !empty($error_messages['sex'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['sex']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Языки -->
                    <div class="form-group">
                        <label for="language">Любимый язык программирования:</label>
                        <select id="language" name="language[]" multiple="multiple" 
                                <?php echo !empty($errors['language']) ? 'class="error"' : ''; ?>>
                            <option value="PHP" <?php echo in_array('PHP', ($values['language'] ?? array())) ? 'selected' : ''; ?>>PHP</option>
                            <option value="Python" <?php echo in_array('Python', ($values['language'] ?? array())) ? 'selected' : ''; ?>>Python</option>
                            <option value="Java" <?php echo in_array('Java', ($values['language'] ?? array())) ? 'selected' : ''; ?>>Java</option>
                            <option value="JavaScript" <?php echo in_array('JavaScript', ($values['language'] ?? array())) ? 'selected' : ''; ?>>JavaScript</option>
                            <option value="C++" <?php echo in_array('C++', ($values['language'] ?? array())) ? 'selected' : ''; ?>>C++</option>
                            <option value="Go" <?php echo in_array('Go', ($values['language'] ?? array())) ? 'selected' : ''; ?>>Go</option>
                        </select>
                        <?php if (!empty($errors['language']) && !empty($error_messages['language'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['language']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Биография -->
                    <div class="form-group">
                        <label for="bio">Биография:</label>
                        <textarea id="bio" name="bio" placeholder="Расскажите о себе" 
                               <?php echo !empty($errors['bio']) ? 'class="error"' : ''; ?>><?php echo htmlspecialchars($values['bio'] ?? ''); ?></textarea>
                        <?php if (!empty($errors['bio']) && !empty($error_messages['bio'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['bio']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Поле Согласие -->
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="agreement" name="agreement" value="on" 
                                   <?php echo (($values['agreement'] ?? '') == 'on') ? 'checked' : ''; ?> 
                                   <?php echo !empty($errors['agreement']) ? 'class="error"' : ''; ?> />
                            <label for="agreement">С контрактом ознакомлен(а)</label>
                        </div>
                        <?php if (!empty($errors['agreement']) && !empty($error_messages['agreement'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error_messages['agreement']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit">Отправить</button>
                </form>
            </fieldset>
        </div>
    </main>
</body>
</html>