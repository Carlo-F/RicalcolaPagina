// Origine https://www.web-link.it/scripting/4password.htm
// http://www.calvibit.net/areaprotetta2.html

function CalcolaPagina(form) {

     StringaImmessa = form.testoinput1.value;
     var Decodificata="";

TabCaratteri="0123456789abcdefghijklmnopqrstuvwxyz._~ABCDEFGHIJKLMNOPQRSTUVWXYZ";

     for(posiz=0; posiz < StringaImmessa.length; posiz++) {
     var QuestoChar = StringaImmessa.substring(posiz, posiz+1);
     var NuovaPos = TabCaratteri.indexOf(QuestoChar)^19;
    Decodificata += TabCaratteri.substring(NuovaPos, NuovaPos+1);
     }
 location = Decodificata + ".htm";
}
