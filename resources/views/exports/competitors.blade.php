<table>
    <thead>
    <tr>
        <th>Пол</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Возрастная категория</th>
        <th>Гып</th>
        <th>Группа</th>
        <th>Вес</th>
        <th>Тренер</th>
    </tr>
    </thead>
    <tbody>
    @foreach($competitors as $competitor)
        <tr>
            <td>@if($competitor->athlete->gender == 1) мужской @else женский @endif</td>
            <td>{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}} {{$competitor->athlete->user->patronymic}}</td>
            <td>{{date('d.m.Y', strtotime($competitor->athlete->user->date_of_birth))}}</td>
            <td>{{$competitor->agecategory->title}}</td>
            <td>{{$competitor->athlete->tehkval->last()->title}}</td>
            <td>{{$competitor->tehkvalgroup->title}}</td>
            <td>{{$competitor->weight}}</td>
            <td>
                @foreach($competitor->athlete->coaches as $coach)
                    {{$coach->user->secondname}} {{$coach->user->firstname}}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
