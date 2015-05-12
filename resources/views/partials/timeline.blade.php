<ul>
    @foreach($timeline as $year => $months)
        <?php 
            $first_month = key($months);
            $first_day = key(current($months)); 

        ?>
        <li class="timeline-year">
            <a href="{{ URL::to("/$chan/" . "$year-$first_month-$first_day") }}">{{ $year }}</a>
            <ul>
                @foreach($months as $month => $days)
                    <?php $day = key($days);?>
                    <li class="timeline-month">
						<a href="{{ URL::to("/$chan/" . "$year-$month-$day") }}">{{ Carbon::createFromDate(2012, $month)->format('F') }}</a>
                        <ul>
                            @foreach($days as $day => $date)
                                @if (Str::contains(URL::full(), $date->format('Y-m-d')) or $date->format('Y-m-d') == date('Y-m-d'))
                                    <li class="timeline-day current">
                                @else
                                    <li class="timeline-day">
                                @endif
                                    <a href="{{ URL::to("/$chan/" . $date->format('Y-m-d')) }}">
                                        {{ $date->format('d l') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
