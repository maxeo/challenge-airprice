SELECT * FROM(
SELECT
	f.code_departure AS departure_0,
	f.code_arrival AS arrival_0,
	f1.code_departure AS departure_1,
	f1.code_arrival AS arrival_1,
	NULL AS departure_2,
	NULL AS arrival_2,
	f1.code_arrival IS NULL AS diretto,
  IF(f1.code_arrival IS NULL, 0, 1) AS transfer,
  IF(f1.code_arrival IS NULL, f.price, f.price + f1.price) AS price
FROM
	flights f	LEFT JOIN flights f1 ON f1.code_departure = f.code_arrival 	AND f1.code_arrival = 'FIR' 
WHERE
	1 = 1 
	AND f.code_departure = 'AMS' 
	AND (f.code_arrival = 'FIR'  OR	f1.code_arrival = 'FIR')

UNION ALL

SELECT
	f.code_departure AS departure_0,
	f.code_arrival AS arrival_0,
	f1.code_departure AS departure_1,
	f1.code_arrival AS arrival_1,
	f2.code_departure AS departure_2,
	f2.code_arrival AS arrival_2,
	f.code_arrival = 'FIR' AS diretto,
	2 AS scali,
	f.price + f1.price + f2.price AS price 
FROM
	flights f
	LEFT JOIN flights f1 ON f1.code_departure = f.code_arrival
	LEFT JOIN flights f2 ON f2.code_departure = f1.code_arrival 
WHERE
	1 = 1 
	AND f.code_departure = 'AMS' 
	AND f2.code_arrival = 'FIR' 
	AND f1.code_departure != 'FIR' 
	AND f1.code_arrival != 'AMS'


)q
ORDER BY price
