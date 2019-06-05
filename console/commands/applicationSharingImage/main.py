import requests
from io import BytesIO
import sys
import os
from PIL import Image, ImageDraw, ImageFont, ImageOps

def pasteImg(source, logo, new_img, text, icon, font_loc, is_url):
   src_img = Image.open(source)
   src_img_copy = src_img.copy()

   if is_url == "true":
       remote_img = requests.get(logo)
       logo_img = Image.open(BytesIO(remote_img.content))
   elif is_url == "false":
       logo_img = Image.open(logo)
   logo_img_copy = logo_img.copy()

   logo_new_size = logo_img_copy.resize((500, 500))
   logo_bigsize = (logo_new_size.size[0] * 3, logo_new_size.size[1] * 3)
   logo_mask = Image.new('L', logo_bigsize, 0)
   logo_draw = ImageDraw.Draw(logo_mask)
   logo_draw.ellipse((0,0)+logo_bigsize, fill=255)
   logo_mask = logo_mask.resize(logo_new_size.size, Image.ANTIALIAS)
   logo_new_size.putalpha(logo_mask)
   logo_output = ImageOps.fit(logo_new_size, logo_mask.size, centering=(0.5,0.5))
   logo_output.putalpha(logo_mask)
   logo_output.save('logo_output.png')
   l = Image.open('logo_output.png')
   logo_trans = Image.new("RGBA",l.size)
   logo_trans = Image.blend(logo_trans,l,1.0)
   src_img_copy.paste(logo_trans, (125,60), logo_trans)

   icon_img = Image.open(icon)
   icon_img_copy = icon_img.copy()

   icon_new_size = icon_img_copy.resize((300, 300))
   icon_new_size.save('icon_resize.png')
   i = Image.open('icon_resize.png')

   fg_img_trans = Image.new("RGBA",i.size)
   fg_img_trans = Image.blend(fg_img_trans,i,1.0)
   src_img_copy.paste(fg_img_trans, (2970,150), fg_img_trans)

   if len(text) >= 19:
       createImage(text, 1,font_loc)
       text_img = Image.open('text.png')
       text_img_copy = text_img.copy()

       text_new_size = text_img_copy.resize((1400, 300))
       text_new_size.save('text_resize.png')
       t = Image.open('text_resize.png')

       src_img_copy.paste(t, (1170,200))
   elif len(text) >= 15 and len(text) < 19:
       createImage(text, 2, font_loc)
       text_img = Image.open('text.png')
       text_img_copy = text_img.copy()

       text_new_size = text_img_copy.resize((1200, 300))
       text_new_size.save('text_resize.png')
       t = Image.open('text_resize.png')

       src_img_copy.paste(t, (1300,200))
   elif len(text) >= 10 and len(text) < 15:
       createImage(text, 2, font_loc)
       text_img = Image.open('text.png')
       text_img_copy = text_img.copy()

       text_new_size = text_img_copy.resize((1200, 300))
       text_new_size.save('text_resize.png')
       t = Image.open('text_resize.png')

       src_img_copy.paste(t, (1390,200))
   else:
       createImage(text, 3, font_loc)
       text_img = Image.open('text.png')
       text_img_copy = text_img.copy()

       text_new_size = text_img_copy.resize((1040, 300))
       text_new_size.save('text_resize.png')
       t = Image.open('text_resize.png')

       src_img_copy.paste(t, (1550,200))

   if os.path.exists('/'.join(new_img.split('/')[:-1])):
       src_img_copy.save(new_img)
   else:
       path_dir = new_img.split('/')[:-1]
       new_path = '/'
       os.makedirs(new_path.join(path_dir), mode=0o755, exist_ok=False)
       src_img_copy.save(new_img)

   os.remove('logo_output.png')
   os.remove('icon_resize.png')
   os.remove('text_resize.png')
   os.remove('text.png')
   print(True)

def createImage(text, type, font_loc):
   if type == 1:
       img = Image.new('RGB', (2500, 240), color = (255, 255, 255))
   elif type == 2:
       img = Image.new('RGB', (1700, 240), color = (255, 255, 255))
   elif type == 3:
       img = Image.new('RGB', (1000, 240), color = (255, 255, 255))
   src_img_font = ImageFont.truetype(font_loc, size=150)
   d = ImageDraw.Draw(img)
   d.text((10,10), text, fill='rgb(0, 0, 0)', font=src_img_font)
   img.save('text.png')

pasteImg(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5], sys.argv[6], sys.argv[7])