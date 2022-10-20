@extends('layouts.main')
@section('content')
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Список актуальных соревнований</h1>
				</div><!-- /.col -->
				<!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<section class="content">
		@foreach ($competitions as $competition)
			<div class="card card-danger collapsed-card shadow-lg">
				<div class="card-header">
					<h3 class="card-title"><b>{{$competition->name}}</b></h3><br>
					<p>Начало: {{ \Carbon\Carbon::parse($competition->date_start)->format('d.m.Y')}}</p>
					Участники: <a href="/competitors/?competition_id={{$competition->id}}"><i class="nav-icon fas fa-users"></i>
					</a><br>
					Добавить: <a href="/addcompetitor/?competition_id={{$competition->id}}"><i class="nav-icon fas fa-user-plus"></i></a><br>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-plus"></i>
						</button>
					</div>

				</div>

				<div class="card-body" style="display: none;">
					<b>Место проведения: </b>{{$competition->place}}<br>
					<b>Дата начала: </b>{{ \Carbon\Carbon::parse($competition->date_start)->format('d.m.Y')}}<br>
					<b>Дата окончания: </b>{{ \Carbon\Carbon::parse($competition->date_finish)->format('d.m.Y')}}<br>
					<b>Зарегестированно всего: </b>{{ count($competitors)}}<br>
				</div>

				<div class="card-footer">
					<a href="/editcompetition/?competition_id={{$competition->id}}"><i class="fas fa-wrench"></i></i>
				</div>

			</div>
	@endforeach
	<!-- /.card-body -->
		</div>
		<!-- /.card -->
		</div>
		<!-- /.col -->
		</div>
		<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>
@endsection

