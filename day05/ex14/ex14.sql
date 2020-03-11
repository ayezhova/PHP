SELECT floor_number as floor, SUM(nb_seats) as seats from cinema
GROUP BY floor_number
ORDER BY nb_seats;