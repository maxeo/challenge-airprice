SELECT * FROM(
    SELECT
        f.code_departure AS departure_0,
        f.code_arrival AS arrival_0,
        f1.code_departure AS departure_1,
        f1.code_arrival AS arrival_1,
        NULL AS departure_2,
        NULL AS arrival_2,
        f1.code_arrival IS NULL AS direct,
        IF(f1.code_arrival IS NULL, 0, 1) AS stopovers,
        IF(f1.code_arrival IS NULL, f.price, f.price + f1.price) AS price
    FROM
        flights f LEFT JOIN flights f1 ON f1.code_departure = f.code_arrival  AND f1.code_arrival = 'selected_arrival'
    WHERE
        1 = 1
        AND f.code_departure = 'selected_departure'
        AND (f.code_arrival = 'selected_arrival' OR f1.code_arrival = 'selected_arrival')

    UNION ALL

    SELECT
        f.code_departure AS departure_0,
        f.code_arrival AS arrival_0,
        f1.code_departure AS departure_1,
        f1.code_arrival AS arrival_1,
        f2.code_departure AS departure_2,
        f2.code_arrival AS arrival_2,
        FALSE AS direct,
        2 AS stopovers,
        f.price + f1.price + f2.price AS price
    FROM
        flights f
        LEFT JOIN flights f1 ON f1.code_departure = f.code_arrival
        LEFT JOIN flights f2 ON f2.code_departure = f1.code_arrival
    WHERE
        1 = 1
        AND f.code_departure = 'selected_departure'
        AND f2.code_arrival = 'selected_arrival'
        AND f1.code_departure != 'selected_arrival'
        AND f1.code_arrival != 'selected_departure'
    )q
ORDER BY price
