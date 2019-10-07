$(document).ready(function(){


    // Gestion des adresses multiples
    let $container = $('div#membre_adresses');
    let index = $('div#membre_adresses > div').length;
    let i = 1;
    $('div#membre_adresses label').each(function(){
        $(this).html('Adresse N° '+(i++));
    });

    if (index === 0) {
        addCategory($container);
    } else {
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }
    let $addCategoryLink  = $('<a href="#" id="add_category" class="btn bouton_lien">Ajouter une adresse</a>');
    $container.append($addCategoryLink);
    $addCategoryLink.click(function(e) {
        addCategory($container);
        $container.append($addCategoryLink);
        e.preventDefault();
        autocompleteAdresse();
        return false;
    });

    function addCategory($container) {
        let template = $container.attr('data-prototype')
            .replace(/__name__label__/g, ($('div#membre_adresses > div').length === 0 ? '' : 'Adresse N°'+(index+1)))
            .replace(/__name__/g,        index)
        ;
        let $prototype = $(template);
        addDeleteLink($prototype);
        $container.append($prototype);
        index++;
    }

    function addDeleteLink($prototype) {
        let $deleteLink = $('<a href="#" class="btn bouton_lien bouton_supprimer">Supprimer</a>');
        $deleteLink.css({
            "backgroundColor" : '#c63834',
            'marginBottom' : '5px',
            'float': 'right',
            'padding': '5px'
        });
        $prototype.prepend($deleteLink);
        $deleteLink.click(function(e) {
            $prototype.remove();
            e.preventDefault();
            i--;
            return false;
        });
    }

    // FadeIn En fonction de la catégorie du membre
    let $membreCategorie = $("#membre_categorie");
    let membreSociete    = $("#membre_societe");
    let $membreSiret = $("#membre_siret");
    let statutOnChange = function(){
        let statut = parseInt($membreCategorie.val());
        if ( statut === 2 ){
            membreSociete.parent().fadeIn('slow');
            $membreSiret.parent().fadeIn('slow');
        }else{
            membreSociete.parent().fadeOut('slow');
            $membreSiret.parent().fadeOut('slow');
        }
    };

    statutOnChange();
    $membreCategorie.change(statutOnChange);

    function autocompleteAdresse(){
        // Autocomplete Adresse
        $('.membre_adresse:not([class*="ap-input"])').each(function(){
            let place = places({
                container: this,
                templates: {
                    value: function (suggestion) {
                        return suggestion.name;
                    }
                }
            });
            place.on('change', e => {
                $(this).first().parent().parent().parent().find('.cp')[0].value = e.suggestion.postcode ? e.suggestion.postcode: '';
                $(this).first().parent().parent().parent().find('.city')[0].value = e.suggestion.city ? e.suggestion.city: '';
                $(this).first().parent().parent().parent().find('.country')[0].value = e.suggestion.country ? e.suggestion.country: '';
            })
        });
    }

    autocompleteAdresse()
});