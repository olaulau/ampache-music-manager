# TODO

## features
- bulk
    - check directory structure
    - rename "m4a by laulau" format in albums with "aac by laulau"
    - add format to album without format tag
    - add year to album without year tag
    - detect duplicate albums (different format, nearly same name ...)
- find infos from a music DB
    - check artist name
    - check album name
    - find missing albums form an artist -> link to download
- compare (2 libraries)
    - encode from loseless to encoded dir
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
