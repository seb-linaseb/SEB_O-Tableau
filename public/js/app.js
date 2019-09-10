var app = {

    init: function() {
        console.log('init');
        
        // je récup mes label
        var $listLabel = $('.content_new-msg form #message div #message_users label');

        // j'attribu un event et je le passe à app.handleLabelClick
        $listLabel.on('click', app.handleLabelClick);
    },

    handleLabelClick: function(evt) {
        console.log('koukou')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // j'ajoute une class à mes label quand je click
        $label.addClass('red')

        // verifie si la class 'red' existe (renvoie booléen)
        console.log($label.hasClass('red'))

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('red') == false) {
            
            $label.addClass('red');

        } else if ($label.hasClass('red') == true) {
            $label.addClass('black');
        }  
    }
}; 
  
$(app.init);