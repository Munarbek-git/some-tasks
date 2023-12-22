<?php
function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        $db = mysqli_connect("localhost", "root", "123123", "database");
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
        mysqli_close($db);
    }
    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}

/*
 * Уязвимость это SQL-инъекция
 * пример $_GET['user_ids'] = '1;"drop table users;' примерно так и можно удалить таблицу users.
 */


/**
 * 1. Добавим типизацию параметра и возвращаемого значения
 * 2. Добавим вывод ошибки в случае ошибки подключения или подготовки
 * 3. Множественный запрос в базу сократим до одного
 * 4. Заполним user-ids методом bind_param
 */
function load_users_data_v2(string $userIds): array
{
    $userIds = explode(',', $userIds);

    if (count($userIds)) {
        return []; //смысла нет подключаться к базе, если user id нет
    }

    /**
     * Также можно было бы провалидировать каждое значение на integer и больше 0, но так как в sql запросе на IN все отфильтруется.
     */

    $db = mysqli_connect("localhost", "root", "123123", "database");

    if ($db->connect_error) {
        die("Ошибка подключения: " . $db->connect_error);
    }

    $prepareIdsForQuery = implode(',', array_fill(0, count($userIds), '?'));

    $query = sprintf("SELECT * FROM users WHERE id IN (%s)", $prepareIdsForQuery);

    $stmt = $db->prepare($query);

    if ($stmt) {
        /** Создание строки с типами данных (в данном случае, integer) */
        $types = str_repeat('i', count($userIds));

        /** Подготовка массива значений для передачи в bind_param */
        $params = array_merge([$types], $userIds);

        /**
         * Использование call_user_func_array для передачи параметров в bind_param.
         * Используем bind_param для предотвращения sql-инъекции. Помогает в большинстве случаев, но по моему были еще какие способы обойти эту защиту
         * */
        call_user_func_array([$stmt, 'bind_param'], $params);

        $stmt->execute();

        $result = $stmt->get_result();
        while($obj = $result->fetch_object()){
            $data[$obj->id] = $obj->name;
        }
    } else {
        die("Ошибка подготовки запроса: " . $db->error);
    }

    mysqli_close($db);

    return $data;
}