var app = {

    init: function() {
        console.log('init');
        
        // je récup mes label
        var $listLabel = $('.content_new-msg form #message div #message_users label');

        $listLabel.addClass('black')
        // j'attribu un event et je le passe à app.handleLabelClick
        $listLabel.on('click', app.handleLabelClick);

        var $buttonDelete = $('#button_delete')

        $buttonDelete.on('click', app.handleClickDeleteMessage)

    },

    handleLabelClick: function(evt) {
        console.log('koukou')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('black') == true) {
            
            $label.removeClass('black').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('black');
        }  else {
            
        }
    },

    handleClickDeleteMessage: function(evt) {
        console.log('delete')

        
    }
}; 
  
$(app.init);

