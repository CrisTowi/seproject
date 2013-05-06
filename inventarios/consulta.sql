select mp.idMateriaPrima, mp.nombre, 
p.nombre, s.precioactual, s.cantidad,
mp.unidad, s.fecha_caducidad
from materiaprima mp, proveedor p, 
suministro s
where mp.idMateriaPrima = s.idMateriaPrima
and p.RFC = s.RFC;

