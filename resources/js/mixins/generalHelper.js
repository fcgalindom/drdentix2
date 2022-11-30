import moment from "moment";
import { Base64 } from 'js-base64';


export default {
    firstCapitalLetter: str => str.charAt(0).toUpperCase() + str.slice(1),
    computed: {
        $capitalizeFirstLetter(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
    },
    methods: {
        $encode64(obj){
            if(obj)
               return Base64.encode(obj)
        },
        $decode64(obj){
            if(obj)
                return Base64.decode(obj)
        },
        $getUrlPathSegments() {
            return (new URL(window.location.href)).pathname.split('/').filter(Boolean)
           },
        $fechaYhora(fecha = null,formato=false) {
            moment.locale('es');
            if (!fecha) {
                var fecha = moment().format('Y-m-d');
            }
            if (formato) {
                return moment(fecha).format('D MMMM YYYY');
            }
            return moment(fecha).format('D MMMM YYYY , h:mm:ss a');
        },
        $fecha(fecha = null) {
            if (!fecha) {
                var fecha = moment().format('Y-m-d');
            }
            moment.locale('es');
            return moment(fecha).format('D')+' de '+moment(fecha).format('MMMM')+' del '+moment(fecha).format('YYYY');
        },
        $numeroconpuntomiles(num = 0) {
            var sign;
            var cents;
            num = num.toString().replace(/\$|\,/g, '');
            if (isNaN(num))
                return num = "0";
            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num * 100 + 0.50000000001);
            cents = num % 100;
            num = Math.floor(num / 100).toString();
            if (cents < 10)
                cents = "0" + cents;
            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                num = num.substring(0, num.length - (4 * i + 3)) + '.' +
                    num.substring(num.length - (4 * i + 3));
            console.log((((sign) ? '' : '-') + num));
            return (((sign) ? '' : '-') + num);
        },
        // e= evento,, texo= lo que se escribe, cantidad= lo limitado, sololimitar= 1 (si quiere numeros) null (solo texto)
        $isLetter(e, texto = [], cantidad, soloLimitar = '') {
            // console.log(texto.length+" **** "+cantidad)
            if (texto.length > cantidad) e.preventDefault();
            if (soloLimitar == "") {
              let char = String.fromCharCode(e.keyCode); // Get the character
              if (/^[A-Za-z\s\u00E0-\u00FC-\u0000-\uFFFF]+$/.test(char)) return true;
              // Match with regex
              else e.preventDefault(); // If not match, don't add to input text
            }
        },
        $solotextoYcarateres(e, texto = [], cantidad) {

            if (texto.length > cantidad) e.preventDefault();
            let char = String.fromCharCode(e.keyCode); // Get the character
            if (/^[A-Za-z\s]+$/.test(char))
                return true;
            else if (!/^[0-9]+$/.test(char))
                return true;
            else e.preventDefault(); // If not match, don't add to input text
        },
        $isEmpty(val) {
            if (val === undefined || val === null || val === '' || val === "" || val == 'null' || val == 'undefined') {
                return true
            } else {
                return false
            }
        },
        $phonenumber(inputtxt)
            {
            var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
            if(inputtxt.value.match(phoneno)){
                return true;
                    }
                else
                    {
                    alert("message");
                    return false;
                    }
            },

        $phone_number_mask(id) {
            var myMask = "(___) ___-____";
            var myCaja = document.getElementById(id);
            var myText = "";
            var myNumbers = [];
            var myOutPut = ""
            var theLastPos = 1;
            myText = myCaja.value;
            //get numbers
            for (var i = 0; i < myText.length; i++) {
              if (!isNaN(myText.charAt(i)) && myText.charAt(i) != " ") {
                myNumbers.push(myText.charAt(i));
              }
            }
            //write over mask
            for (var j = 0; j < myMask.length; j++) {
              if (myMask.charAt(j) == "_") { //replace "_" by a number
                if (myNumbers.length == 0)
                  myOutPut = myOutPut + myMask.charAt(j);
                else {
                  myOutPut = myOutPut + myNumbers.shift();
                  theLastPos = j + 1; //set caret position
                }
              } else {
                myOutPut = myOutPut + myMask.charAt(j);
              }
            }
          },
        $isNumber(e, texto = [], cantidad = 20) {
            console.log('numero = ',texto);
            if (texto.length >= cantidad) e.preventDefault();

            let char = String.fromCharCode(e.keyCode); // Get the character
            if (/^[+0123456789]+$/.test(char)) return true;
            // Match with regex
            else e.preventDefault(); // If not match, don't add to input text
        },
        $isNumberPositivo(evento=null) {
            const teclaPresionada = evento.key;
            const teclaPresionadaEsUnNumero =
              Number.isInteger(parseInt(teclaPresionada));

            const sePresionoUnaTeclaNoAdmitida =
              teclaPresionada != 'ArrowDown' &&
              teclaPresionada != 'ArrowUp' &&
              teclaPresionada != 'ArrowLeft' &&
              teclaPresionada != 'ArrowRight' &&
              teclaPresionada != 'Backspace' &&
              teclaPresionada != 'Delete' &&
              teclaPresionada != 'Enter' &&
              !teclaPresionadaEsUnNumero;
            const comienzaPorCero =
            evento.value.length === 0 &&
              teclaPresionada == 0;

            if (sePresionoUnaTeclaNoAdmitida || comienzaPorCero) {
              evento.preventDefault();
            }
        },
        $parseVillegas(value = '0') {
            let response = parseInt(value).toLocaleString('es-CO')
            if(response) {
                return '$' + response
            }else {
                return '0'
            }
        },
        $num_miles(num = 0) {
                num = num.toString().replace(/\$|\,/g, '');
                if (isNaN(num))
                    return num = "0";
                var sign = (num == (num = Math.abs(num)));
                num = Math.floor(num * 100 + 0.50000000001);
                var cents = num % 100;
                num = Math.floor(num / 100).toString();
                if (cents < 10)
                    cents = "0" + cents;
                for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                    num = num.substring(0, num.length - (4 * i + 3)) + ',' +
                        num.substring(num.length - (4 * i + 3));

                // console.log("VALORES",(((sign) ? '' : '-') + num));
                return (((sign) ? '' : '-') + num);

        },
        $numDecimales(e, texto = [], cantidad = 20) {
            // console.log('numero = ',texto);
            if (texto.length >= cantidad) e.preventDefault();

            let char = String.fromCharCode(e.keyCode); // Get the character
            if (/^[0-9.]+$/.test(char)) return true;
            // Match with regex
            else e.preventDefault(); // If not match, don't add to input text
        },
        $quitarComas(num) {
            num=num.replace(',','');
            num=num.replace(',','');
            num=num.replace(',','');
            num=num.replace(',','');
            num=num.replace(',','');
            num=num.replace(',','');
            return num;
        },
        $tabla(tablaId) {
            $("#" + tablaId).DataTable().destroy();
            this.$nextTick(() => {
                $("#" + tablaId).DataTable({
                    //    destroy:true,
                    searching: true,
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    initComplete: function () {
                        $("#tabla_contacts_wrapper > .row").addClass("w-100");
                        $("#tabla_contacts_wrapper > .row > .col-xs-12.col-md-6").addClass(
                            "col-lg-6 text-left"
                        );
                        $("#tabla_contacts_wrapper .row")
                            .eq(1)
                            .find(".col-xs-12")
                            .addClass("w-100");
                    },
                });
            });
        },
        $cerrar_modal() {
            $("#editgu").modal("hide");
        },
        $showTabOnModal(btn, target) {
            $('#nav-tabContent a').removeClass('active')
            $('#navstab-up a, .navs-tabContents a, .navs-tabContents button').addClass('inactive')
            $(btn).removeClass('inactive')
            $('#nav-tabContent .tab-pane').removeAttr('style').removeClass('show active')
            $('#nav-tabContent ' + target + '.tab-pane').fadeIn(280, function () { $(this).addClass('show active').removeAttr('style') })
            $('#nav-tabContent a').removeClass('active')
        },
        $asset(path) {
            var base_path = window._asset || '';
            return base_path + path;
        },
        $openModal(modalID) {
            $("#"+modalID).modal("show");
        },
        $closeModal(modalID) {
            $("#" + modalID).modal("hide");
        },

    $Unidades(num){

        switch(num)
        {
            case 1: return 'UN';
            case 2: return 'DOS';
            case 3: return 'TRES';
            case 4: return 'CUATRO';
            case 5: return 'CINCO';
            case 6: return 'SEIS';
            case 7: return 'SIETE';
            case 8: return 'OCHO';
            case 9: return 'NUEVE';
        }

        return '';
    },//Unidades()

    $Decenas(num){

        let decena = Math.floor(num/10);
        let unidad = num - (decena * 10);

        switch(decena)
        {
            case 1:
                switch(unidad)
                {
                    case 0: return 'DIEZ';
                    case 1: return 'ONCE';
                    case 2: return 'DOCE';
                    case 3: return 'TRECE';
                    case 4: return 'CATORCE';
                    case 5: return 'QUINCE';
                    default: return 'DIECI' + $Unidades(unidad);
                }
            case 2:
                switch(unidad)
                {
                    case 0: return 'VEINTE';
                    default: return 'VEINTI' + $Unidades(unidad);
                }
            case 3: return $DecenasY('TREINTA', unidad);
            case 4: return $DecenasY('CUARENTA', unidad);
            case 5: return $DecenasY('CINCUENTA', unidad);
            case 6: return $DecenasY('SESENTA', unidad);
            case 7: return $DecenasY('SETENTA', unidad);
            case 8: return $DecenasY('OCHENTA', unidad);
            case 9: return $DecenasY('NOVENTA', unidad);
            case 0: return $Unidades(unidad);
        }
    },//Unidades()

    $DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + ' Y ' + $Unidades(numUnidades)

        return strSin;
    },//DecenasY()

    $Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - (centenas * 100);

        switch(centenas)
        {
            case 1:
                if (decenas > 0)
                    return 'CIENTO ' + $Decenas(decenas);
                return 'CIEN';
            case 2: return 'DOSCIENTOS ' + $Decenas(decenas);
            case 3: return 'TRESCIENTOS ' + $Decenas(decenas);
            case 4: return 'CUATROCIENTOS ' + $Decenas(decenas);
            case 5: return 'QUINIENTOS ' + $Decenas(decenas);
            case 6: return 'SEISCIENTOS ' + $Decenas(decenas);
            case 7: return 'SETECIENTOS ' + $Decenas(decenas);
            case 8: return 'OCHOCIENTOS ' + $Decenas(decenas);
            case 9: return 'NOVECIENTOS ' + $Decenas(decenas);
        }

        return $Decenas(decenas);
    },//Centenas()

    $Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let letras = '';

        if (cientos > 0)
            if (cientos > 1)
                letras = $Centenas(cientos) + ' ' + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += '';

        return letras;
    },//Seccion()

    $Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMiles = $Seccion(num, divisor, 'UN MIL', 'MIL');
        let strCentenas = $Centenas(resto);

        if(strMiles == '')
            return strCentenas;

        return strMiles + ' ' + strCentenas;
    },//Miles()

    $Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMillones = $Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
        let strMiles = $Miles(resto);

        if(strMillones == '')
            return strMiles;

        return strMillones + ' ' + strMiles;
    },//Millones()

     $NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: '',
            letrasMonedaPlural: currency.plural || 'Peso',//'PESOS', 'Dólares', 'Bolívares', 'etcs'
            letrasMonedaSingular: currency.singular || 'Pesos', //'PESO', 'Dólar', 'Bolivar', 'etc'
            letrasMonedaCentavoPlural: currency.centPlural || 'Centavos',
            letrasMonedaCentavoSingular: currency.centSingular || 'Centavo'
        };

        if (data.centavos > 0) {
            data.letrasCentavos = 'CON ' + (function () {
                    if (data.centavos == 1)
                        return $Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
                    else
                        return $Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
                })();
        };

        if(data.enteros == 0)
            return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
            return $Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
            return $Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    },
    $dv(T){
        var M=0,S=1;
        for(;T;T=Math.floor(T/10))
            S=(S+T%10*(9-M++%6))%11;
        return S?S-1:'k';
    },
        $validaRut(rutCompleto) {
            if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
                return false;
            var tmp 	= rutCompleto.split('-');
            var digv	= tmp[1];
            var rut 	= tmp[0];
            if ( digv == 'K' ) digv = 'k' ;
            return (this.$dv(rut) == digv );
        },
        $random_color( format ){
            var rint = Math.floor( 0x100000000 * Math.random());
            switch( format ){
              case 'hex':
                return '#' + ('00000'   + rint.toString(16)).slice(-6).toUpperCase();
              case 'hexa':
                return '#' + ('0000000' + rint.toString(16)).slice(-8).toUpperCase();
              case 'rgb':
                return 'rgb('  + (rint & 255) + ',' + (rint >> 8 & 255) + ',' + (rint >> 16 & 255) + ')';
              case 'rgba':
                return 'rgba(' + (rint & 255) + ',' + (rint >> 8 & 255) + ',' + (rint >> 16 & 255) + ',' + (rint >> 24 & 255)/255 + ')';
              default:
                return rint;
            }
        },
        $months_array() {
            return [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ]
        }

    },
    mounted() {
        /*console.log('Component has been mounted!');*/
    },
    created() {
        /*console.log('Component has been created!');*/
    }
}
