SELECT title, summary FROM film
WHERE LOWER(summary) like "%vincent%"
ORDER BY id_film;