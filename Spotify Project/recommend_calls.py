#!C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe

import cgi


form = cgi.FieldStorage()
id = form.getvalue("id")


print("Content-Type: text/html") 
print("Location: recommend_music.php?result={}".format(id))
print()   