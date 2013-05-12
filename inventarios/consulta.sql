select mp.idMateriaPrima, mp.nombre, 
p.nombre, s.precioactual, s.cantidad,
mp.unidad, s.fecha_caducidad
from materiaprima mp, proveedor p, 
suministro s
where mp.idMateriaPrima = s.idMateriaPrima
and p.RFC = s.RFC;


insert into suministro(PrecioActual, RFC, idMateriaPrima) VALUES(1000, 'QWER123456', 1);


INSERT INTO compra_mp VALUES(41, 12, 6);
INSERT INTO compra_mp VALUES(40, 3, 6);
INSERT INTO compra_mp VALUES(43, 5, 6);
INSERT INTO compra_mp VALUES(40, 12, 6);
INSERT INTO compra_mp VALUES(36, 8, 6);
INSERT INTO compra_mp VALUES(37, 6, 6);
INSERT INTO compra_mp VALUES(38, 3, 6);
INSERT INTO compra_mp VALUES(39, 1, 6);
INSERT INTO compra_mp VALUES(38, 2, 6);
INSERT INTO compra_mp VALUES(34, 3, 6);


SELECT i.idLote,m.nombre, p.nombre ,i.cantidad, i.Fecha_Llegada, i.fecha_caducidad 
FROM inventario_mp i,  proveedor p, materiaprima m
WHERE i.idMateriaPrima = m.idMateriaPrima
AND i.RFC = p.RFC;