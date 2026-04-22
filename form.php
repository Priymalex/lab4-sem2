<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

    <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>

    <form action="" method="POST">
      <input type="text" name="FIO" placeholder="ФИО" <?php if ($errors['FIO']) {print 'class="error"';} ?> value="<?php print $values['FIO']; ?>" /><br/>
      <input type="text" name="telep" placeholder="Телефон" <?php if ($errors['telep']) {print 'class="error"';} ?> value="<?php print $values['telep']; ?>" /><br/>
      <input type="email" name="mail" placeholder="Email" <?php if ($errors['mail']) {print 'class="error"';} ?> value="<?php print $values['mail']; ?>" /><br/>
      <input type="date" name="date" <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date']; ?>" /><br/>
      
      <label><input type="radio" name="sex" value="Male" <?php if ($values['sex'] == 'Male') echo 'checked'; ?> /> Мужской</label>
      <label><input type="radio" name="sex" value="Female" <?php if ($values['sex'] == 'Female') echo 'checked'; ?> /> Женский</label>
      <?php if ($errors['sex']) {print '<span style="color:red;"> (ошибка)</span>';} ?><br/>
      
      <select name="language[]" multiple <?php if ($errors['language']) {print 'class="error"';} ?>>
        <option value="PHP" <?php if (in_array('PHP', $values['language'])) echo 'selected'; ?>>PHP</option>
        <option value="Python" <?php if (in_array('Python', $values['language'])) echo 'selected'; ?>>Python</option>
        <option value="Java" <?php if (in_array('Java', $values['language'])) echo 'selected'; ?>>Java</option>
        <option value="JavaScript" <?php if (in_array('JavaScript', $values['language'])) echo 'selected'; ?>>JavaScript</option>
        <option value="C++" <?php if (in_array('C++', $values['language'])) echo 'selected'; ?>>C++</option>
        <option value="Go" <?php if (in_array('Go', $values['language'])) echo 'selected'; ?>>Go</option>
      </select><br/>
      
      <textarea name="bio" placeholder="Биография" <?php if ($errors['bio']) {print 'class="error"';} ?>><?php print$values['bio']; ?></textarea><br/>
      <label><input type="checkbox" name="agreement" value="on" <?php if ($values['agreement'] == 'on') echo 'checked'; ?> /> С контрактом ознакомлен(а)</label>
      <?php if ($errors['agreement']) {print '<span style="color:red;"> (необходимо отметить)</span>';} ?><br/>
      
      <input type="submit" value="ok" />
    </form>
  </body>
</html>