function ShowModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "block";
}

function HideModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "none";
}

function ShowModalEditContact(ContactID, ContactName, ContactDetails, ContactStatus){
    document.getElementById("DivModalEditContact").style.display = "block";
    document.getElementById("EditContactID").value = ContactID;
    document.getElementById("EditContactName").value = ContactName;
    document.getElementById("EditContactDetails").value = ContactDetails;
    document.getElementById("EditContactStatus").value = ContactStatus;
    document.getElementById("OldContactName").value = ContactName;
}

function HideModalEditContact(){
    document.getElementById("DivModalEditContact").style.display = "none";
}

function ShowModalDeleteContact(ContactID){
    document.getElementById("DivModalDeleteContact").style.display = "block";
    document.getElementById("DeleteContactID").value = ContactID;
}

function HideModalDeleteContact(){
    document.getElementById("DivModalDeleteContact").style.display = "none";
}