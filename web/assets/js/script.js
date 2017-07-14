/**
 * Created by sebby on 17/06/17.
 */
$(function() {
    var dateToday = new Date();
    function checkPossibleType (dateText) {
        console.log(dateText);
        var splitDate = dateText.split("/");
        var dateSelected = new Date(splitDate[2], splitDate[1]-1, splitDate[0]);
        if (dateSelected.toDateString() === dateToday.toDateString())
        {
            console.log(new Date().getHours());
            if (new Date().getHours() >= 14)
            {
                console.log("Should be desactivated");
                $('#home_type option[value="full"]').prop('disabled', true);
                $('#home_type option[value="half"]').prop('selected', true);
            }
        }
        else {
            console.log("Should be activated");
            $('#home_type option[value="full"]').prop('disabled', false);
        }

        console.log(dateSelected);
    }
    function disableDays(date) {
        var day = date.getDay();
        // Disable Tuesday and sunday
        if (day == 2 || day == 0) {
            return [false] ;
        } else if(date.getDate() == 1 && date.getMonth() == 4 ||
            date.getDate() == 1 && date.getMonth() == 10 ||
            date.getDate() == 25 && date.getMonth() == 11) {
            return [false] ;
        }
        else {
            return [true] ;
        }
    }
    $("#home_visitDate").datepicker({
        dateFormat: 'dd/mm/yy',
        firstDay: 1 ,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
        minDate: dateToday,
        onSelect: checkPossibleType,
        beforeShowDay: disableDays,
    });



});