<?php 
class Helpers {

    public static function parseText($text)
    {
        preg_match_all('/<(.*?)>/', $text, $matches, PREG_SET_ORDER);

        if (! count($matches)) return $text;

        $fromText = [];
        $toText = [];

        foreach($matches as $match) {
            // User link case
            if (preg_match('/^@U/', $match[1])) {
                list($uid, ) = explode("|", $match[1]);
				
                $fromText[] = $match[0];       
				//if uid non-existent at db, return original uid.
				$username = ($select = User::where('sid', substr($uid, 1))->first()) == null ? "$uid" : "<strong style=\"color: #{$select->color}\">@{$select->name}</strong>";
				$toText[] = $username=='@USLACKBOT' ? '@slackbot' : $username ;
				
                continue;
            }
			
			elseif (preg_match('/^!channel/', $match[1])) {
                list($uid, ) = explode("|", $match[1]);
				
                $fromText[] = $match[0];       
				$toText[] = '@channel';
				
                continue;
            }

            elseif (preg_match('/^#C/', $match[1])) {
                list($cid, ) = explode("|", $match[1]);

                $fromText[] = $match[0];
                $toText[] = '#' . Channel::where('sid', substr($cid, 1))->first()->name;

                continue;
            }

            elseif (preg_match('/^http/i', $match[1])) {
                list($url, ) = explode("|", $match[1]);

                $fromText[] = $match[0];
                $toText[] = $url;

                continue;
            }
			
			elseif (preg_match('/^mailto/i', $match[1])) {
                list($url, ) = explode("|", $match[1]);

                $fromText[] = $match[0];
                $toText[] = substr($url, 7);

                continue;
            }
			
			else {
				return $match[1];
			}
        }

        if (count($fromText)) {
            $text = str_replace($fromText, $toText, $text);
        }

        return $text;
    }
	
	public static function parseURL($url)
	{
		$username = ($select = User::where('sid', $url->user)->first()) == null ? $url->user : "<strong>@{$select->name}</strong>";
		$text = $username;
		return $text;
	}
	
	public static function parseBOT($msg)
	{
		
		
	}
}