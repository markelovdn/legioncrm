<table>
    <thead>
    <tr>
        <th>Пол</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Сумма оплаты</th>
        <th>Дата оплаты</th>
        <th>Тренер</th>
        <th>ФИО родителя</th>
        <th>Телефон</th>
        <th>Св-во о рождении</th>
        <th>Адрес</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>@if($user->athlete->gender == 1) мужской @else женский @endif</td>
            <td>{{$user->secondname}} {{$user->firstname}} {{$user->patronymic}}</td>
            <td>{{date('d.m.Y', strtotime($user->date_of_birth))}}</td>
                @if ($user->payments->where('paymenttitle_id', $paymenttitle->id)->count() != 0)
                    @foreach ($user->payments->where('paymenttitle_id', $paymenttitle->id) as $payment)
                        <td>{{$payment->sum}}</td>
                        <td>{{date('d.m.Y', strtotime($payment->date))}}</td>
                    @endforeach
                    @else
                    <td>не оплачено</td>
                    <td>не оплачено</td>
                @endif
            <td>
                @foreach ($user->athlete->coaches as $coach)

                    @if($coach->pivot->coach_type == \App\Models\Coach::REAL_COACH)
                        {{$coach->user->secondname}} {{mb_substr($coach->user->firstname,0,1)}}.{{mb_substr($coach->user->patronymic,0,1)}}.
                    @endif
                @endforeach
            </td>

                @foreach ($user->athlete->parenteds as $parented)
                <td>
                    {{$parented->user->secondname}} {{$parented->user->firstname}} {{$parented->user->patronymic}}
                </td>
                <td>
                {{$parented->user->phone}}
                </td>
                @endforeach

            <td>@if ($user->athlete->birthcertificate)
                {{$user->athlete->birthcertificate->series}} №{{$user->athlete->birthcertificate->number}}
                    @endif
            </td>
            <td>@if ($user->address)
                    @foreach($user->address as $address)
                        {{$address->address}}
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
