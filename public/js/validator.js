function checkRequired(inputArray){
    let error = 0;
    for(let input of inputArray) {
        if(input.val() === null || input.val().trim() === ''){
            showError(input, `${getFieldName(input)} is required`);
            error++;
        }else{
            hideError(input);
        }
    };
    if(error > 0){
        return false;
    }
    return true;
}

function checkOption(optionArray){
    let error = 0;
    for(let opt of optionArray){
        const check = opt[0].querySelectorAll('input[type="radio"]:checked');
        if(check.length < 1){
            showError(opt, "Please choose one");
            error++;
        }else{
            hideError(opt);
        }
    }
    if(error > 0){
        return false;
    }
    return true;
}

function getFieldName(input) {
    //Retour le nom de chaque input en se basant sur son id
    return input.attr('id').charAt(0).toUpperCase() + input.attr('id').slice(1);
}

function showError(field, message){
    field.addClass('is-invalid');
    field.parent().append(`<small class="text-danger">${message}</small>`);
}

function hideError(field){
    const small = field.parent().children('small');
    field.removeClass('is-invalid');
    if(small){
        small.remove();
    }
}

function validWithRegex(val, regex){
    return regex.test(val); 
}