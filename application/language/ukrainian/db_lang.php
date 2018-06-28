<?php
/**
 * CodeIgniter
 *
 * Compatible with versions 1.7.2 - 3 
 *
 * 
 *
 * @package		CodeIgniter
 * @author		Svyatoslav Varpihovsky
 * @since		Version 1.00
 * @email 		varpihovsky@gmail.com
 * @link		http://geega.net
 * @filesource
 * 
 */

$lang['db_invalid_connection_str'] 	= 'Не можу визначити налаштування БД з отриманого рядку підключення.';
$lang['db_unable_to_connect']		= 'Не можу з`єднатися з БЖ за допомогою вказаного логіна та пароля';
$lang['db_unable_to_select']		= 'Неможливо вибрати базу даних %s';
$lang['db_unable_to_create']		= 'Неможливо створити базу даних %s';
$lang['db_invalid_query']			= 'Спроба виконання неправильного запиту.';
$lang['db_must_set_table']			= 'В запиті необхідно вказати назву таблиці.';
$lang['db_must_set_database']		= 'Необхідно вказати назву БД у файлі конфігурації бази даних.';
$lang['db_must_use_set']			= 'Для оновлення запису необхідно використовувати SET.';
$lang['db_must_use_index'] 			= 'You must specify an index to match on for batch updates.';
$lang['db_batch_missing_index']		= 'Один або більше рідків надісланих для пакетного оновлення потребують задання індексів. ';
$lang['db_must_use_where']			= 'Запит на оновлення даних (UPDATE) не може бути виконано без умови WHERE.';
$lang['db_del_must_use_where']		= 'Запити на видалення даних (DELETE) не можуть бути виконані без умов WHERE чи LIKE.';
$lang['db_field_param_missing']		= 'Для отримання даних необхідно передати назву таблиці у вигляді параметру.';
$lang['db_unsupported_function']	= 'Для цієї БД ця операція недоступна.';
$lang['db_transaction_failure']		= 'Транзакцію перервано: виконано ROLLBACK';
$lang['db_unable_to_drop']			= 'Неможливо видалити БД.';
$lang['db_unsuported_feature']		= 'Ви намагаєтесь використовувати операції, що не підтримуються цією БД.';
$lang['db_unsuported_compression']	= 'Вибраний Вами формат зтиснення не підтримується сервером.';
$lang['db_filepath_error']			= 'Неможливо виконати запис у вказане Вами місце.';
$lang['db_invalid_cache_path']		= 'Неправильний шлях до кешу чи відсутні права на запис.';
$lang['db_table_name_required']		= 'Для виконання цієї операції необхідно вказати назву таблиці.';
$lang['db_column_name_required']	= 'Для виконання цієї операції необхідно вказати назву стовбця.';
$lang['db_column_definition_required']	= 'Для виконання цієї операції необхідно визначити стовбець.';
$lang['db_unable_to_set_charset']	= 'Неможливо встановити кодування клієнта та з`єднання: %s';
$lang['db_error_heading']			= 'Виникла помилка бази даних';

/* End of file db_lang.php */
/* Location: ./system/language/ukrainian/db_lang.php */