function configure_attributes(elemento, atributos) {
   for (let clave in atributos) {
      elemento.setAttribute(clave, atributos[clave]);
   }
   return elemento;
}

function configure_properties(elemento, propiedades) {
   for (let clave in propiedades) {
      if (!Array.isArray(propiedades[clave])) {
         elemento[clave] = propiedades[clave];
      } else {
         configure_properties(elemento[clave], propiedades[clave]);
      }
   }
   return elemento;
}

function configure_node(elemento, configurar, ...hijos) {
   for (let nombre in configurar) {
      if (nombre in elemento) {
         if (typeof(elemento[nombre]) == "function") {
            elemento[nombre](...configurar[nombre]);
         } else {
            elemento[nombre] = configurar[nombre];
         }
      } else {
         window[nombre](elemento, ...configurar[nombre]);
      }
   }
   
   for (let hijo of hijos) {
      elemento.appendChild(hijo);
   }
   
   return elemento;
}

function create_html(tipo, configurar, ...hijos) {
   return configure_node(document.createElement(tipo), configurar, ...hijos);
}

function create_svg(tipo, configurar, ...hijos) {
   return configure_node(document.createElementNS("http://www.w3.org/2000/svg", tipo), configurar, ...hijos);
}

function create_xhtml(tipo, configurar, ...hijos) {
   return configure_node(document.createElementNS("http://www.w3.org/1999/xhtml", tipo), configurar, ...hijos);
}

function create_text(texto) {
   return document.createTextNode(texto);
}

function clear_children(elemento) {
   while (elemento.firstChild) {
      elemento.removeChild(elemento.firstChild);
   }
}
