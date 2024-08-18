@extends('layouts.main')
@section('content')
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="card collapsed-card">
			<div class="card-header">
				<h1 class="card-title">@foreach($competition as $item){{$item->name}}@endforeach</h1>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-plus"></i>
					</button>
				</div>
			</div>
			<div class="card-body" style="display: none;">
				@foreach($competition as $item)Дата начала:{{ \Carbon\Carbon::parse($item->date_start)->format('d.m.Y')}}@endforeach
			</div>
		</div>

	</div>
	<!-- /.content-header -->
	<section class="content">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif
		@foreach ($competitors as $competitor)
		<div @if($competitor->gender == 'мужской')class="card card-primary collapsed-card" @else class="card card-danger collapsed-card" @endif>
			<div class="card-header">
				<h3 class="card-title">{{$competitor->secondname}} {{$competitor->firstname}} {{$competitor->patronymic}}</h3><br>
				@if($competitor->gender == 'мужской')
					<i class="fas fa-male"></i>
				@else
					<i class="fas fa-female"></i>
				@endif - {{$competitor->agecategory->name}}, {{$competitor->weightcategory->name}}, {{$competitor->tehkvalgroup->name}}
				Тренер: {{$competitor->coach->secondname}} {{substr($competitor->coach->firstname, 0,2)}}. {{substr($competitor->coach->patronymic, 0, 2)}}.
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-plus"></i>
					</button>
				</div>
			</div>
			<div class="card-body" style="display: none;">
				<b>Дата рождения: </b> {{ \Carbon\Carbon::parse($competitor->date_of_birth)->format('d.m.Y')}}<br>
				<b>Вес: </b>{{$competitor->weight}}<br>
				<b>Техническая квалификация: </b>{{$competitor->tehkval->name}}<br>
				<b>Спортивная квалификация: </b>{{$competitor->sportkval->fullname}}<br>
			</div>

		</div>
			@endforeach
	</section>
{{--    {{dd($pair)}}--}}
    <header class="hero">
        <div class="hero-wrap">
            <p class="intro" id="intro">flexbox</p>
            <h1 id="headline">Tournament</h1>
            <p class="year"><i class="fa fa-star"></i> 2015 <i class="fa fa-star"></i></p>
            <p>Ballin' Outta Control</p>
        </div>
    </header>

    <section id="bracket">
        <div class="container">
            @foreach($pair as $item)
                @if($loop->first)
            <div class="split split-one">
                <div class="round round-one current">
                    <div class="round-details">Round 1<br/><span class="date">March 16</span></div>
                    @foreach($item as $a)
                    <ul class="matchup">
                        @foreach($a as $b)
                        <li class="team team-top">{{$b['secondname']}}<span class="score">{{$b['lot']}}</span></li>
                        @endforeach
                    </ul>
                    @endforeach
                </div>	<!-- END ROUND ONE -->
            </div>
                @endif
                    @if($loop->last)
            <div class="split split-two">
                <div class="round round-one current">
                    <div class="round-details">Round 1<br/><span class="date">March 16</span></div>
                    @foreach($item as $a)
                    <ul class="matchup">
                            @foreach($a as $b)
                            <li class="team team-top">{{$b['secondname']}}<span class="score">{{$b['lot']}}</span></li>
                            @endforeach
                    </ul>
                    @endforeach
                </div>	<!-- END ROUND ONE -->
            </div>
                    @endif
                @endforeach
        </div>
    </section>
    <section class="share">
        <div class="share-wrap">
            <a class="share-icon" href="https://twitter.com/_joebeason"><i class="fa fa-twitter"></i></a>
            <a class="share-icon" href="#"><i class="fa fa-facebook"></i></a>
            <a class="share-icon" href="#"><i class="fa fa-envelope"></i></a>
        </div>
    </section>

@endsection

