import sys 
import textwrap
from PIL import Image, ImageDraw, ImageFont

image = Image.open(sys.argv[5])
draw = ImageDraw.Draw(image)
# desired size 
font = ImageFont.truetype('http://sneh.eygb.me/assets/common/images/image_script/GeoSlb712MdBTBold.ttf', size=50)
font2 = ImageFont.truetype('http://sneh.eygb.me/assets/common/images/image_script/Gelasio-Regular.ttf', size=28)
font3 = ImageFont.truetype('http://sneh.eygb.me/assets/common/images/image_script/GeoSlb712MdBTBold.ttf', size=90)
# starting position of the message
bounding_box = [930, 350, 1040, 450]
x1, y1, x2, y2 = bounding_box
logo_box = [30,40,270,260]
rec_box = [30,280,220,370]
p1,q1,p2,q2 = rec_box
job_title = sys.argv[2]
company_name = sys.argv[1]
icon_path = sys.argv[4]
canvas_name = sys.argv[3]
color = 'rgb(0, 0, 0)' # black color
# draw the message on the background
wrapper = textwrap.TextWrapper(width=25) 
word_list = wrapper.wrap(text=company_name) 
w, h = draw.textsize(job_title, font=font)
m, n = draw.textsize(company_name, font=font)
x = (x2 - x1 - w)/2 + x1
y = (y2 - y1 - h)/2 + y1
i = 0; 
# Print each line. 
for element in word_list: 
    i = i+26
    draw.text((10, 250+i), element.center(25), fill=color, font=font2,width=30)
draw.text((x, y), job_title,align='center', fill=color, font=font)    
if icon_path == '':
    draw.rectangle(logo_box,fill ="#87ceeb", outline ="#ffff")
    draw.text((110,110,120,120), canvas_name,align='center', fill='#ffff', font=font3)
    draw = ImageDraw.Draw(image)
    image.save('image_final.png', optimize=True, quality=100)
    print(1)
else:
    icon = Image.open(icon_path)
    icon = icon.resize((250,250), Image.NEAREST)
    back_img = image.copy()
    back_img.paste(icon, (30,30))  
    draw = ImageDraw.Draw(back_img)
    back_img.save('image_final.png', optimize=True, quality=100)
    print(1)
      	