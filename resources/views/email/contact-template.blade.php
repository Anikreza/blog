@component('mail::message')
    <h2>Hello Admin,</h2>
    <p>You received an email from : <b>{{ $data['name'] }}</b></p>
    <p>Here are the details:</p>
    <b>Name:</b> {{ $data['name'] }} <br>
    <b>Email:</b> {{ $data['email'] }} <br>
    <b>Subject:</b> {{ $data['subject'] }} <br>
    <b>Message:</b> <br/> {!! nl2br($data['message']) !!}
    <br/>

    -  Thank You, {{ env('APP_NAME') }}
@endcomponent
