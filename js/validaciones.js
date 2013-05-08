function validarCurp(curp){
	curp=curp.toUpperCase().trim();
	var re = /[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{1}[0-9]{1}/;
	return re.exec(curp);
}
function validarRFC(rfc){
	rfc=rfc.toUpperCase().trim();
	if(rfc.length<=12)
	{var re = /[A-Z]{3}[0-9]{6}[A-Z0-9]{3}/;}
	else 
	{var re = /[A-Z]{4}[0-9]{6}[A-Z0-9]{3}/;}
	return re.exec(rfc);
}
function validarTel(tel){
	var re = /[0-9]{2}[-. ]?[0-9]{2}[-. ]?[0-9]{2}[-. ]?[0-9]{2}/;
	return re.exec(tel);
}
function validarEma(ema) {
	var re= /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
   	return re.exec(ema);
}