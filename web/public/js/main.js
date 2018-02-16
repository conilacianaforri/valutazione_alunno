
    var getPrototypeContent = function($selector, $newIndex) {
        var prototype = $($selector).data("prototype");
        if (prototype) {
            var newForm = prototype;
            return newForm = newForm.replace(/__name__/g, $newIndex);
        }
    }
    
    var addValutazioneItemToForm = function($selettore) {
        var $newIndex = $($selettore + ' tbody tr').length;
        var $formDescrizione = getPrototypeContent('.descrizione-prototype', $newIndex);
        var $formValutazione = getPrototypeContent('.valutazione-prototype', $newIndex);
        var $formMedia = getPrototypeContent('.fuori-media-prototype', $newIndex);
        $($selettore + ' > tbody:last-child').append(
                '<tr>' +
                '<td>' + $formDescrizione + '</td>' +
                ($formValutazione ? '<td>' + $formValutazione + '</td>' : '') +
                ($formMedia ? '<td>' + $formMedia + '</td>' : '') +
                '</tr>'
                );
    }