@component('mail::message')
Hi, team! <br />
Below is the documents that expired by today:
@foreach($documents as $document)
**{{ $document->number }}: ** {{ $document->title }}
@endforeach
@endcomponent