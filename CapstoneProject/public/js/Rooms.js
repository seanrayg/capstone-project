function TransferRoom(ReservationID){
    localStorage.setItem("ReservationID", ReservationID);
    window.location.href = '/ChooseRooms/'+ReservationID;
}

function UpgradeRoom(ReservationID, RoomType, RoomName){
    localStorage.setItem("ReservationID", ReservationID);
    localStorage.setItem("RoomType", RoomType);
    localStorage.setItem("RoomName", RoomName);
    window.location.href = "/UpgradeRoom/"+ReservationID+"/"+RoomType+"/"+RoomName;
}

