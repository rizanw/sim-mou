@component('mail::message')
# Reminder: Today's Expired Document!        
Hi, team!     
Below is the documents that expired by today:
@foreach($documents as $document)
- {{$document->number}}: {{$document->title}}    
@endforeach
@endcomponent