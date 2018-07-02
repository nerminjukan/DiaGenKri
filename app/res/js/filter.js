/**
 * Created by Nermin on 29. 06. 2018.
 */

function filterTable() {

    let radioInput, radioFilter, textInput, textFilter, cb1, cb2, cb3, table, tr, td2, td3, td4, i;

    let cbs = checkboxValue();

    radioInput = radioValue();

    radioFilter = radioInput.toUpperCase();

    textInput = document.getElementById("gName");
    textFilter = textInput.value.toUpperCase();

    table = document.getElementById("graphTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td3 = tr[i].getElementsByTagName("td")[3];
        td2 = tr[i].getElementsByTagName("td")[2];
        td4 = tr[i].getElementsByTagName("td")[4];
        if (td2 && td3 && td4) {
            console.log("Got all table cells");
            if(radioInput === 'all'){
                console.log("radio = all");
                if(textFilter !== ''){
                    console.log("Tekst != null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes('DIAGNOSTIC') || td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes('OTHER') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if((!cbs.cb1 && !cbs.cb2 && !cbs.cb3)){
                        console.log("no CB checked");
                        tr[i].style.display = "none";
                    }
                    else if(cbs.cb1){
                        console.log("CB1");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes('TREATMENT')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
                else{
                    console.log("tekst = null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td4.innerHTML.toUpperCase().includes('DIAGNOSTIC') || td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes('OTHER') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(!cbs.cb1 && !cbs.cb2 && !cbs.cb3){
                        console.log("no CB checked");
                        tr[i].style.display = "none";
                    }
                    else if(cbs.cb1){
                        console.log("CB1 checked");
                        if (td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td4.innerHTML.toUpperCase().includes('TREATMENT')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////

            else{
                console.log("radio != all");
                if(textFilter !== ''){
                    console.log("tekst != null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('DIAGNOSTIC') || td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('OTHER') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if((!cbs.cb1 && !cbs.cb2 && !cbs.cb3)){
                        console.log("no CB checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1){
                        console.log("CB1 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('TREATMENT')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////


                else{
                    console.log("tekst = null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('DIAGNOSTIC') || td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('OTHER') || td4.innerHTML.toUpperCase().includes('DIAGNOSTIC'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes('TREATMENT') || td4.innerHTML.toUpperCase().includes('OTHER'))) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if((!cbs.cb1 && !cbs.cb2 && !cbs.cb3)){
                        console.log("no CB checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1){
                        console.log("CB1 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('DIAGNOSTIC')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('TREATMENT')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes('OTHER')) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }

            }
        }
    }
}

function radioValue() {
    if(document.forms["gForm"]["gType"][0].checked === true){
        return 'all';
    }
    else if(document.forms["gForm"]["gType"][1].checked === true){
        return 'Patients';
    }
    else{
        return 'Doctors';
    }
}

function checkboxValue() {
    let cbs = {
        cb1: document.getElementById("typeADiagnostic").checked,
        cb2: document.getElementById("typeATreatment").checked,
        cb3: document.getElementById("typeAOther").checked
    };

    return cbs;
}

function resetFilters() {
    document.getElementById("gName").value = '';

    document.forms["gForm"]["gType"][0].checked = true;
    document.forms["gForm"]["gType"][1].checked = false;
    document.forms["gForm"]["gType"][2].checked = false;

    document.getElementById("typeADiagnostic").checked = false;
    document.getElementById("typeATreatment").checked = false;
    document.getElementById("typeAOther").checked = false;

    let table, tr, td, i;
    table = document.getElementById("graphTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";
    }
}