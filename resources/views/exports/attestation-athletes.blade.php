<table>
    <thead>
    <tr>
        <th>Пол</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Претендует на гып</th>
        <th>Тренер</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attestation->athletes as $athlete)
        <tr>
            <td>@if($athlete->gender == 1) мужской @else женский @endif</td>
            <td>{{$athlete->user->secondname}} {{$athlete->user->firstname}} {{$athlete->user->patronymic}}</td>
            <td>{{date('d.m.Y', strtotime($athlete->user->date_of_birth))}}</td>
            <td>{{\App\BusinessProcess\GetAttestationAthletes::getNextTehkval($athlete->id)}}</td>
            <td>
                @foreach($athlete->coaches as $coach)
                    {{$coach->user->secondname}} {{$coach->user->firstname}}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
