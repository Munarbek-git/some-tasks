# так как не было условий по поводу СУБД, я выбрал MYSQL
# для POSTGRES ENUM type надо будет отдельно создать, дополнительно надо будет пройтись по функицям.
# В целом представил два варианта, по explain на выборке 80к записей второй вариант на 20 -30% быстрее.
# Данные были тестовые, возможно при других данных будут другие результаты


CREATE TABLE `users` (
      `id` 		INT(11) NOT NULL AUTO_INCREMENT,
      `name` 	VARCHAR(255) NOT NULL,
      `gender`	ENUM('0', '1', '2') NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
      `birth_date`	INT(11) NOT NULL COMMENT 'Дата в unixtime.',
      PRIMARY KEY (`id`)
);

CREATE INDEX ix_users_birth_date on users(birth_date);

CREATE TABLE `phone_numbers` (
     `id` 		INT(11) NOT NULL AUTO_INCREMENT,
     `user_id`	INT(11) NOT NULL,
     `phone`	VARCHAR(255) DEFAULT NULL,
     PRIMARY KEY (`id`),
     CONSTRAINT fx__users__id__phone_numbers__user_id FOREIGN KEY  (user_id) references users(id)
);

#первый вариант
EXPLAIN select name, (select count(8) from phone_numbers where phone_numbers.user_id = users.id) as phone_count from users
        where birth_date between UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 22 YEAR))
                  AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 18 YEAR)) and gender = '2';

#второй вариант
EXPLAIN select t.name, count(phone) as count
from (select u.id as user_id, u.name as name, pn.phone as phone
      from users u
      left join phone_numbers pn on u.id = pn.user_id
      where u.birth_date between UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 22 YEAR))
        AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 18 YEAR))  and gender = '2') as t
GROUP BY t.user_id
# having count > 0




