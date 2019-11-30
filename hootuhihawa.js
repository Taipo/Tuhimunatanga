(function($){
  var code = $('.html-container').html();
  $('.html-viewer').text(code);
})(jQuery);

function papatopenga() {
  var kupuhipa_taaura = document.getElementById("kupuhipa");

  kupuhipa_taaura.select();
  kupuhipa_taaura.setSelectionRange(0, 99999); /*For mobile devices*/

  document.execCommand("copy");

  aho = takai_kupu(kupuhipa_taaura.value, 40);

  alert("Kua Whakataaura te Kupuhipa:\n" + aho);
}

function takai_kupu(aho, hitawetawe) {
    var ahorarangihou = "\n"; kua_mutu = false; oti = '';
    while (aho.length > hitawetawe) {                 
        rokohina = false;
        for (i = hitawetawe - 1; i >= 0; i--) {
            if (whakamaatautau(aho.charAt(i))) {
                oti = oti + [aho.slice(0, i), ahorarangihou].join('');
                aho = aho.slice(i + 1);
                rokohina = true;
                break;
            }
        }
        if (!rokohina) {
            oti += [aho.slice(0, hitawetawe), ahorarangihou].join('');
            aho = aho.slice(hitawetawe);
        }

    }

    return oti + aho;
}
function whakamaatautau(x) {
    var tea = new RegExp(/^\s$/);
    return tea.test(x.charAt(0));
};