/**
 * Created by Nermin on 29. 06. 2018.
 */

// console.log("filter.js loaded");
dc = {};
dc["en"] = ['Yes', 'No', 'Open', 'Closed', 'DIAGNOSTIC', 'TREATMENT', 'OTHER', 'Patients', 'Doctors', 'all'];
dc["sl"] = ['Da', 'Ne', 'Odprt', 'Zaprt', 'DIAGNOSTICIRANJE', 'ZDRAVLJENJE', 'DRUGO', 'Bolnikom', 'Zdravnikom', 'vsi'];
window.onload = function () {
    try {
        ln = document.getElementById('myLanId').innerText.trim();
    } catch(e) {
        //console.log(e);
    }
}

function filterTable() {

    let radioInput, radioFilter, textInput, textFilter, cb1, cb2, cb3, table, tr, td2, td3, td4, tdc, i;

    let cbs = checkboxValue();

    radioInput = radioValue();

    let curated = curatedValue();
    console.log('CURATED:', curated);

    radioFilter = radioInput.toUpperCase();

    textInput = document.getElementById("gName");
    textFilter = textInput.value.toUpperCase();

    table = document.getElementById("graphTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td3 = tr[i].getElementsByTagName("td")[4];
        td2 = tr[i].getElementsByTagName("td")[2];
        td4 = tr[i].getElementsByTagName("td")[5];
        tdc = tr[i].getElementsByTagName("td")[3];
        if (td2 && td3 && td4) {
            console.log("Got all table cells");
            if(radioInput === dc[ln][9]){
                console.log("radio = all");
                if(textFilter !== ''){
                    console.log("Tekst != null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][4]) || td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][6]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
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
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][5])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
                else{
                    console.log("tekst = null");
                    if(cbs.cb1 && cbs.cb2 && cbs.cb3){
                        console.log("all CB checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][4]) || td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][6]) || td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
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
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][5])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
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
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][4]) || td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][6]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if((!cbs.cb1 && !cbs.cb2 && !cbs.cb3)){
                        console.log("no CB checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1){
                        console.log("CB1 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][5])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td2.innerHTML.toUpperCase().indexOf(textFilter) > -1 && td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
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
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][4]) || td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb2){
                        console.log("CB1 CB2 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1 && cbs.cb3){
                        console.log("CB1 CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][6]) || td4.innerHTML.toUpperCase().includes(dc[ln][4]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2 && cbs.cb3){
                        console.log("CB2 CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && (td4.innerHTML.toUpperCase().includes(dc[ln][5]) || td4.innerHTML.toUpperCase().includes(dc[ln][6]))) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if((!cbs.cb1 && !cbs.cb2 && !cbs.cb3)){
                        console.log("no CB checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb1){
                        console.log("CB1 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][4])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb2){
                        console.log("CB2 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][5])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if(cbs.cb3){
                        console.log("CB3 checked");
                        if (td3.innerHTML.toUpperCase().indexOf(radioFilter) > -1 && td4.innerHTML.toUpperCase().includes(dc[ln][6])) {
                            if((curated === dc[ln][0] && tdc.innerHTML === dc[ln][0]) || curated === dc[ln][1]){
                                tr[i].style.display = "";
                            }
                            else{
                                tr[i].style.display = "none";
                            }
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
    let f = document.forms["gForm"];
    let radios = f.elements["gType"];
    console.log("radios:", radios, radios.length);

    // if radios.length is not undefined (if it's true), radios is an array and that means that there are multiple choices(All, Patients,..)
    if(radios.length){
        if (radios[0].checked === true){
            return dc[ln][9];
        }
        else if (radios[1].checked === true){
            return dc[ln][7];
        }
        else{
            return dc[ln][8];
        }
    }
    // only one radio item in radios and radio button does not have length attribute,
    // that happens only when user is not logged and on "Patients page" - in that case only algorithms for "Patients" are visible
    else { 
        return dc[ln][7]
    }
}

function curatedValue() {
    if(document.forms["gForm"]["curated"].checked === true){
        return dc[ln][0];
    }
    else{
        return dc[ln][1];
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

function filterTableCurations() {

    let table, tr, textInput, textFilter, i, td1, td4;


    let curated = curatedValue();
    if(curated === dc[ln][0]){
        curated = dc[ln][2];
    }
    else{
        curated = dc[ln][3];
    }

    textInput = document.getElementById("gName");
    textFilter = textInput.value.toUpperCase();

    table = document.getElementById("curationTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td4 = tr[i].getElementsByTagName("td")[4];
        td1 = tr[i].getElementsByTagName("td")[1];
        if (td1.innerHTML.toUpperCase().indexOf(textFilter) > -1) {
            if((curated === dc[ln][2] && td4.innerHTML === dc[ln][2]) || curated === dc[ln][3]){
                tr[i].style.display = "";
            }
            else{
                tr[i].style.display = "none";
            }
        }
        else {
            tr[i].style.display = "none";
        }
    }
}

