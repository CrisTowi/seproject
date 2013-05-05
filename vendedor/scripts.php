        <script type="text/javascript" src="../js/validaciones.js"></script>
        <script type="text/javascript" src="../js/color.js"></script>
        <script type="text/javascript" src="../js/ventas.js"></script>
        <script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
		<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/ajax.js"></script>
		<script type="text/javascript" src="../js/tablas.js"></script>
		<script type="text/javascript" src="../js/mensajes.js"></script>
		<script type="text/javascript" src="../js/navigation.js"></script>
		
		<script type="text/javascript">	
		window.onload = resizeWindow;
		    window.onresize = resizeWindow;
		    function resizeWindow() {
                var w=window.innerWidth;
                if (w < 1060) {
                    var newSize = w - 260;
                    var windowSize = w - 60;
                    document.getElementById("all-content").style.width = new String(newSize) + "px";
                    document.getElementById("mainDiv").style.width = new String(windowSize) + "px";
                    console.log(newSize);
                    console.log(document.getElementById("all-content").style.width);
                } else {
                    document.getElementById("all-content").style.width = "800px";
                    document.getElementById("mainDiv").style.width = "1050px";
                }
		    }
		    </script> 
<script type="text/javascript">
	$(function () {
		var dates = $("#from, #to").datepicker
		(
			{
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,

				onSelect: function (selectedDate) {
					var option = this.id == "from" ? "minDate" : "maxDate",
						instance = $(this).data("datepicker"),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings);
					dates.not(this).datepicker("option", option, date);
				}
			}
		);
	});
</script> 
		    