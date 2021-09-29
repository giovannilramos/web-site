@extends('layouts.main')
@section('title', $events->title)
@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/events/{{$events->image}}" class="img-fluid" alt="{{$events->title}}">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{$events->title}}</h1>
                <p class="event-city"><ion-icon name="location-outline"></ion-icon> {{$events->city}} </p>
                <p class="event-participants"><ion-icon name="people-outline"></ion-icon>Participantes: {{count($events->users)}}</p>
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon>{{$eventOwner['name']}}</p>
                  @if(!$hasUserJoined)
                    <form action="/events/join/{{$events->id}}" method="POST">
                        @csrf
                        <a 
                        href="/events/join/{{$events->id}}" 
                        class="btn btn-primary"
                        id="event-submit"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                            Confirmar Presença
                        </a>
                    </form>
                    @else
                        <h3 class="alert alert-warning">Você já está participando desse evento!</h3>
                    @endif
                <h3>O evento conta com:</h3>
                <ul id="items-list">
                    @foreach($events->items as $item)
                    <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento</h3>
                <p class="event-description">{{$events->description}} </p>
            </div>
        </div>
    </div>

@endsection