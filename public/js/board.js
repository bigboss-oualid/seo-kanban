
var DOM = {
    board: '.board',
    inputErrorMsg: '.input-error-msg',
    listWrapper: '.list-wrapper',
    btnCardAddAnother: '.btn-card-add-another',
    btnAddCard: '.btn-card-add',
    inputListTitle: '.list-title',
    cardAdd: '.card-add',
    editCard: '.edit-card',
    modal: '.modal',
    modDescriptionTextarea: '.mod-description-textarea',
    modDescriptionControls: '.mod-description-controls',
    btnModDescriptionSave: '.btn-mod-description-save',
    btnModDescriptionClear: '.btn-mod-description-clear',
    closeModDescriptionControls: '.close-mod-description-controls',
    checklist: '.mod-checklist',
    btnModChecklistItemAdd: '.btn-mod-checklist-item-add',
    btnModChecklistItemAddAn: '.btn-mod-checklist-item-add-an',
    modChecklistItemDetails: '.mod-checklist-item-details',
    modChecklistItemAdd: '.mod-checklist-item-add',
    modChecklistItemAddAn: '.mod-checklist-item-add-an',
    modChecklistItemEdit: '.mod-checklist-item-edit',
    modChecklistItemDelete: '.mod-checklist-item-delete',
    modChecklistItemUpdate: '.mod-checklist-item-update',
    modChecklistItemUpdateTextarea: '.mod-checklist-item-update-textarea',
    btnModChecklistItemUpdate: '.btn-mod-checklist-item-update',
    ErrMsgModChecklistItemUpdate: '.err-msg-mod-checklist-item-update',
    listAddAnotherBtn: '.list-add-another-btn',
    listAdd: '.list-add',
    listAddInput: '.list-add-input',
    listAddBtn: '.list-add-btn',
    listAddClose: '.list-add-close',
    listAddAnother: '.list-add-another',
};



//===============================================//
//--- For loading content into a modal
// Pass modal ID as theModal and suffix "Body" for
// body content
//----------------------------------------------//
function loadModal(loadURL,theModal) {
    $(".modal-content").load(loadURL,function(){
            //$("#"+theModal+"Label").text(theLabel)
            $("#modal").modal({show:true});
    });
}



var board = document.querySelector(DOM.board);
board.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-card-add')) {
        addCard(e);
    } else if (e.target.classList.contains('close-card-add')) {
        var id = getIdFromElement(e.target.id);
        removeCardAdd(id);
    } else if (e.target.classList.contains('delete-card')) {
        deleteCard(e);
    } else if (e.target.classList.contains('list-add-btn')) {
        //listAdd();
    } else if (e.target.classList.contains('btn-card-add-another')) {
        btnAddCardAnotherClick(e);
    } else if (e.target.classList.contains('list-edit')) {
        editList(e);
    } else if (e.target.classList.contains('list-delete')) {
        deleteList(e);
    } else if (e.target.classList.contains('edit-card')) {
        editCardClick(e);
    }
});



board.addEventListener('focusin', function(e) {
    if (e.target.classList.contains('list-title')) {
        listTitleFocus(e);
    } else if (e.target.classList.contains('mod-card-title')) {
        modCardTitleFocus(e);
    } else if (e.target.classList.contains('mod-description-textarea')) {
        modDescriptionFocus(e);
    }
});


board.addEventListener('focusout', function(e) {
    if (e.target.classList.contains('list-title')) {
        listTitleBlur(e);
    } else if (e.target.classList.contains('mod-card-title')) {
        modCardTitleBlur(e);
    } else if (e.target.classList.contains('mod-description-textarea')) {
        modDescriptionBlur(e);
    }
});



/*******************************************
UPDATE LIST TITLE
*******************************************/

var gListTitleVal = '';

function listTitleFocus(e) {
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);

    var listTitle = document.getElementById(`list-title--${listID}`);
    gListTitleVal = listTitle.value;
}

function listTitleBlur(e) {
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);
    var listTitle = document.getElementById(`list-title--${listID}`);

    var inputErrorMsg = document.querySelector(`.title-error-msg--${listID}`);
    removeErrMsg(inputErrorMsg, listTitle);

    if (listTitle.value !== gListTitleVal) {
        ajaxUpdate({title:listTitle.value}, listID, g.columnsModel)
            .then(function(data) {
            })
            .catch(function(error) {
                displayErrMsg(error.errors, inputErrorMsg, listTitle);
                console.log(error.errors)
                console.log('error adding board');
            })
        ;
    }
    gListTitleVal = '';
}


/*******************************************
UPDATE CARD TITLE - MODAL
*******************************************/

var gModCardTitleVal = '';

function modCardTitleFocus(e) {
	var modCardTitle = document.querySelector('.mod-card-title');
	gModCardTitleVal = modCardTitle.value;
	console.log(gModCardTitleVal);
}

function modCardTitleBlur(e) {
    var cardID = document.querySelector('.mod-card-id').value;
    //console.log(`cardID: ${cardID}`);
    var modCardTitle = document.querySelector('.mod-card-title');

    var inputErrorMsg = document.getElementsByClassName('modal-input-error-msg ');
    var inputList = document.getElementsByClassName('mod-card-title');
    var cardTitleInput = document.getElementById('_card-details--' + cardID);
    var cardTitleErrorMsg = document.getElementById('card-title-error--' + cardID);

    if (modCardTitle.value !== gModCardTitleVal) {
        ajaxUpdate({title:modCardTitle.value}, cardID, g.cardsTitleModel)
            .then(function(data) {
                removeErrMsg(cardTitleErrorMsg, cardTitleInput)
                removeErrMsg(inputErrorMsg[0], inputList[0])
            })
            .catch(function(error) {
                displayErrMsg(error.errors, inputErrorMsg[0], inputList[0]);
                displayErrMsg(error.errors, cardTitleErrorMsg, cardTitleInput);
                console.log(error.errors)
                console.log('error adding board');
            })
        ;
        var cardText = document.querySelector(`#_card-text--${cardID}`);
        cardText.textContent = modCardTitle.value;
    }
    gModCardTitleVal = '';
    console.log(gModCardTitleVal);
}


/*******************************************
UPDATE CARD DESCRIPTION - MODAL
*******************************************/

var gModDescriptionVal = '';

function modDescriptionFocus(e) {
	var modDescription = document.querySelector('.mod-description-textarea');
	gModDescriptionVal = modDescription.value;
	console.log(gModDescriptionVal);
}

function modDescriptionBlur(e) {
    var cardID = document.querySelector('.mod-card-id').value;
    //console.log(`cardID: ${cardID}`);
    var modDescription = document.querySelector('.mod-description-textarea');
    if (modDescription.value !== gModDescriptionVal) {
        ajaxUpdate({description:modDescription.value}, cardID, g.cardsDescriptionModel).then(function(data) {
        })
            .catch(function(error) {
                console.log(error.errors)
                console.log('error adding board');
            })
        ;
    }
    gModDescriptionVal = '';
    console.log(gModDescriptionVal);
}


/*******************************************
EDIT CARD - MODAL
*******************************************/


function editCardClick(e) {
    // get board id
    var boardElementID = document.querySelector('.board').id;
    var boardID = getIdFromElement(boardElementID);
    //---------- get card id
    var elementID = e.target.id;
    var cardID = getIdFromElement(elementID);
    //----------

    loadModal(`${g.SROOT}card/${cardID}`, 'modal');
}



/*******************************************
LIST DELETE
*******************************************/


function deleteList(e) {
    //---------- get id
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);
    //----------
    var conf = confirm("Are you sure?");
    if (conf === true) {
        ajaxDelete({id:listID}, g.columnsModel);
        var list = document.querySelector(`#list--${listID}`);
        list.parentNode.removeChild(list);
    }
}



/*******************************************
LIST EDIT
*******************************************/

function editList(e) {
    //---------- get id
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);
    //----------
    var listTitleInput = document.querySelector(`#list-title--${listID}`);
    listTitleInput.focus();
}


/*******************************************
COLUMN ADD
*******************************************/

var listAddAnother = document.querySelector(DOM.listAddAnother);
var listAddAnotherBtn = document.querySelector(DOM.listAddAnotherBtn);
var listAdd = document.querySelector(DOM.listAdd);
var listAddInput = document.querySelector(DOM.listAddInput);
var listAddBtn = document.querySelector(DOM.listAddBtn);
var listAddClose = document.querySelector(DOM.listAddClose);


listAddAnotherBtn.addEventListener('click', function() {
    listAddAnotherBtn.classList.add('hide'); //this
    listAdd.classList.remove('hide');
});

listAddBtn.addEventListener('click', function() {
    var lists = document.querySelector('.lists');
    var title = listAddInput.value;
    var listID;

    var inputErrorMsg = document.querySelector(DOM.inputErrorMsg);
    var inputList = document.querySelector(DOM.listAddAnotherBtn);
    removeErrMsg(inputErrorMsg, inputList);

    ajaxAdd({title:title, board_id:g.boardID}, g.columnsModel)
        .then(function(data) {
            listID = data.lastInsertID;

            var html = `
                <div class="list mx-1 align-self-start" id="list--${listID}">
    
                    <div class="list-header d-flex m-2" id="list-header--${listID}">
                        <input type="text" class="list-title" id="list-title--${listID}" value="${title}">
                        <div class="dropdown p-1">
                            <span class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </span>
                            <div class="dropdown-menu">
                                <a class="dropdown-item list-edit" id="list-edit--${listID}">Edit</a>
                                <a class="dropdown-item list-delete" id="list-delete--${listID}">Delete</a>
                            </div>
                        </div>
                    </div>
    
                    <div class="list-cards" id="list-cards--${listID}"></div>
    
                    <div class="card-add-another" id="card-add-another--${listID}">
                        <button class="btn-card-add-another btn btn-primary btn-sm" id="btn-card-add-another--${listID}">Add New Card</button>
                    </div>
    
                </div>
            `;

            lists.insertAdjacentHTML('beforeend', html);

            listAddInput.value = "";
            listAddAnotherBtn.classList.remove('hide');
            listAdd.classList.add('hide');

        })
        .catch(function(error) {
            displayErrMsg(error.errors, inputErrorMsg, inputList);
            console.log(error.errors)
            console.log('error adding board');
        });
});


listAddClose.addEventListener('click', function() {
    listAddInput.value = "";
    listAddAnotherBtn.classList.remove('hide');
    listAdd.classList.add('hide');
});	


/*******************************************
CARD ADD
*******************************************/

function btnAddCardAnotherClick(e) {
    //---------- get id
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);
    //----------

    var list = document.querySelector(`#list--${listID}`);
    var cardAddAnother = document.querySelector(`#card-add-another--${listID}`);
    cardAddAnother.classList.add('hide');

    var html = `
        <div class="card-add d-flex flex-column m-2" id="card-add--${listID}">
            <div class="card-add-content" id="card-add-content--${listID}">
                <textarea class="card-add-textarea" id="card-add-textarea--${listID}"></textarea>
            </div>
            <div class="card-add-controls" id="card-add-controls--${listID}">
                <button class="btn-card-add btn btn-primary btn-sm" id="btn-card-add--${listID}">Add New Card</button>
                <span class=""><i class="close-card-add fa fa-times-circle" id="close-card-add--${listID}"></i></span>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
    //list.getElementsByTagName('button')[0].insertAdjacentHTML('beforebegin', html);
}


function removeCardAdd(listID) {
    var cardAdd = document.querySelector(`#card-add--${listID}`);
    var cardAddAnother = document.querySelector(`#card-add-another--${listID}`);
    if (cardAdd) {
        cardAdd.parentNode.removeChild(cardAdd);
        cardAddAnother.classList.remove('hide');
    }
}


function addCard(e) {
    //---------- get id
    var elementID = e.target.id;
    var listID = getIdFromElement(elementID);
    //----------
    var listCards = document.querySelector(`#list-cards--${listID}`);
    var cardAddAnother = document.querySelector(`#card-add-another--${listID}`);

    var cardAddTextarea = document.querySelector(`#card-add-textarea--${listID}`);
    var cardText = cardAddTextarea.value;

    removeCardAdd(listID);
    cardAddAnother.classList.remove('hide');
    ajaxAdd({title:cardText, list_id:listID, board_id:g.boardID}, g.cardsModel)
        .then(function(data) {
            var cardID = data.lastInsertID;
            console.log(cardID)
            var html = `
                <div class="d-flex m-2 _card" id="_card--${cardID}">
                    <div class="_card-details flex-grow-1 p-1" id="_card-details--${cardID}">
                        <span class="_card-text" id="_card-text--${cardID}">${cardText}</span>
                    </div>
                    <div class="dropdown p-1">
                        <span class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-edit"></i>
                        </span>
                        <div class="dropdown-menu">
                            <a class="dropdown-item edit-card" data-toggle="modal" data-target="#modal" id="edit-card--${cardID}">Edit</a>
                            <a class="dropdown-item delete-card" id="delete-card--${cardID}">Delete</a>
                        </div>
                    </div>
                </div>
            `;

            listCards.insertAdjacentHTML('beforeend', html);
        })
        .catch(function() {
            alert('error adding card');
            console.log('error adding card');
        })
    ;
}

/*******************************************
CARD DELETE
*******************************************/

function deleteCard(e) {
    //---------- get id
    var elementID = e.target.id;
    var cardID = getIdFromElement(elementID);
    //----------
    var conf = confirm("Are you sure?");
    if (conf === true) {
        ajaxDelete({id:cardID}, g.cardsModel);
        var card = document.querySelector(`#_card--${cardID}`);
        card.parentNode.removeChild(card);
    }
}


/*******************************************
MODAL CHECKLIST
*******************************************/
var modalContent = document.querySelector('.modal-content');

var btnModChecklistItemAddAn = document.querySelector(DOM.btnModChecklistItemAddAn);
var btnModChecklistItemAdd = document.querySelector(DOM.btnModChecklistItemAdd);
var modChecklistItemDetails = document.querySelector(DOM.modChecklistItemDetails);
var modChecklistItemAdd = document.querySelector(DOM.modChecklistItemAdd);
var modChecklistItemUpdate = document.querySelector(DOM.modChecklistItemUpdate);

modalContent.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-mod-checklist-item-add-an')) {
        btnModChecklistItemAddAnClick(e);
    } else if (e.target.classList.contains('btn-mod-checklist-item-add')) {
        ////
        addModChecklistItem();
    } else if (e.target.classList.contains('close-mod-checklist-item-add-i') || e.target.classList.contains('close-mod-checklist-item-add')) {
        var modChecklistItemAdd = document.querySelector(DOM.modChecklistItemAdd);
        if (modChecklistItemAdd) {
            removeModChecklistItemAdd();
            var modChecklistItemAddAn = document.querySelector(DOM.modChecklistItemAddAn);
            modChecklistItemAddAn.classList.remove('hide');
        }
    } else if (e.target.classList.contains('mod-checklist-item-edit')) {
        modChecklistItemEditClick(e);
    } else if (e.target.classList.contains('mod-checklist-item-delete')) {
        modChecklistItemDeleteClick(e);
    } else if (e.target.classList.contains('close-mod-checklist-item-update')) {
        closeModChecklistItemUpdateClick(e);
    } else if (e.target.classList.contains('btn-mod-checklist-item-update')) {
        btnModChecklistItemUpdateClick(e);
    } else if (e.target.classList.contains('mod-checklist-item-is-completed')) {
        modChecklistItemIsCompletedClick(e);
    }
});

function addModChecklistItem() {
    var modChecklistItemAddTextarea = document.querySelector('.mod-checklist-item-add-textarea');

    removeModChecklistItemAdd();

    var modChecklistItemAddAn = document.querySelector(DOM.modChecklistItemAddAn);
    modChecklistItemAddAn.classList.remove('hide');

    var cardID = document.querySelector('.mod-card-id').value;
    var text = modChecklistItemAddTextarea.value;
    var isCompleted = 0;

    ajaxAdd({text:text, card_id:cardID, board_id:g.boardID, is_completed:isCompleted}, g.cardChecklistItemsModel)
        .then(function(data) {
            var checkID = data.lastInsertID;

            var html = `
                <div class="mod-checklist-item d-flex" id="mod-checklist-item--${checkID}">
                    <div class="form-check mod-checklist-item-check" id="mod-checklist-item-check--${checkID}">
                        <input type="checkbox" class="form-check-input mod-checklist-item-is-completed" id="mod-checklist-item-is-completed--${checkID}" value="${isCompleted}">
                        <label class="form-check-label" for="mod-checklist-item-is-completed--${checkID}"></label>
                    </div>
                    <div class="mod-checklist-item-details" id="mod-checklist-item-details--${checkID}">
                        <span class="mod-checklist-item-text" id="mod-checklist-item-text--${checkID}">${text}</span>
                    </div>
                    <div class="mod-checklist-item-controls ml-auto d-flex" id="mod-checklist-item-controls--${checkID}">
                        <div class="m-1"><span>
                            <i class="fa fa-edit mod-checklist-item-control mod-checklist-item-edit" id="mod-checklist-item-edit--${checkID}"></i>
                        </span></div>
                        <div class="m-1"><span>
                            <i class="fa fa-times red-text mod-checklist-item-control mod-checklist-item-delete" id="mod-checklist-item-delete--${checkID}"></i>
                        </span></div>
                    </div>
                </div>
            `;

            var modChecklistItems = document.querySelector('.mod-checklist-items');
            modChecklistItems.insertAdjacentHTML('beforeend', html);
        })
        .catch(function() {
            alert('error adding checklist item');
            console.log('error adding checklist item');
        })
    ;
}




function modChecklistItemIsCompletedClick(e) {
    //---------- get id
    var elementID = e.target.id;
    var id = getIdFromElement(elementID);
    //----------

    var modChecklistItemIsCompleted = document.querySelector(`#mod-checklist-item-is-completed--${id}`);
    if (modChecklistItemIsCompleted.matches(':checked')) {
        console.log('checked');
        modChecklistItemIsCompleted.value = 1;
    } else {
        console.log('unchecked');
        modChecklistItemIsCompleted.value = 0;
    }

    ajaxUpdate({is_completed:modChecklistItemIsCompleted.value}, id, g.cardChecklistItemsModel);
}


function modChecklistItemDeleteClick(e) {
    //---------- get id
    var elementID = e.target.id;
    var chkID = getIdFromElement(elementID);
    //----------
    var conf = confirm("Are you sure?");
    if (conf === true) {
        ajaxDelete({id:chkID}, g.cardChecklistItemsModel);
        var modChecklistItem = document.querySelector(`#mod-checklist-item--${chkID}`);
        modChecklistItem.parentNode.removeChild(modChecklistItem);
        removeModChecklistItemUpdate(chkID);
    }
}


function modChecklistItemEditClick(e) {

    //---------- get id
    var elementID = e.target.id;
    var chkID = getIdFromElement(elementID);
    //----------

    var modChecklistItemUpdate = document.querySelector(`#mod-checklist-item-update--${chkID}`);
    if (modChecklistItemUpdate) {
        removeModChecklistItemUpdate(chkID);
    }

    var modChecklistItem = document.querySelector(`#mod-checklist-item--${chkID}`);
    var modChecklistItemText = document.querySelector(`#mod-checklist-item-text--${chkID}`);

    var html = `
        <div class="mod-checklist-item-update" id="mod-checklist-item-update--${chkID}">
            <div class="width-100">
                <textarea class="mod-checklist-item-update-textarea form-control width-100" id="mod-checklist-item-update-textarea--${chkID}" placeholder="">${modChecklistItemText.textContent}</textarea>
                <div class="err err-mod-checklist-item-update" id="err-mod-checklist-item-update--${chkID}">
                    <span class="err-msg-text err-msg-mod-checklist-item-update" id="err-msg-mod-checklist-item-update--${chkID}"></span>
                </div>
            </div>
            <div>
                <button class="btn-mod-checklist-item-update btn btn-sm btn-default" id="btn-mod-checklist-item-update--${chkID}" data-checklistitemid="${chkID}">Update</button>
                <span><i class="close-mod-checklist-item-update fa fa-times-circle" id="close-mod-checklist-item-update--${chkID}"></i></span>
            </div>
        </div>
    `;
    modChecklistItem.insertAdjacentHTML('afterend', html);
}




function btnModChecklistItemUpdateClick(e) {
    //---------- get id
    var elementID = e.target.id;
    var chkID = getIdFromElement(elementID);
    //----------


    var btnModChecklistItemUpdate = document.querySelector(`#btn-mod-checklist-item-update--${chkID}`);
    var modChecklistItemUpdateTextarea = document.querySelector(`#mod-checklist-item-update-textarea--${chkID}`);
    var modChecklistItemText = document.querySelector(`#mod-checklist-item-text--${chkID}`);
    var ErrMsgModChecklistItemUpdate = document.querySelector(`#err-msg-mod-checklist-item-update--${chkID}`);

    if (isEmpty(modChecklistItemUpdateTextarea)) {
        var msg = "No input";
        displayErrMsg(msg, ErrMsgModChecklistItemUpdate, modChecklistItemUpdateTextarea);
        return;
    }

    removeErrMsg(ErrMsgModChecklistItemUpdate, modChecklistItemUpdateTextarea);

    ajaxUpdate({text:modChecklistItemUpdateTextarea.value}, chkID, g.cardChecklistItemsModel);
    modChecklistItemText.textContent = modChecklistItemUpdateTextarea.value;

    var modChecklistItemUpdate = document.querySelector(`#mod-checklist-item-update--${chkID}`);
    if (modChecklistItemUpdate) {
        removeModChecklistItemUpdate(chkID);
    }

}


function closeModChecklistItemUpdateClick(e) {
    //---------- get id
    var elementID = e.target.id;
    var chkID = getIdFromElement(elementID);
    //----------
    var modChecklistItemUpdate = document.querySelector(`#mod-checklist-item-update--${chkID}`);
    if (modChecklistItemUpdate) {
        removeModChecklistItemUpdate(chkID);
    }
}



function btnModChecklistItemAddAnClick(e) {
    var modChecklistItemAddAn = document.querySelector(DOM.modChecklistItemAddAn);
    modChecklistItemAddAn.classList.add('hide');

    var html = `
        <div class="mod-checklist-item-add">
            <div class="width-100">
                <textarea class="mod-checklist-item-add-textarea form-control width-100" placeholder="Checklist Item"></textarea>
            </div>
            <div>
                <button class="btn-mod-checklist-item-add btn btn-sm btn-primary">Add</button>
                <span class="close-mod-checklist-item-add"><i class="close-mod-checklist-item-add-i fa fa-times-circle"></i></span>
            </div>
        </div>
    `;

    var checklist = document.querySelector(DOM.checklist);
    checklist.insertAdjacentHTML('beforeend', html);
    //list.getElementsByTagName('button')[0].insertAdjacentHTML('beforebegin', html);
}




function removeModChecklistItemAdd() {
    var modChecklistItemAdd = document.querySelector(DOM.modChecklistItemAdd);
    modChecklistItemAdd.parentNode.removeChild(modChecklistItemAdd);
    }

    function removeModChecklistItemUpdate(id) {
    var modChecklistItemUpdate = document.querySelector(`#mod-checklist-item-update--${id}`);
    if (modChecklistItemUpdate) modChecklistItemUpdate.parentNode.removeChild(modChecklistItemUpdate);
}


/*******************************************
GENERIC FUNCTIONS
*******************************************/

function displayErrMsg(msg, errorTextField, inputField) {
    inputField.classList.add('error-field');
    errorTextField.textContent = msg;
    errorTextField.classList.remove('hide');
}

function removeErrMsg(errorTextField, inputField) {
    inputField.classList.remove('error-field');
    errorTextField.textContent = "";
}

function isEmpty(field) {
    if (field.value == "") return true;
    return false;
}

function getIdFromElement(elementID) {
    var splitID = elementID.split('--');
    var type = splitID[0];
    var id = parseInt(splitID[1]);
    return id;
}








