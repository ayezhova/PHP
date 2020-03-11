select UPPER(last_name) as last_name, first_name, price from user_card
INNER JOIN `member` ON `member`.id_user_card = user_card.id_user
INNER JOIN subscription ON `member`.id_sub = subscription.id_sub
WHERE price > 42
ORDER BY last_name ASC, first_name ASC;