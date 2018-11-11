-- Estado del registro digital

SELECT id, d1,d2,d3, (d1 * 4 + d2 * 2 + d3 * 1) as binario
FROM `registrodigital` 
where device_id = 9745721
ORDER BY `id`  DESC




-- consulta de registro digital con correccion de tiempo
SELECT r.id, d1, d2, d3, (ts+ IFNULL(c.correccion,0)) as ts, ts as originalts, fecha ,duracion ,device_id  
FROM registrodigital r
LEFT JOIN configuraciones c
on r.device_id = c.device 
where d1 != 9 and d2 != 9 and d3 != 9
and r.device_id = @device
ORDER BY `r`.`id`  ASC