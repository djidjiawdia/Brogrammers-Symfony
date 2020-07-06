$(document).ready(function(){
    /** Menu Hamburger **/
    $(".btn-menu").on("click", function(){
        if($('.menu').css("display") == "none"){
            $('.menu').css("display", "flex");
            $(".btn-menu span").html('<i class="fas fa-times"></i>');
        }else{
            $('.menu').css("display", "none")
            $(".btn-menu span").html('<i class="fas fa-bars"></i>');
        }
    });
    
    // On change
    $("#chambre_batiment").on("change", function(){
        $("#chambre_numero").val(generateNumChambre(parseInt($("#lastId").val())+1, $(this).val()));
    });

    // Focus Out
    $("#chambre_batiment").on("focusout", function(){checkRequired([$(this)])});

    // Form Ajouter Etudiant
    $("#formAddStud").on("submit", function(e){
        e.preventDefault();
        if(checkRequired([$("#prenom"), $("#nom"), $("#email"), $("#tel")]) && checkOption([$("#type")])){
            console.log($(this).serialize());
        }
    })
})


function generateChoice(label1, label2, label3, name, val1, val2){
    return `
        <div class="form-group col-sm-6">
            <label>${label1}</label>
            <div class="d-flex justify-content-around" id="${name}">
                <label for="${val1}">
                    <input type="radio" name="${name}" id="${val1}" value="${val1}">
                    ${label2}
                </label>
                <label for="${val2}">
                    <input type="radio" name="${name}" id="${val2}" value="${val2}">
                    ${label3}
                </label>
            </div>
            <small class="text-danger"></small>
        </div>
    `;
}

function generateNumChambre(id, val){
    let num = '';
    if(val <= 9){
        num = `00${val}`;
    }else if(val > 9 && val <= 99){
        num = `0${val}`;
    }else if(val > 99){
        num = `${val}`;
    }
    if(id <= 9){
        num += `-000${id}`;
    }else if(id > 9 && id <= 99){
        num += `-00${id}`;
    }else if(id > 99 && id <= 999){
        num += `-0${id}`;
    }else if(id > 999){
        num += `-${id}`;
    }
    return num;
}