<div class="card">
    <div class="card-header">
        <h3>Dear {{$name}}</h3>
    </div>
    <div class="card-body">
        <div>
            <h3> Your booking has been Canceled</h3>
            <h4>Booking Reference Code : {{$refCode}} </h4>
            <h4>Booking Date : {{$duoDate}} </h4>

            <h3>Please contact with admin to know cancel reason</h3>
            <h3>Email : {{ config('mail.from.address') }} </h3>
            <h3>Thank You</h3>
        </div>
    </div>
    <div class="card-footer bg-whitesmoke">
        <b>  {{ config('app.name') }}</b>
    </div>
</div>
