SELECT title, summary FROM film
WHERE summary like "%42%" OR title like "%42%"
ORDER BY duration;