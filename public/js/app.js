var app = {

    init: function() {
        console.log('init');
        
        // je récup mes label
        var $listLabel = $('.content_new-msg form #message div #message_users label');

        $listLabel.addClass('black')
        // j'attribu un event et je le passe à app.handleLabelClick
        $listLabel.on('click', app.handleLabelClick);

        // focus l'input d'envoie de message
        var $inputMsg = $('#message_content')
        $inputMsg.focus()

        // POUR SCROLLBAR EN BAS
        function mettre_curseur_en_bas(){
            obj=document.getElementById('message_list');
            console.log(obj)
            //On récupère le body, c'est on veut mettre le scroll sur lui
            var body=document.getElementsByTagName('body')[0];
            //Pour finir on applique le déplacement
            body.scrollTop = obj.scrollHeight;
            //On le fait sur le "html" car sous FF il me semble que ça marche pas
            var html=document.getElementsByTagName('html')[0];
            //Pour finir on applique le déplacement
            html.scrollTop = obj.scrollHeight;
            }
            window.onload = function(){mettre_curseur_en_bas();};

        // je récup mes label d'add actu
        var $listLabelActu = $('.add_actu_content form #actuality div #actuality_classroom label');
                                
        $listLabelActu.addClass('black')
        
        $listLabelActu.on('click', app.handleLabelClickActu);



        var $listLabelActuEdit = $('.actuality_show_update form #actuality div #actuality_classroom label');
        
        $listLabelActuEdit.addClass('black')
        
        $listLabelActuEdit.on('click', app.handleLabelClickActuEdit);
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

    handleLabelClickActu: function(evt) {
        console.log('koukou2')

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

    handleLabelClickActuEdit: function(evt) {
        console.log('koukou3')

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

    

    
}; 
  
$(app.init);

