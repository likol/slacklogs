<?php  namespace Message;

class Repository
{
    /**
     * Number of messages to load above the requested date
     *
     * @var int
     */
    public static function getLimit()
    {
        return (int)\Config::get('app.MESSAGES_LIMIT');
    }
    /**
     * Covert Eloquent Collection to Array
     *
     * @param $collection
     * @return array
     */
    public static function convertCollection($collection)
    {
        $sets = [];
        foreach($collection as $item) {
            $sets[] = $item;
        }

        return $sets;
    }

    /**
     * Get latest messages
     *
     * @param \Channel $channel
     *
     * @return array
     */
    public static function getLatest(\Channel $channel)
    {
        $messages = \Message::where('channel', $channel->sid)
            ->take(self::getLimit())
            ->orderBy('ts', 'desc')->get();
        
        $messages = array_reverse(self::convertCollection($messages));

        return [
            end($messages),
            $messages,
            count($messages) == self::getLimit() ? reset($messages)->_id : null
        ];
    }

    /**
     * Get logs around $timestamp
     *
     * @param \Channel $channel
     * @param DateTime $date
     *
     * @return array
     */
    public static function getAroundDate(\Channel $channel, \DateTime $date)
    {
        $timestamp = $date->getTimestamp();

        $messages = \Message::where('channel', $channel->sid)
            ->where('ts', '>=', "$timestamp")
            ->take(self::getLimit())
            ->orderBy('ts', 'asc')->get();

        $messages = self::convertCollection($messages);

        $previousMessages = \Message::where('channel', $channel->sid)
            ->where('ts', '<', "$timestamp")
            ->take(self::getLimit())
            ->orderBy('ts', 'desc')->get();

        $previousMessages = array_reverse(self::convertCollection($previousMessages));

        return [
            reset($messages),
            array_merge($previousMessages, $messages),
            count($previousMessages) == self::getLimit() ? reset($previousMessages)->_id : null,
            count($messages) == self::getLimit() ? end($messages)->_id : null
        ];
    }

    /**
     * Get a timeline from the first to the last message
     *
     * @param \Channel $channel
     *
     * @return array
     */
    public static function getTimeLine(\Channel $channel)
    {
        $timeline = array();
        // Fetch start and end time
        $firstMsg = \Message::where('channel', $channel->sid)->orderBy('ts', 'asc')->first();
        $lastMsg = \Message::where('channel', $channel->sid)->orderBy('ts', 'desc')->first();
        $firstDate = $firstMsg->getCarbon()->format('Y-m-d');
        $lastDate = $lastMsg->getCarbon()->format('Y-m-d');

		// Loop and add to timeline
        while(strtotime($firstDate) <= strtotime($lastDate)) {
            $oneDay = array((string)strtotime($firstDate), (string)strtotime("+1 day", strtotime($firstDate)));
            $haveDate = \Message::where('channel', $channel->sid)
		    ->whereBetween('ts', $oneDay)
		    ->count();
            list($year, $month, $day) = explode('-', $firstDate);
            if ($haveDate)
            {
                $timeline[$year][$month][$day] = \Carbon::createFromDate($year, $month, $day);
            }
            $firstDate = date('Y-m-d', strtotime("+1 day", strtotime($firstDate)));
        }
    
        return $timeline;
    }

    public static function textSearch(\Channel $channel, $q)
    {
        $results = \Message::where('channel', $channel->sid)
            ->where('text', 'like', "%$q%")
            ->take(self::getLimit())
            ->orderBy('ts', 'desc')
            ->get();

        return self::convertCollection($results);
    }


}