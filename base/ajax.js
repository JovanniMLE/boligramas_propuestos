function json_eval(cadena) {
   try {
      return JSON.parse(cadena);
   } catch (e) {
      return undefined;
   }
}

function ajax_formdata(parametros) {
   let res = new FormData( );
   for (let nombre in parametros) {
      res.append(nombre, parametros[nombre]);
   }
   return res;
}

function ajax_get(url, timeout, progreso = null) {
   let ajax = new XMLHttpRequest( );
   ajax.open("GET", url);
   return ajax_send(ajax, null, timeout, progreso);
}

function ajax_post(url, parametros, timeout, progreso = null) {
   let ajax = new XMLHttpRequest( );
   ajax.open("POST", url);
   return ajax_send(ajax, ajax_formdata(parametros), timeout, progreso);
}

function ajax_send(ajax, parametros, timeout, progreso = null) {
   return new Promise(function(resolver) {
      ajax.timeout = timeout;
      ajax.onload = ( ) => {
         resolver((ajax.status == 200 ? json_eval(ajax.responseText) : new Error("load")));
      };
      ajax.onabort = ( ) => {
         resolver(new Error("abort"));
      };
      ajax.onerror = ( ) => {
         resolver(new Error("error"));
      };
      ajax.ontimeout = ( ) => {
         resolver(new Error("timeout"));
      };
      if (progreso != null) {
         ajax.onprogress = (evento) => {
            progreso(evento.loaded, evento.total);
         }
      }
      
      ajax.send(parametros);
   });
}
