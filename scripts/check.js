"use strict";

const planForm = document.getElementById("planForm");
const pChange = document.getElementById("change");
const pNoChange = document.getElementById("noChange");

const planFormVals = new Set();

planFormValsCheck(planFormVals);

planForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const changeMsgs = document.getElementsByClassName("changeMsg");

    for(let i = 0; i< changeMsgs.length; i++){
        changeMsgs[i].style.display = "none";
    }

    planFormValsCheck(planFormVals);

    // no changes made if size of set remains 4
    if(planFormVals.size === 4){
        pNoChange.style.display = "block";
    } else {
        pChange.style.display = "block";
        setTimeout(() => planForm.submit(), 2000);
    }
})

// add for values in a set
function planFormValsCheck(vals){
    for (let i = 0; i < 4; i++){
        vals.add(planForm.elements[i].value);
    }
}