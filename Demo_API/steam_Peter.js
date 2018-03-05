var jcontent = {

		
				"steamid": "76561198065539419",
				"communityvisibilitystate": 3,
				"profilestate": 1,
				"personaname": "(#)Lewd",
				"lastlogoff": 1520107033,
				"profileurl": "http://steamcommunity.com/profiles/76561198065539419/",
				"avatar": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b6/b6a7e68aff8dc582aed756b331e6185b77ad583b.jpg",
				"avatarmedium": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b6/b6a7e68aff8dc582aed756b331e6185b77ad583b_medium.jpg",
				"avatarfull": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b6/b6a7e68aff8dc582aed756b331e6185b77ad583b_full.jpg",
				"personastate": 1,
				"realname": "Peter",
				"primaryclanid": "103582791435167561",
				"timecreated": 1340041341,
				"personastateflags": 0
			
		
		
	}
var output = document.getElementById('output');

output.innerHTML= jcontent.personaname + ' ' + jcontent.steamid + ' ' + jcontent.realname;