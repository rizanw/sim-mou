@component('mail::message')
# Reminder: Document(s) that will be expired soon!        
Hi, team!     
Below is the document(s) that will be expired:
@foreach ($documents as $document)
- {{$document->number}}: {{$document->title}} ({{$curDate->diff($document->end_date)->format('%a')}}day(s) left)
@endforeach
@endcomponent