var app = {
    // Environnement de DEV
    baseUrl: 'http://localhost/Projet-Apo/O-Tableau/public/conversation/',
    // Environnement de PROD = serveur GANDI
    // baseUrl: 'http://92.243.9.5/conversation/',
    init: function() {
        console.log('init');
        
        // je récup mes label
        var $listLabel = $('.content_new-msg form #message div #message_users label');

        $listLabel.addClass('black')
        // j'attribu un event et je le passe à app.handleLabelClick
        $listLabel.on('click', app.handleLabelClick);

        // focus l'input d'envoie de message
        var $inputMsg = $('#field-message')
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


        // Formulaire d'add students

        var $listlabelStudents = $('.backend_student form #student div div label');

        $listlabelStudents.addClass('white')
        
        $listlabelStudents.on('click', app.handleLabelClickStudents);

        var $listlabelStudentsLunch = $('.backend_student form #student div .label_lunch');

        $listlabelStudentsLunch.addClass('white')
        
        $listlabelStudentsLunch.on('click', app.handleLabelClickStudentsLunch);

        var $listlabelStudentsImg = $('.backend_student form #student div .label_image');

        $listlabelStudentsImg.addClass('white')
        
        $listlabelStudentsImg.on('click', app.handleLabelClickStudentsImg);

        // Formulaire d'update students

        var $listlabelStudentsEdit = $('.student_show_update form #student div div label');

        $listlabelStudentsEdit.addClass('white')
        
        $listlabelStudentsEdit.on('click', app.handleLabelClickStudentsEdit);

        var $listlabelStudentsLunchEdit = $('.student_show_update form #student div .label_lunch');

        $listlabelStudentsLunchEdit.addClass('white')
        
        $listlabelStudentsLunchEdit.on('click', app.handleLabelClickStudentsLunchEdit);

        var $listlabelStudentsImgEdit = $('.student_show_update form #student div .label_image');

        $listlabelStudentsImgEdit.addClass('white')
        
        $listlabelStudentsImgEdit.on('click', app.handleLabelClickStudentsImgEdit);


        // Formulaire add user

        var $listlabelUser = $('.backend_user form #user div label');

        $listlabelUser.addClass('white')
        
        $listlabelUser.on('click', app.handleLabelClickUser);


        // Formulaire update user

        var $listlabelUserEdit = $('.user_show_update form #user div label');

        $listlabelUserEdit.addClass('white')
        
        $listlabelUserEdit.on('click', app.handleLabelClickUserEdit);


    
         
        $('body').on( 'submit','#field-form', app.loadMessage )
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

    handleLabelClickStudents: function(evt) {
        console.log('koukou4')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickStudentsLunch: function(evt) {
        console.log('koukou5')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickStudentsImg: function(evt) {
        console.log('koukou6')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickStudentsEdit: function(evt) {
        console.log('koukou7')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickStudentsLunchEdit: function(evt) {
        console.log('koukou8')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickStudentsImgEdit: function(evt) {
        console.log('koukou9')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickUser: function(evt) {
        console.log('koukou10')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },

    handleLabelClickUserEdit: function(evt) {
        console.log('koukou11')

        // contient l'élément précis sur lequel on a cliqué
        var $label = $(evt.target);

        // condition qui à pour but d'ajouté la class red au premier click puis d'ajouté la class black au second clique si red existe
        if ($label.hasClass('white') == true) {
            
            $label.removeClass('white').addClass('red');
            
        } else if ($label.hasClass('red') == true) {

             $label.removeClass('red').addClass('white');
        }  else {
            
        }
    },
    
    loadMessage: function(evt) {
        // console.log(evt)

        evt.preventDefault()
        
        inputMessage = $('#field-message').val();
        
        var id = $('#conversation-id').val()
        // console.log(id)
        // console.log(inputMessage)
        var jqXHR = $.ajax({
            url: app.baseUrl+id ,
            method: 'POST',
            dataType: 'json',
            data:{
            
            "message": inputMessage,
        
    
            }
    
        })
    
        jqXHR.done(
            
        );
        
       
    }

}; 
  
$(app.init);

