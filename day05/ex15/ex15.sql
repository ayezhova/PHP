select REVERSE(RIGHT(phone_number, char_length(phone_number) - 1)) as rebmunenohp from distrib
WHERE LEFT(phone_number, 2) = "05"