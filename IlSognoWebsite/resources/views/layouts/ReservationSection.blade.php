<div class="section" filter-color="orange" data-parallax="true" style="background-image: url('/img/book-now3.jpg');">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6">
                <!-- Nav tabs -->
                <div class="card">
                    <div class="card-block">
                        <div class="team-player">
                            <h4 class="title text-default">Book Now!</h4>
                            <p>What are you waiting for? Book now! More exciting adventures are waiting for you</p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#ReservationModal">Book a reservation</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Tabs with Background on Card -->
                <div class="card">
                    <div class="card-block">
                        <div class="team-player">
                            <h4 class="title text-default">Already have a reservation?</h4>
                            <p>Click here to manage or view your reservation</p>
                            <a href="/Login"><button class="btn btn-primary">Click Here</button></a>
                        </div>
                    </div>
                </div>
                <!-- End Tabs on plain Card -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ReservationModal" tabindex="-1" role="dialog" aria-labelledby="PromptPackage" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <h4 class="modal-title" id="PromptPackage">Would you like to avail a package?</h4>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-12 text-center">
                <a href="/BookPackages"><button type="button" class="btn btn-primary btn-simple">Yes</button></a>
                <a href="/BookReservation"><button type="button" class="btn btn-primary btn-simple">No</button></a>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>