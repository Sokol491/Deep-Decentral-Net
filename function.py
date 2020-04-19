def h1(text,align):
    print('<h1 align="' + align + '">' + text + '</h1>')
    
def p(text,align):
    print('<p align="' + align + '">' + text + '</p>')
    
def img(link,align,width,height):
    print('<p align="' + align + '"><img src="' + link + '" width="' + width + '" height="' + height + '"></p>')
    
def btn(text,link,align,img,width,height):
    print('<a href="' + link + '" target="_blank"><p align="' + align + '"><button>')
    if img!='':
    print('<img src="' + img + '" style="vertical-align: middle" width="' + width + '" height="' + height + '">')
    print(text + '</button></p></a>')