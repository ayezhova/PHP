select count(*) as movies from member_history
WHERE (DATE(`date`) > DATE('2006-10-30')) AND (DATE(`date`) < DATE('2007-07-27'))
OR (DATE_FORMAT(DATE(`date`), "%M %D") = DATE_FORMAT(DATE('2006-12-24'), "%M %D"))