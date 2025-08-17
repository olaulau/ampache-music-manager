# TODO

## most important :
- songs tags
	- scan process which stores all ongs tas into a separate db table (song_meta : song_id, meta, value)
- songs with wierd character in filename / tags
    - make a filename generator which removes wierd chars
- songs without tags -> auto tag
- songs with bad format dates
- songs by codec + bitrate -> detect bad songs
- songs without cover -> download cover.jpg into album folder


## other features
- bulk
    - check directory structure
    - add format to album without format tag
    - add year to album without year tag
    - detect duplicate albums (different format, nearly same name ...)
- find infos from a music DB
    - check artist name
    - check album name
    - find missing albums form an artist -> link to download
- compare (2 libraries)
	- ...
- id3 tags
    - find files without id3 tags
    - get tags from a DB
    - find mp3 with low quality -> link to download

### structure :
root path
	gallery (laulau_encoded)
		type (albums)
			artist
				[album]
					[cd]
						media file

### créer une classe MediaLibrary qui sache gérer tout ca



max_input_vars high :
- dynamically check value
- document in README check php.ini

- function to initialise unbuffered  response
- function for sending flushed to browser



- ampache : l'action "update" d'un catalog semble bien faire tout, et rapidement (add, remote, update tags ...)
=> à tester pour les covers


- affichages
	logger en parallèle, car comme c'est très long on peut perdre le fil (le serveur web aussi) et ce serait bien d'avoir tout dans les logs


- encoding
	multithreading for each file ?

