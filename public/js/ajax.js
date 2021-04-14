
function ajaxUpdate(data, id, model) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "POST",
            url : `${g.SROOT}${model}/edit/${id}`,
            data : data,
            success : function(resp){
                data = JSON.parse(resp);
                if ('result' in data) {
                    resolve(data);
                } else {
                    reject(data);
                }
            },
            error: function() {
                console.log('error updating: ajaxUpdate');
            }
        });
    });
}


function ajaxAdd(data, model){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "POST",
            url : `${g.SROOT}${model}/add`,
            data : data,
            success : function(resp){
                data = JSON.parse(resp);
                if ('result' in data) {
                    resolve(data);
                } else {
                    reject(data);
                }
            },
            error: function() {
                console.log('error adding: ajaxAdding');
            }
        });
    });
}


function ajaxCreate(data, model){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "POST",
            url : `${g.SROOT}${model}/submit`,
            data : data,
            success : function(resp){

                console.log(resp);
                data = JSON.parse(resp);
                if ('result' in data) {
                    resolve(data);
                } else {
                    reject(data);
                }
            },
            error: function() {
                console.log('error adding: ajaxAdding');
            }
        });
    });
}

function ajaxDelete(data, model){
    $.ajax({
        type: "POST",
        url : `${g.SROOT}${model}/delete/${data.id}`,
        data : data,
        success : function(resp){
            if (resp) {
                console.log(resp);
            } else {
                console.log('error');
            }
        },
        error: function() {
            console.log('error deleting: ajaxDelete');
        }
    });
}