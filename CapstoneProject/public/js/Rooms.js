function TransferRoom(ReservationID){
    localStorage.setItem("ReservationID", ReservationID);
    window.location.href = '/ChooseRooms/'+ReservationID;
}