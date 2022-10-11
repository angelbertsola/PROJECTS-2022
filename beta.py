import tkinter as tk
import requests
import time
from random import choice
from PIL import Image,ImageTk


ask = ["Hi","Hey"]
hi = ["Hi","Do you want the weather ?","Can I Display the weather ?"]
huf = ["Goodbye"]
puppy = ["Goodbye ", "Thank You for using Weather Spaces","See you later"]
sq = ["Yes","Yeah","Sure","Ok","Why not","Ok Daddy"]
qs = ["Please enter the city below"]
rp = ["What is the weather for this location"]
pr = ["Enter location below please"]
hr = ["Who are you", "What is your name"]
rh = ["I am a chatbot created three Masterminds Immanuel , Devendra and Abdelnour","Hello I am Weather Spaces"]
emotion = ["What is the weather on this date?", "Can I check on this Date?"]
thought = ["The weather is on this Date", "The weather for the next 3 days"]
express = ["What clothes should I bring ", "Recommended clothing","What type of clothing","What clothing","What clothes"]
press = ["Check below at recommended clothes ","You should bring a Carhartt jacket" ,"Tommy jeans and converse one star", " A Spaces T Shirt dickies 874"]
ty = ["Can I check another location"]
vx = ["Yes Enter location below please"]
lara = ["How are you"]
manny = ["I am great thank you !, how are you :)?"]
error = ["sorry, I don't understand ", "what did you say?", "can't recognise"]


def getWeather(canvas):

    ###user = tk.StringVar()
    ##bot = tk.StringVar()

    #tk.Label(canvas, text=" user : ").pack()
    #tk.Entry(canvas, textvariable=user).pack()
    #tk.Label(canvas, text=" Bot  : ").pack()
    #tk.Entry(canvas, textvariable=bot).pack()

    city = textField.get()

    api = "https://api.openweathermap.org/data/2.5/weather?q=" + city + "&appid=06c921750b9a82d8f5d1294e1586276f"

    json_data = requests.get(api).json()
    condition = json_data['weather'][0]['main']
    temp = int(json_data['main']['temp'] - 273.15)
    min_temp = int(json_data['main']['temp_min'] - 273.15)
    max_temp = int(json_data['main']['temp_max'] - 273.15)
    pressure = json_data['main']['pressure']
    humidity = json_data['main']['humidity']
    wind = json_data['wind']['speed']
    sunrise = time.strftime('%I:%M:%S', time.gmtime(json_data['sys']['sunrise'] - 21600))
    sunset = time.strftime('%I:%M:%S', time.gmtime(json_data['sys']['sunset'] - 21600))

    final_info = condition + "\n" + str(temp) + "°C"
    final_data = "\n" + "Min Temp: " + str(min_temp) + "°C" + "\n" + "Max Temp: " + str(
        max_temp) + "°C" + "\n" + "Pressure: " + str(pressure) + "\n" + "Humidity: " + str(
        humidity) + "\n" + "Wind Speed: " + str(wind) + "\n" + "Sunrise: " + sunrise + "\n" + "Sunset: " + sunset
    label1.config(text=final_info)
    label2.config(text=final_data)


canvas = tk.Tk()
canvas.geometry("1000x800")
canvas.title("Weather SPACES App")
background_image = tk.PhotoImage(file='landscape.png')
background_label = tk.Label(canvas, image=background_image)
background_label.place(relwidth=1, relheight=1)
f = ("poppins", 15, "bold")
t = ("poppins", 35, "bold")

def showMsg():
    question = user.get()
    if question in ask:
        bot.set(choice(hi))
    elif question in huf:
        bot.set(choice(puppy))
    elif question in sq:
        bot.set(choice(qs))
    elif question in rp:
        bot.set(choice(pr))
    elif question in hr:
        bot.set(choice(rh))
    elif question in emotion:
        bot.set(choice(thought))
    elif question in express:
        bot.set(choice(press))
    elif question in ty:
        bot.set(choice(vx))
    elif question in lara:
        bot.set(choice(manny))

    else:
        bot.set(choice(error))

user = tk.StringVar()
bot = tk.StringVar()

tk.Label(canvas, text=" User : ",width= 13 , height = 2, bg= "black",fg="yellow").pack()
tk.Entry(canvas, textvariable=user).pack()
tk.Label(canvas, text=" Bot  : ",width= 13 , height = 2, bg= "black",fg="yellow").pack()
tk.Entry(canvas, textvariable=bot).pack()
tk.Button(canvas, text="Talk", width= 13 , height = 2, bg= "black" ,fg="black", command=showMsg).pack()


textField = tk.Entry(canvas, justify='center', width=20, font=t)
textField.pack(pady=20)
textField.focus()
textField.bind('<Return>', getWeather)


label1 = tk.Label(canvas, font=t)
label1.pack()
label2 = tk.Label(canvas, font=f)
label2.pack()
label3 = tk.Label(canvas,text ="RECOMMENDED CLOTHING", width= 26 , height = 2, bg= "black",fg="yellow")
label3.pack()

#Sunny.png
img = tk.PhotoImage(file="sunny (1).png")
label4 = tk.Label(canvas, image=img)
label4.pack(padx=5, pady=15, side=tk.LEFT)

#rain.png
img1 = tk.PhotoImage(file="rain.png")

label5 = tk.Label(canvas, image=img1)
label5.pack(padx=5, pady=15, side=tk.LEFT)

#wind.png
img2 = tk.PhotoImage(file="wind.png")

label6 = tk.Label(canvas, image=img2)
label6.pack(padx=5, pady=15, side=tk.LEFT)



#label4 = tk.Label(canvas, image=photo, width=233.3, height =200)
#label4.pack()

canvas.mainloop()
