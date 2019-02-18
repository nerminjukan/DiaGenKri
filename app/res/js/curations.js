

let dictionary = {};
dictionary["en"] = ['Curating algorithm: ', "Curation result", "Approve algorithm", "Reject algorithm", "Explanation", "Curated by: ", "Confirm", "Cancel", 'Already curated', 'Closed - OK', 'Closed - NOK'];
dictionary["sl"] = ['Odobritev algoritma: ', "Status odobritve", "Odobri algoritem", "Zavrni algoritem", "Obrazložitev", "Odobril/a: ", "Potrdi", "Prekliči", 'Že potrjen', 'Zaprt - potrjen', 'Zaprt - zavrnjen'];
lng = document.getElementById('myLanId').innerText.trim();
window.onload = function () {
    try {
        lng = document.getElementById('myLanId').innerText.trim();
    } catch (e) {

    }
}

$(document).ready(function(){
// updating the view with notifications using ajax
    function load_unseen_notification()
    {
        $.ajax({
            url:"../../public/visualisation/curationsUpdate",
            method:"POST",
            dataType:"json",
            success:function(data)
            {
                if(Number(data[0]) > 0)
                {
                    $('.count').html(data[0]);
                }
            }
        });
    }

    load_unseen_notification();

    setInterval(function(){
        try{
            load_unseen_notification();
        } catch (e) {

        }
    }, 10000);
});

function fillModal(e, me) {

    let found = document.getElementById('modal-' + me.id);

    if(found !== null){
        $("#modal-"+me.id).modal('show');
    }
    else{
        //console.log(found, 'ID: ', 'modal-' + me.id);

        let tr = getRowData(me.id);

        let div = document.getElementById('makeModal');

        let divModal = document.createElement("div");
        divModal.id = 'modal-' + me.id;

        //console.log('ID: ','modal-' + me.id );
        divModal.classList.add('modal');
        divModal.classList.add('fade');
        divModal.setAttribute('data-role', 'dialog');

        let modalDialogDiv = document.createElement("div");
        modalDialogDiv.classList.add('modal-dialog');

        let modalContentDiv = document.createElement("div");
        modalContentDiv.classList.add('modal-content');

        let modalHeaderDiv = document.createElement("div");
        modalHeaderDiv.classList.add('modal-header');

        let modalBodyDiv = document.createElement("div");
        modalBodyDiv.classList.add('modal-body');

        let algorithmName = document.createElement("h4");
        algorithmName.innerHTML = dictionary[lng][0] + '\'' + tr.getElementsByTagName("td")[1].innerHTML + '\'';

        modalHeaderDiv.appendChild(algorithmName);

        let form = document.createElement("form");

        form.classList.add('form-horizontal');
        form.name = 'cForm-'+me.id;
        form.setAttribute('role', 'form');

        let divRadio = document.createElement("div");
        divRadio.classList.add('form-group');
        let labelRadio = document.createElement("label");
        labelRadio.classList.add("col-sm-2");
        labelRadio.classList.add("control-label");
        labelRadio.setAttribute('for', 'status'+me.id);
        labelRadio.innerHTML = dictionary[lng][1];
        let labelStar = document.createElement("label");
        labelStar.style.color = 'red';
        labelStar.innerHTML = '*';
        labelRadio.appendChild(labelStar);

        let divRadioB = document.createElement("div");
        divRadioB.classList.add("col-sm-10");
        divRadio.classList.add("well");

        let rButtonOK = document.createElement("div");
        let labelBOK = document.createElement("label");
        labelBOK.classList.add("radio-inline");
        labelBOK.setAttribute('for', 'OK'+me.id);
        let inputBOK = document.createElement("input");
        inputBOK.classList.add("radio");
        inputBOK.id = 'OK'+me.id;
        inputBOK.setAttribute('type', 'radio');
        inputBOK.name = 'status';
        inputBOK.value = 'ok';

        rButtonOK.appendChild(labelBOK);
        labelBOK.appendChild(inputBOK);
        labelBOK.innerHTML = labelBOK.innerHTML + dictionary[lng][2];

        let rButtonNOK = document.createElement("div");
        let labelBNOK = document.createElement("label");
        labelBNOK.classList.add("radio-inline");
        labelBNOK.setAttribute('for', 'NOK'+me.id);
        let inputBNOK = document.createElement("input");
        inputBNOK.classList.add("radio");
        inputBNOK.id = 'NOK'+me.id;
        inputBNOK.setAttribute('type', 'radio');
        inputBNOK.name = 'status';
        inputBNOK.value = 'nok';

        rButtonNOK.appendChild(labelBNOK);
        labelBNOK.appendChild(inputBNOK);
        labelBNOK.innerHTML = labelBNOK.innerHTML + dictionary[lng][3];

        divRadioB.appendChild(rButtonOK);
        divRadioB.appendChild(rButtonNOK);

        divRadio.appendChild(labelRadio);
        divRadio.appendChild(divRadioB);

        let divExplanation = document.createElement("div");
        divExplanation.classList.add('form-group');
        divExplanation.classList.add("well");
        let labelExplanation = document.createElement("label");
        labelExplanation.classList.add("col-sm-2");
        labelExplanation.classList.add("control-label");
        labelExplanation.setAttribute('for', 'status'+me.id);
        labelExplanation.innerHTML = dictionary[lng][4];
        let labelStarEx = document.createElement("label");
        labelStarEx.style.color = 'red';
        labelStarEx.innerHTML = '*';
        labelExplanation.appendChild(labelStarEx);

        let divExpl = document.createElement("div");
        divExpl.classList.add("col-sm-10");
        let preForm = document.createElement("pre");
        let textField = document.createElement("textArea");
        textField.classList.add('form-control');
        textField.id = 'text-area-'+me.id;
        textField.setAttribute('placeholder', dictionary[lng][4]);
        textField.setAttribute('rows', '6');

        preForm.appendChild(textField);
        divExpl.appendChild(preForm);
        divExplanation.appendChild(labelExplanation);
        divExplanation.appendChild(divExpl);


        form.appendChild(divRadio);
        form.appendChild(divExplanation);
        modalBodyDiv.appendChild(form);

        let btnSend = document.createElement("BUTTON");
        let btnCancel = document.createElement("BUTTON");

        btnSend.id = 'btn-send-'+me.id;
        btnCancel.id = 'btn-cancel-'+me.id;

        btnSend.setAttribute('type', 'button');
        btnCancel.setAttribute('type', 'button');

        btnSend.classList.add('btn');
        btnSend.classList.add('btn-success');
        btnSend.innerHTML = dictionary[lng][6];

        btnCancel.classList.add('btn');
        btnCancel.classList.add('btn-warning');
        btnCancel.innerHTML = dictionary[lng][7];

        let curator = document.createElement("p");
        curator.style.textAlign = 'left';
        let email = document.getElementById("user-mail-id");
        let name = document.getElementById("user-full-name");

        curator.innerHTML = dictionary[lng][5] + name.innerHTML + ', e-mail: '  + email.innerHTML;

        btnSend.addEventListener('click', function () {
            saveCuration(me.id, name.innerHTML, email.innerHTML);
        });

        btnCancel.addEventListener('click', function () {
            clearCuration(me.id);
        });

        //modalBodyDiv.appendChild(algorithmName);
        //modalBodyDiv.appendChild(textField);

        let modalFooterDiv = document.createElement("div");
        modalFooterDiv.classList.add('modal-footer');

        modalFooterDiv.appendChild(curator);
        modalFooterDiv.appendChild(btnSend);
        modalFooterDiv.appendChild(btnCancel);


        modalContentDiv.appendChild(modalHeaderDiv);
        modalContentDiv.appendChild(modalBodyDiv);
        modalContentDiv.appendChild(modalFooterDiv);
        modalDialogDiv.appendChild(modalContentDiv);
        divModal.appendChild(modalDialogDiv);
        div.appendChild(divModal);
        console.log(div);
        $("#modal-"+me.id).modal('show');
    }

}

function getRowData(id){
    let table = document.getElementById("curationTable");
    let tr = table.getElementsByTagName("tr");
    let td0;
    for (let i = 1; i < tr.length; i++) {
        td0 = tr[i].getElementsByTagName("td")[0];
        console.log('id: ', id, '| data: ', td0.innerHTML);
        if(td0.innerHTML == id){
            return tr[i];
        }
    }
}

function saveCuration(id, curatorFullName, curatorMail){

    let dataGet = getCurationData(id);

    let validate = validateCuration(id);

    if(!validate){
        $.notify("Curation is incomplete!",
            { position: 'bottom center',
                className: 'error',
                gap: 5 }
        );

        return;
    }

    $.ajax({
        type: "POST",
        url: "../../public/visualisation/curate",
        data: {
            id: id,
            result: dataGet['result'],
            explanation: dataGet['explanation'],
            author: dataGet['author'],
            curatorMail: curatorMail,
            curatorFullName: curatorFullName,
            algName: dataGet["algName"]
        },
        success: function(data, status){
            // console.log('[saveGraph] save', status === "success" ? "saved successfuly" : "not saved successfuly", "\ndata:", data);
            if(data == 1){
                console.log("curation:", dataGet["result"]);
                updateStatus(id, dataGet['result'], curatorMail);
                clearCuration(id);
                $.notify("Curation successfuly saved.",
                    { position: 'bottom center',
                        className: 'success',
                        gap: 5 }
                );
            } else {
                console.log("ERROR:", data, status);
                console.log(dataGet["result"]);
                $.notify("Something went wrong, the curation was not saved.",
                    { position: 'bottom center',
                        className: 'error',
                        gap: 5 }
                );
                return false;
            }
        }
    });
}

function clearCuration(id) {
    let modal = document.getElementById('modal-'+id);
    $('#modal-'+id).modal('hide');
    modal.parentNode.removeChild(modal);
}

function getCurationData(id) {
    let data = [];

    let result, explanation, author;

    ok = document.getElementById('OK'+id);

    if(document.forms["cForm-"+id]["status"][0].checked === true){
        result = 1;
    }
    else{
        result = 2;
    }

    explanation = document.getElementById('text-area-'+id).value;

    let tr = getRowData(id);

    author = tr.getElementsByTagName("td")[2].innerHTML;
    // author = "name surname email", only email is needed
    author1 = author.substring(author.lastIndexOf(" ") + 1);
    author = author1.trim(); // remove any whitespaces left

    data["result"] = result;
    data["explanation"] = explanation;
    data["author"] = author;
    data["algName"] = tr.getElementsByTagName("td")[1].innerHTML;

    return data;
}

function updateStatus(id, status, curatorMail) {
    let tr = getRowData(id);
    let td4 = tr.getElementsByTagName("td")[4];
    let td5 = tr.getElementsByTagName("td")[5];
    let td7 = tr.getElementsByTagName("td")[7];
    if(status === 1){
        td4.innerHTML = dictionary[lng][9];
        td4.style.backgroundColor = '#66ff66';
    }
    else{
        td4.innerHTML = dictionary[lng][10];
        td4.style.backgroundColor = '#ff6666';
    }

    td5.innerHTML = curatorMail;

    let btn = document.getElementsByName('curate-'+id);

    btn[0].disabled = true;
    btn[0].title = dictionary[lng][8];
}

function validateCuration(id) {
    if(! document.forms["cForm-"+id]["status"][0].checked === true){
        if(! document.forms["cForm-"+id]["status"][1].checked === true){
            return false;
        }
    }
    let explanation = document.getElementById('text-area-'+id).value;
    if(explanation.length === 0){
        return false;
    }
    return true;
}

