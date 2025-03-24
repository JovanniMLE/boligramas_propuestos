function html_form_handle(input, funcion, ...parametros) {
   if (input.form.checkValidity( )) {
      funcion(...parametros);
   }
}

function selected_option_index(select, valor) {
	for (let i = 0; i != select.options.length; ++i) {
		if (select.options[i].value == valor) {
			return i;
		}
	}
	return -1;
}

function selected_radio_value(radio) {
	for (let i = 0; i != radio.length; ++i) {
		if (radio[i].checked) {
			return radio[i].value;
		}
	}
	return undefined;
}

function html_escape(cadena) {
  return cadena.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&apos;");
}

function html_unescape(cadena) {
	return cadena.replace(/&apos;/g, "'").replace(/&quot;/gi, '"').replace(/&gt;/gi, ">").replace(/&lt;/gi, "<").replace(/&amp;/gi, '&');
}
